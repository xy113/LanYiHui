<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    /**
     * LoginController constructor.
     * @param Request $request
     */
    function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(function ($req, $next){
            $company_id = Cookie::get('company_id');
            $company_name = Cookie::get('company_name');
            if ($company_id && $company_name) {
                return redirect()->action('Company\IndexController@index');
            }
            return $next($req);
        })->except('logout');
    }

    /**
     *
     */
    public function index(){

        return view('company.login', $this->data);
    }


    /**
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function check(){
        $account = $this->request->post('account');
        $password = $this->request->post('password');

        $company = Company::where('username', $account)->orWhere('mobile', $account)->orWhere('email', $account)->first();
        if ($company) {
            if ($company->password !== encrypt_password($password)) {
                return ajaxError(2, trans('company.password incorrect'));
            }else {
                return ajaxReturn(['company_id'=>$company->company_id])
                    ->withCookie(Cookie::forever('company_id', $company->company_id))
                    ->withCookie(Cookie::forever('company_name', $company->company_name));
            }
        }else {
            return ajaxError(1, trans('company.account not exists'));
        }
    }

    public function logout(){
        return redirect()->action('Company\LoginController@index')
            ->withCookie(Cookie::forget('company_id'))
            ->withCookie(Cookie::forget('company_name'));
    }
}
