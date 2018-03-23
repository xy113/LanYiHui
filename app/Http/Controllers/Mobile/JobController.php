<?php

namespace App\Http\Controllers\Mobile;

use App\Models\Company;
use App\Models\CompanyContent;
use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    public function itemlist(){
        $consition = [];
        $q = $this->request->input('q');
        if ($q) $consition[] = ['j.title', 'LIKE', "%$q%"];
        $itemlist = DB::table('job AS j')->leftJoin('company AS c', 'c.company_id', '=', 'j.company_id')
            ->where($consition)
            ->select(['j.job_id', 'j.title', 'j.type', 'j.salary', 'j.place', 'j.welfare', 'j.created_at', 'j.company_id', 'c.company_name','c.company_logo'])
            ->orderBy('j.job_id', 'DESC')->paginate(10);

        $this->assign([
            'q'=>$q,
            'salary_ranges'=>trans('job.salary_ranges'),
            'pagination'=>($q ? $itemlist->appends(['q'=>$q])->links() : $itemlist->links()),
            'itemlist'=>$itemlist->map(function ($item){
                $item->welfares = unserialize($item->welfare);
                return get_object_vars($item);
            })
        ]);

        return $this->view('mobile.job.list');
    }

    public function detail($job_id){

        Job::where('job_id', $job_id)->increment('view_num');
        $job = Job::where('job_id', $job_id)->first();

        $company = Company::where('company_id', $job->company_id)->first();
        $content = CompanyContent::where('company_id', $job->company_id)->first();

        $this->assign([
            'job'=>$job,
            'welfares'=>unserialize($job->welfare),
            'company'=>$company,
            'content'=>$content,
            'salary_ranges'=>trans('job.salary_ranges')
        ]);

        return $this->view('mobile.job.detail');
    }
}
