<?php

namespace App\Http\Controllers\Member;

use App\Models\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CollectionController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($type = 'article'){

        $q = $this->request->get('q');
        $this->assign([
            'menu' => 'collection',
            'tab' => $type,
            'q' => $q
        ]);
        $condition = $q ? [['title', 'LIKE', $q]] : [];

        $collections = Collection::where('uid', $this->uid)->where('data_type', $type)->where($condition)->paginate(20);
        $this->assign(['pagination'=>$collections->appends(['q'=>$q])->links()]);

        $itemlist = [];
        foreach ($collections as $c) {
            $itemlist[$c->id] = $c;
        }
        $this->assign(['itemlist' => $itemlist]);

        return $this->view('member.collection_'.$type);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(){
        $id = $this->request->get('id');
        Collection::where('uid', $this->uid)->where('id', $id)->delete();
        return ajaxReturn();
    }
}
