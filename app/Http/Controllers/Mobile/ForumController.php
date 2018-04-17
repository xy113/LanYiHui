<?php

namespace App\Http\Controllers\Mobile;

use App\Models\BlockItem;
use App\Models\ForumBoard;
use App\Models\ForumMessage;
use App\Models\ForumTopic;
use App\Models\Member;
use App\Models\MemberInfo;
use App\Models\School;
use App\Models\Schoolfellow;
use App\Models\SfApply;
use Illuminate\Http\Request;

class ForumController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){

        $this->assign([
            'focus_imgs'=>BlockItem::where('block_id', 12)->get(),
            'boardlist'=>ForumBoard::where('visible', 1)->get(),
            'newtopics'=>ForumTopic::orderBy('tid','DESC')->limit(10)->get()
        ]);

        return $this->view('mobile.forum.index');
    }

    public function board($boardid) {

        ForumBoard::where('boardid', $boardid)->increment('views');
        $this->assign([
            'boardid'=>$boardid,
            'board'=>ForumBoard::where('boardid', $boardid)->first(),
            'topicCount'=>ForumTopic::where('boardid', $boardid)->count(),
            'messageCount'=>ForumMessage::where(['boardid' => $boardid, 'topic'=>0])->count(),
            'topiclist'=>ForumTopic::where('boardid', $boardid)->orderBy('tid', 'DESC')->paginate(10)
        ]);

        return $this->view('mobile.forum.board');
    }

    /**
     * @param $tid
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function topic($tid){

        ForumTopic::where('tid', $tid)->increment('views');
        $topic = ForumTopic::where('tid', $tid)->first();
        $this->assign(['topic'=>$topic]);

        $message = ForumMessage::where(['tid'=>$tid, 'topic'=>1])->first();
        $this->assign(['message'=>$message]);

        $messagelist = ForumMessage::where(['tid'=>$tid, 'topic'=>0])->paginate(10);
        $this->assign(['messagelist'=>$messagelist]);

        $this->assign([
            'replyCount'=>ForumMessage::where(['tid'=>$tid, 'topic'=>0])->count()
        ]);

        return $this->view('mobile.forum.topic');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function publish(){

        if ($this->isOnSubmit()) {
            $title = $this->request->post('title');
            $message = $this->request->post('message');
            $boardid = $this->request->get('boardid');

            $tid = ForumTopic::insertGetId([
                'boardid'=>$boardid,
                'uid'=>$this->uid,
                'username'=>$this->username,
                'last_uid'=>$this->uid,
                'last_username'=>$this->username,
                'title'=>$title,
                'created_at'=>time()
            ]);

            ForumMessage::insert([
                'tid'=>$tid,
                'boardid'=>$boardid,
                'uid'=>$this->uid,
                'username'=>$this->username,
                'message'=>$message,
                'created_at'=>time(),
                'topic'=>1
            ]);

            return ajaxReturn(['tid'=>$tid]);
        }else {

            return $this->view('mobile.forum.publish');
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function reply(){
        $tid = $this->request->post('tid');
        $boardid = $this->request->post('boardid');
        $message = $this->request->post('message');

        $id = ForumMessage::insertGetId([
            'tid'=>$tid,
            'boardid'=>$boardid,
            'uid'=>$this->uid,
            'username'=>$this->username,
            'message'=>$message,
            'created_at'=>time(),
            'topic'=>0
        ]);

        ForumTopic::where('tid', $tid)->increment('replies');
        return ajaxReturn(['id'=>$id]);
    }

    public function schoolfellowList(){
        $list = Member::find($this->uid)->entered;
        $apply = Member::find($this->uid)->apply;
        $refused = Member::find($this->uid)->refused;
        $this->assign([
            'list'=>$list,
            'apply'=>$apply,
            'refused'=>$refused
        ]);
        return $this->view('mobile.forum.list');
    }
    public function schoolfellowDelete(){}
    public function schoolfellow(){
        $id = $this->request->get('id');
        $school = School::find($id);
        $members = Schoolfellow::where(['school_id'=>$id,'status'=>'1'])->orderBy('degree','ESC')->get();
//        return json_encode($members);
        $this->assign([
            'members'=>$members,
            'school'=>$school
        ]);
        return $this->view('mobile.forum.schoolfellow');
    }
    public function applyPage(){
        $id = $this->uid;
//        if(empty(MemberInfo::find($id)['name'])){
//            return redirect('/mobile/member/userinfo');
//        }
        return $this->view('mobile.forum.applyschoolfellow');
    }
    // school,
    public function apply(Request $request){
        $req = $request->all();
        $sc = School::where('name',$req['school'])->first();
        $application = new Schoolfellow;
        $application['uid'] = $this->uid;
        $application['graduation_at'] = $req['graduation_at'];
        $application['degree'] = $req['degree'];
        $application['major'] = $req['major'];
        if($sc){
            $exit = Schoolfellow::where(['uid'=>$this->uid,'school_id'=>$sc['id'],'degree'=>$req['degree']])->first();
            if($exit){
                if ($exit['status']!='-1'){
                    $res['err_code'] = -1;
                    $res['msg'] = '申请已存在！';
                    return json_encode($res);
                }else{
                    $exit['status'] = 0;
                    $exit->save();
                    $res['err_code'] = 0;
                    return json_encode($res);
                }
            }
            $application['school_id'] = $sc['id'];
        }else{
            $school = new School();
            $school['name'] = $req['school'];
            $school->save();
            $application['school_id'] = $school['id'];
        }
        if ($application->save()){
            $res['err_code'] = 0;
        }else{
            $res['err_code'] = -1;
        }
        return json_encode($res);
    }
    // school,
    public function getSchool(Request $request){
        $req = $request->all();
        $name = $req['school'];
        $school = School::where('name','like','%'.$name.'%')->get();
        $res['err_code'] = 0;
        $res['data'] = $school;
        return json_encode($res);
    }
    public function test(){

        return json_encode(School::find(1)->members);
    }
}
