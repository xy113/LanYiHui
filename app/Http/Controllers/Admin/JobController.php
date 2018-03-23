<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use App\Models\Job;
use Illuminate\Support\Facades\DB;

class JobController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(){
        if ($this->isOnSubmit()) {
            $items = $this->request->post('items');
            if ($items) {
                foreach ($items as $job_id) {
                    Job::where('job_id', $job_id)->delete();
                }
            }
            return ajaxReturn();
        }else {

            $consition = [];
            $q = $this->request->input('q');
            if ($q) $consition[] = ['j.title', 'LIKE', "%$q%"];
            $itemlist = DB::table('job AS j')->leftJoin('company AS c', 'c.company_id', '=', 'j.company_id')
                ->where($consition)
                ->select(['j.job_id', 'j.title', 'j.type', 'j.salary', 'j.place','j.num', 'j.welfare', 'j.view_num', 'j.created_at', 'j.company_id', 'c.company_name','c.company_logo'])
                ->orderBy('j.job_id', 'DESC')->paginate(10);

            $this->assign([
                'q'=>$q,
                'salary_ranges'=>trans('job.salary_ranges'),
                'pagination'=>($q ? $itemlist->appends(['q'=>$q])->links() : $itemlist->links()),
                'itemlist'=>[]
            ]);

            $itemlist->map(function ($item){
                $item->welfares = unserialize($item->welfare);
                $this->data['itemlist'][$item->job_id] = get_object_vars($item);
            });

            return $this->view('admin.job.list');
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function publish(){
        $job_id = intval($this->request->input('job_id'));
        if ($this->isOnSubmit()) {
            $job = $this->request->post('job');
            if ($job['title'] && $job['description']){

                $newwelfares = [];
                $welfares = $this->request->post('welfares');
                $welfare_types = trans('job.welfare_types');
                foreach ($welfares as $k){
                    $newwelfares[$k] = $welfare_types[$k];
                }
                $job['welfare'] = serialize($newwelfares);
                if ($job_id) {
                    $job['updated_at'] = time();
                    Job::where(['job_id'=>$job_id])->update($job);
                    return $this->showSuccess(trans('ui.update_succeed'), null, [
                        [
                            'text'=>trans('common.reedit'),
                            'url'=>url('/admin/job/publish?job_id='.$job_id)
                        ],
                        [
                            'text'=>trans('common.back_list'),
                            'url'=>url('/admin/job')
                        ]
                    ]);
                }else {
                    $job['created_at'] = time();
                    Job::insertGetId($job);
                    return $this->showSuccess(trans('ui.save_succeed'), null, [
                        [
                            'text'=>trans('common.continue_add'),
                            'url'=>url('/admin/job/publish')
                        ],
                        [
                            'text'=>trans('common.back_list'),
                            'url'=>url('/admin/job')
                        ]
                    ]);
                }
            }else {
                return $this->showError(trans('ui.invalid_parameter'));
            }
        }else {

            $this->assign([
                'job'=>[
                    'job_id'=>0,
                    'company_id'=>0,
                    'title'=>'',
                    'type'=>1,
                    'salary'=>'2',
                    'num'=>'',
                    'place'=>'',
                    'welfare'=>[],
                    'description'=>'',
                    'created_at'=>'',
                    'updated_at'=>'',
                    'deleted_at'=>'',
                    'view_num'=>0,
                    'collection_num'=>0
                ],
                'job_id'=>$job_id,
                'welfare_types'=>trans('job.welfare_types'),
                'salary_ranges'=>trans('job.salary_ranges'),
                'companylist'=>Company::select(['company_id','company_name'])->get()
            ]);

            if ($job_id) {
                $job = Job::where('job_id', $job_id)->first();
                if ($job) {
                    $job->welfare = unserialize($job->welfare);
                    $this->assign(['job'=>$job]);
                }
            }

            return $this->view('admin.job.publish');
        }
    }
}
