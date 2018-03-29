<?php

namespace App\Http\Controllers\Admin;

use App\Models\ForumBoard;
use App\Models\ForumMessage;
use App\Models\ForumTopic;

class ForumController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function board(){

        if ($this->isOnSubmit()) {
            $delete = $this->request->post('delete');
            if ($delete) {
                foreach ($delete as $boardid) {
                    ForumBoard::where('boardid', $boardid)->delete();
                    ForumTopic::where('boardid', $boardid)->delete();
                    ForumMessage::where('boardid', $boardid)->delete();
                }
            }
            $boardlist = $this->request->post('boardlist');
            if ($boardlist) {
                foreach ($boardlist as $boardid=>$board){
                    if ($board['title']) {
                        $board['visible'] = intval($board['visible']);
                        if ($boardid > 0) {
                            $board['updated_at'] = time();
                            ForumBoard::where('boardid', $boardid)->update($board);
                        }else {
                            $board['created_at'] = time();
                            ForumBoard::insert($board);
                        }
                    }
                }
            }
            return $this->showSuccess(trans('ui.save_succeed'));
        }else {

            $this->assign([
                'itemlist'=>ForumBoard::orderBy('displayorder', 'ASC')->get()
            ]);

            return $this->view('admin.forum.board');
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function topic(){

        if ($this->isOnSubmit()) {
            $topics = $this->request->post('items');
            if ($topics) {
                foreach ($topics as $tid) {
                    ForumTopic::where('tid', $tid)->delete();
                    ForumMessage::where('tid', $tid)->delete();
                }
            }
            return ajaxReturn();
        }else {

            $condition = [];
            $q = $this->request->get('q');
            if ($q) $condition[] = ['title', 'LIKE', "%$q%"];

            $topics = ForumTopic::where($condition)->orderBy('tid', 'DESC')->paginate(20);
            $this->assign([
                'q'=>$q,
                'itemlist'=>$topics,
                'pagination'=>$topics->appends(['q'=>$q])->links()
            ]);

            return $this->view('admin.forum.topic');
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function seticon(){
        $boardid = $this->request->post('boardid');
        $icon = $this->request->post('icon');

        ForumBoard::where('boardid', $boardid)->update(['icon'=>$icon]);
        return ajaxReturn();
    }
}
