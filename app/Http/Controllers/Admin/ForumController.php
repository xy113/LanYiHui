<?php

namespace App\Http\Controllers\Admin;

use App\Models\ForumBoard;

class ForumController extends BaseController
{
    public function board(){

        if ($this->isOnSubmit()) {
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

    public function itemlist(){

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
