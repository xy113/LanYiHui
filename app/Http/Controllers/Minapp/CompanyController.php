<?php

namespace App\Http\Controllers\Minapp;

use App\Models\Company;
use App\Models\CompanyContent;

class CompanyController extends BaseController
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_company()
    {
        $company_id = $this->request->input('company_id');
        $company = Company::where('company_id', $company_id)->first();
        $content = CompanyContent::where('company_id', $company_id)->first();

        return ajaxReturn([
            'company'=>$company,
            'content'=>$content
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchget_company()
    {
        $offset = intval($this->request->input('offset'));
        $count = intval($this->request->input('count'));
        !$count && $count = 20;

        $items = Company::whereIn('status',[2,3])->offset($offset)->limit($count)
            ->orderByDesc('company_id')->get()->map(function ($company){
                $company->company_logo = image_url($company->company_logo);
                return $company;
            });

        return ajaxReturn(['items'=>$items]);
    }
}
