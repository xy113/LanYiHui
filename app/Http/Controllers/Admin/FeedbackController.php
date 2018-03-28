<?php

namespace App\Http\Controllers\Admin;

use App\Models\Feedback;

class FeedbackController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){

        if ($this->isOnSubmit()) {
            $delete = $this->request->post('delete');
            if ($delete) {
                foreach ($delete as $id) {
                    Feedback::where('id', $id)->delete();
                }
            }
            return $this->showSuccess(trans('ui.delete_succeed'));
        }else {

            $itemlist = Feedback::orderBy('id', 'DESC')->paginate(20);
            $this->assign([
                'itemlist'=>$itemlist,
                'pagination'=>$itemlist->links()
            ]);

            return $this->view('admin.common.feedback_list');
        }
    }
}
