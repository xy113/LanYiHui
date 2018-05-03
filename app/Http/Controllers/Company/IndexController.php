<?php

namespace App\Http\Controllers\Company;

use App\Models\Company;
use App\Models\CompanyContent;

class IndexController extends BaseController
{
    /**
     *
     */
    public function index() {

        if ($this->isOnSubmit()) {
            $company = $this->request->post('company');
            $com = Company::where('company_id', $this->company_id)->first();
            if ($company['company_name']) {
                $company['updated_at'] = time();
                if($com['company_name']!=$company['company_name']||$com['company_license_no']!=$company['company_license_no']||$com['company_license_pic']!=$company['company_license_pic']||$com['status']=='-1'){
                    $company['status'] = '0';
                }elseif ($com['tel']!=$company['tel']){
                    $company['status'] = '1';
                }
                Company::where('company_id', $this->company_id)->update($company);
            }
            $content = $this->request->post('content');
            CompanyContent::where('company_id', $this->company_id)->update([
                'content'=>$content,
                'updated_at'=>time()
            ]);

            return $this->showSuccess(trans('ui.update_succeed'));

        }else {
            $company = Company::where('company_id', $this->company_id)->first();
            if ($company) {
                $this->assign(['company'=>$company]);
            }

            $content = CompanyContent::where('company_id', $this->company_id)->first();
            if ($content) {
                $this->assign(['content'=>$content]);
            }

            return $this->view('company.index');
        }
    }
}
