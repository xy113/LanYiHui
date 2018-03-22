<?php

namespace App\Http\Controllers\Job;


use App\Models\Company;
use App\Models\Job;
use Illuminate\Support\Facades\DB;

class IndexController extends BaseController
{
    public function index(){


        $consition = [];
        $q = $this->request->input('q');
        if ($q) $consition[] = ['j.title', 'LIKE', "%$q%"];
        $itemlist = DB::table('job AS j')->leftJoin('company AS c', 'c.company_id', '=', 'j.company_id')
            ->where($consition)
            ->select(['j.job_id', 'j.title', 'j.type', 'j.salary', 'j.welfare', 'j.created_at', 'j.company_id', 'c.company_name'])
            ->orderBy('j.job_id', 'DESC')->paginate(20);

        $this->appends([
            'q'=>$q,
            'salary_ranges'=>trans('job.salary_ranges'),
            'pagination'=>($q ? $itemlist->appends(['q'=>$q])->links() : $itemlist->links()),
            'itemlist'=>$itemlist->map(function ($item){
                $item->welfares = unserialize($item->welfare);
                return get_object_vars($item);
            })
        ]);

        return view('job.index', $this->data);
    }
}
