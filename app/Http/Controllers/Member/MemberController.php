<?php

namespace App\Http\Controllers\Member;

use App\Member\Member;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{

    /**
     *
     */
    public function index(){
        $users = DB::table('member')->get();
        $member = new Member();
        $member->uid = 1000000000;
        $member->username = '贵州大师兄223322';
        $member->save();
        
    }
}
