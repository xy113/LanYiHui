<?php

namespace App\Http\Controllers\Mobile;

use App\Models\Collection;
use App\Models\Company;
use App\Models\CompanyContent;
use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    public function index(){
        $condition = [];
        $q = $this->request->get('q');
        if ($q) $condition[] = ['company_name', 'LIKE', "%$q%"];
        $itemlist = Company::where($condition)->orderBy('view_num', 'DESC')->orderBy('company_id', 'DESC')->paginate(20);

        $this->assign([
            'q'=>$q,
            'itemlist'=>$itemlist,
            'pagination'=>$itemlist->appends(['q'=>$q])->links()
        ]);

        return $this->view('mobile.company.list');
    }

    public function partner(){
        $condition = [];
        $q = $this->request->get('q');
        if ($q) $condition[] = ['company_name', 'LIKE', "%$q%"];
        $condition[] = ['status','3'];
        $itemlist = Company::where($condition)->orderBy('view_num', 'DESC')->orderBy('company_id', 'DESC')->paginate(20);

        $this->assign([
            'q'=>$q,
            'itemlist'=>$itemlist,
            'pagination'=>$itemlist->appends(['q'=>$q])->links()
        ]);

        return $this->view('mobile.company.partner');
    }

    public function detail($company_id) {

        Company::where('company_id', $company_id)->increment('view_num');
        if(Collection::where(['data_id'=>$company_id,'uid'=>$this->uid,'data_type'=>'company'])->first()){
            $collect = 1;
        }else{
            $collect = 0;
        }
        $this->assign(['collect'=>$collect]);
        $this->assign([
            'company_id'=>$company_id,
            'company'=>Company::where('company_id', $company_id)->first(),
            'content'=>CompanyContent::where('company_id', $company_id)->first(),
            'joblist'=>Job::where('company_id', $company_id)->get()
        ]);

        $jobList = Job::where('company_id', $company_id)->orderBy('job_id', 'DESC')->get();
        $jobList = $jobList->map(function ($item){
            $item->welfares = unserialize($item->welfare);
            return $item;
        });
        $this->assign(['jobList'=>$jobList, 'salary_ranges'=>trans('job.salary_ranges')]);

        return $this->view('mobile.company.detail');
    }
}
