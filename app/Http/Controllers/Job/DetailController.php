<?php

namespace App\Http\Controllers\Job;


use App\Models\Company;
use App\Models\CompanyContent;
use App\Models\Job;

class DetailController extends BaseController
{
    /**
     * @param $job_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($job_id){

        Job::where('job_id', $job_id)->increment('view_num');
        $job = Job::where('job_id', $job_id)->first();
        $job->welfare = unserialize($job->welfare);

        $company = Company::where('company_id', $job->company_id)->first();
        $content = CompanyContent::where('company_id', $job->company_id)->first();

        $this->assign([
            'job'=>$job,
            'company'=>$company,
            'content'=>$content,
            'salary_ranges'=>trans('job.salary_ranges')
        ]);

        return $this->view('job.detail');
    }
}
