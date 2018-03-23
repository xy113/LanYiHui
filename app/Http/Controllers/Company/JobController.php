<?php

namespace App\Http\Controllers\Company;

use App\Models\Job;

class JobController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){

        if ($this->isOnSubmit()) {

        }else {

            $itemlist = Job::where(['company_id'=>$this->company_id])->orderBy('job_id', 'DESC')->paginate(20);
            $this->assign([
                'itemlist'=>$itemlist,
                'pagination'=>$itemlist->links()
            ]);
            return $this->view('company.job');
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
                    Job::where(['company_id'=>$this->company_id,'job_id'=>$job_id])->update($job);
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
                    $job['company_id'] = $this->company_id;
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
                    'company_id'=>$this->company_id,
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
                'salary_ranges'=>trans('job.salary_ranges')
            ]);

            if ($job_id) {
                $job = Job::where('company_id', $this->company_id)->where('job_id', $job_id)->first();
                if ($job) {
                    $job->welfare = unserialize($job->welfare);
                    $this->assign(['job'=>$job]);
                }
            }

            return $this->view('company.job_publish');
        }
    }
}
