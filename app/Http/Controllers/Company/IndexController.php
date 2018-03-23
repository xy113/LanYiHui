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
            if ($company['company_name']) {
                $company['updated_at'] = time();
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
