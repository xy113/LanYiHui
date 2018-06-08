<?php

namespace App\Http\Controllers\Minapp;

use App\Models\Company;
use App\Models\Job;
use Illuminate\Support\Facades\DB;

class JobController extends BaseController
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_job()
    {
        $salary_types = trans('job.salary_ranges');
        $job_id = $this->request->input('job_id');
        $job = Job::where('job_id', $job_id)->first();
        $job->welfare = unserialize($job->welfare);
        $job->created_at = @date('Y-m-d H:i', $job->created_at);
        $job->salary = $salary_types[$job->salary];
        $company = Company::where('company_id', $job->company_id)->first();

        return ajaxReturn([
            'job'=>$job,
            'company'=>$company
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchget_job()
    {
        $offset = intval($this->request->input('offset'));
        $count = intval($this->request->input('count'));
        !$count && $count = 20;

        $condition = [];
        $company_id = $this->request->input('company_id');
        if ($company_id) $condition['j.company_id'] = $company_id;

        $salary_ranges = trans('job.salary_ranges');
        $items  = DB::table('job AS j')->where($condition)->whereIn('j.status', [1,2])
            ->leftJoin('company AS c', 'c.company_id', '=', 'j.company_id')
            ->offset($offset)->limit($count)->orderByDesc('j.job_id')
            ->get(['j.*', 'c.company_name', 'c.company_logo','c.province', 'c.city', 'c.district'])
            ->map(function ($item) use ($salary_ranges){
                $item->salary = $salary_ranges[$item->salary];
                $item->welfare = unserialize($item->welfare);
                $item->company_logo = image_url($item->company_logo);
                return $item;
            });

        return ajaxReturn(['items'=>$items]);
    }
}
