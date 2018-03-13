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

        $this->middleware(function (Request $request, $next){
            $this->company_id = $request->cookie('company_id');
            $this->company_name = $request->cookie('company_name');
            $this->appends([
                'company_id'=>$this->company_id,
                'company_name'=>$this->company_name
            ]);
            if ($this->company_id && $this->company_name) {
                return $next($request);
            }else {
                return redirect()->action('Company\LoginController@index');
            }
        });

        $this->appends([
            'company_id'=>$this->company_id,
            'company_name'=>$this->company_name
        ]);
    }
}
