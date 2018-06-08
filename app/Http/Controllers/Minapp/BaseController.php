<?php

namespace App\Http\Controllers\Minapp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BaseController extends Controller
{
    /**
     * BaseController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->uid = 0;
        $this->username = '';
        $this->data = [
            'uid'=>0,
            'username'=>''
        ];

        $this->middleware(function (Request $req, $next){
            $token = $req->header('x-token');
            if ($token) {
                $userInfo = Cache::get($token);
                if (isset($userInfo['uid']) && isset($userInfo['username'])) {
                    $this->uid = $userInfo['uid'];
                    $this->username = $userInfo['username'];
                }
            }

            return $next($req);
        });
    }
}
