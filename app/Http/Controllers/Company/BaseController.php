<?php

namespace App\Http\Controllers\Company;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    protected $company_id = 0;
    protected $company_name = '';

    /**
     * BaseController constructor.
     * @param Request $request
     */
    function __construct(Request $request)
    {
        parent::__construct($request);

        $this->assign([
            'company_id'=>$this->company_id,
            'company_name'=>$this->company_name
        ]);
        $this->middleware(function (Request $request, $next){
            $company_id = $request->cookie('company_id');
            $company_name = $request->cookie('company_name');

            if ($this->company_id && $this->company_name) {
                $this->company_id = $company_id;
                $this->company_name = $company_name;
                $this->assign([
                    'company_id'=>$this->company_id,
                    'company_name'=>$this->company_name
                ]);
                return $next($request);
            }else {
                return redirect()->action('Company\LoginController@index');
            }
        });
    }
}
