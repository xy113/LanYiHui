<?php

namespace App\Http\Controllers\Company;


use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyContent;

class RegisterController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){

        return view('company.register', $this->data);
    }

    /**
     *
     */
    public function save(){
        $company_name = $this->request->post('company_name');
        $province = $this->request->post('province');
        $city = $this->request->post('city');
        $district = $this->request->post('district');
        $mobile = $this->request->post('mobile');
        $email = $this->request->post('email');
        $username = $this->request->post('username');
        $password = $this->request->post('password');
        $contact = $this->request->post('contact');

        $company_id = Company::insertGetId([
            'company_name'=>$company_name,
            'province'=>$province,
            'city'=>$city,
            'district'=>$district,
            'contact'=>$contact,
            'mobile'=>$mobile,
            'email'=>$email,
            'username'=>$username,
            'password'=>encrypt_password($password),
            'created_at'=>time()
        ]);
        CompanyContent::insert(['company_id'=>$company_id,'created_at'=>time()]);
        return $this->showSuccess(trans('company.register success'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function check(){
        $field = $this->request->post('field');
        $value = $this->request->post('value');

        if ($field && $value) {
            if ($field === 'company_name') {
                if (Company::where('company_name', $value)->count()){
                    return ajaxError(1, trans('company.company name has been occupied'));
                }
            }

            if ($field === 'mobile') {
                if (Company::where('mobile', $value)->count()) {
                    return ajaxError(1, trans('company.mobile has been occupied'));
                }
            }

            if ($field === 'email') {
                if (Company::where('email', $value)->count()) {
                    return ajaxError(1, trans('company.email has been occupied'));
                }
            }

            if ($field === 'username') {
                if (Company::where('username', $value)->count()){
                    return ajaxError(1, trans('company.username has been occupied'));
                }
            }

            return ajaxReturn();
        }else {
            return ajaxError(1, '参数错误');
        }
    }
}
