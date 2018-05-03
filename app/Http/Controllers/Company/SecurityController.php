<?php

namespace App\Http\Controllers\Company;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SecurityController extends BaseController
{
    public function index(){
        if ($this->isOnSubmit()) {
            $security = $this->request->post('security');
            $id = $this->company_id;
            $company = Company::find($id);
            if ($company['password']==encrypt_password($security['old_pwd'])){
                $company['password'] = encrypt_password($security['new_pwd']);
                $company->save();
                return ajaxReturn();
            }else{
                $res['errcode'] = '-1';
                $res['msg'] = '原密码不正确！';
                return json_encode($res);
            }
        }else {
            return $this->view('company.security');
        }
    }
}
