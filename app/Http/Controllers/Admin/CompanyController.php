<?php

namespace App\Http\Controllers\Admin;


use App\Models\Company;
use App\Models\CompanyContent;
use App\Models\Job;

class CompanyController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){

        if ($this->isOnSubmit()) {
            $items = $this->request->post('items');
            $eventType = $this->request->post('eventType');
            if ($items) {
                if($eventType == 'delete'){
                    foreach ($items as $company_id) {
                        Company::where('company_id', $company_id)->delete();
                        CompanyContent::where('company_id', $company_id)->delete();
                        Job::where('company_id', $company_id)->delete();
                    }
                }
                if($eventType=='pass'){
                    foreach ($items as $company_id){
                        Company::where('company_id',$company_id)->update(['status'=>'2']);
                    }
                }
                if($eventType=='nopass'){
                    foreach ($items as $company_id){
                        Company::where('company_id',$company_id)->update(['status'=>'-1']);
                    }
                }
                if($eventType=='partner'){
                    foreach ($items as $company_id){
                        Company::where('company_id',$company_id)->update(['status'=>'3']);
                    }
                }
            }
            return ajaxReturn();
        }else {
            $condition = [];
            $q = $this->request->get('q');
            if ($q) $condition[] = ['company_name', 'LIKE', "%$q%"];

            $status = $this->request->get('status');
            $status = is_null($status) ? 'all' : $status;
            $this->data['status'] = $status;
            $params['status'] = $status;
            if ($status !== 'all') {
                $condition[] = ['status', '=', $status];
            }

            $itemlist = Company::where($condition)->orderBy('company_id', 'DESC')->paginate(20);

            $this->assign([
                'q'=>$q,
                'status'=>$status,
                'itemlist'=>$itemlist,
                'pagination'=>$itemlist->appends(['q'=>$q])->links()
            ]);

            return $this->view('admin.company.list');
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(){

        $company_id = $this->request->get('company_id');
        if ($this->isOnSubmit()) {
            $company = $this->request->post('company');
            $company['status'] ='1';
            if ($company_id) {
                $company['updated_at'] = time();
                Company::where('company_id', $company_id)->update($company);
            }else {
                $company['created_at'] = time();
                $company_id = Company::insertGetId($company);
            }

            $content = $this->request->post('content');
            if (CompanyContent::where('company_id', $company_id)->exists()){
                CompanyContent::where('company_id', $company_id)->update([
                    'content'=>$content,
                    'updated_at'=>time()
                ]);
            }else {
                CompanyContent::insert([
                    'company_id'=>$company_id,
                    'content'=>$content,
                    'created_at'=>time()
                ]);
            }

            if ($company_id) {
                return $this->showSuccess(trans('ui.save_succeed'), null, [
                    [
                        'text'=>trans('common.reedit'),
                        'url'=>action('Admin\CompanyController@add', ['company_id'=>$company_id])
                    ],
                    [
                        'text'=>trans('common.back_list'),
                        'url'=>url('/admin/company')
                    ]
                ]);
            }else {
                return $this->showSuccess(trans('ui.save_succeed'), null, [
                    [
                        'text'=>trans('common.continue_add'),
                        'url'=>url('/admin/company/add')
                    ],
                    [
                        'text'=>trans('common.back_list'),
                        'url'=>url('/admin/company')
                    ]
                ]);
            }

        }else {

            $this->assign([
                'company_id'=>$company_id,
                'company'=>[
                    'company_name'=>'',
                    'company_logo'=>'',
                    'company_license_no'=>'',
                    'company_license_pic'=>'',
                    'province'=>'',
                    'city'=>'',
                    'district'=>'',
                    'street'=>'',
                    'contact'=>'',
                    'tel'=>'',
                ],
                'content'=>[
                    'company_id'=>'',
                    'content'=>''
                ]
            ]);

            if ($company_id) {
                $company = Company::where('company_id', $company_id)->first();
                if ($company) $this->assign(['company'=>$company]);

                $content = CompanyContent::where('company_id', $company_id)->first();
                if ($content) $this->assign(['content'=>$content]);
            }

            return $this->view('admin.company.add');
        }
    }
}
