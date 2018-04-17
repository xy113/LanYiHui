<?php
/**
 * Created by PhpStorm.
 * User: 12394
 * Date: 2018-4-17
 * Time: 11:13
 */
namespace App\Http\Controllers\Mobile;

use App\Models\Member;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends BaseController
{
    public function index(){
        $id = $this->request->get('id');
        $isMe = false;
        if (empty($id)){
            $id = $this->uid;
            $isMe = true;
        }
        $user = Member::find($id);
        $message = Message::where(['uid'=>$id,'level'=>'0'])->get();
        $this->assign(['message'=>$message,'user'=>$user,'isMe'=>$isMe]);
        return $this->view('mobile.message.index');
    }
}