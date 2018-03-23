<?php

namespace App\Http\Controllers\Home;

use App\Models\BlockItem;
use App\Models\Job;
use App\Models\MemberArchive;
use App\Models\PostItem;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){

        $this->assign([
            'focus_imgs'=>BlockItem::where('block_id', 10)->get(),
            'newslist'=>PostItem::where('status', 1)->limit(6)->orderBy('aid', 'DESC')->get(),
            'articleCount'=>PostItem::where('status', 1)->count(),
            'memberCount'=>MemberArchive::where('status', 1)->count(),
            'jobCount'=>Job::count()
        ]);

        $jobList = DB::table('job AS j')->leftJoin('company AS c', 'c.company_id', '=', 'j.company_id')
            ->select(['j.job_id', 'j.title', 'j.type', 'j.salary', 'j.welfare', 'j.created_at', 'j.company_id', 'c.company_name'])
            ->limit(10)->get();
        $jobList = $jobList->map(function ($item){
            $item->welfares = unserialize($item->welfare);
            return get_object_vars($item);
        });
        $this->assign(['jobList'=>$jobList, 'salary_ranges'=>trans('job.salary_ranges')]);

        $darenlist = MemberArchive::where('status', 1)->limit(5)->get();
        $this->assign(['darenlist'=>$darenlist]);

        return $this->view('home.index');
    }
}
