<?php

namespace App\Http\Controllers\Member;

use App\Models\Trade;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WalletController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){

        $time = 0;
        $seconds = 86400;
        $condition = $params = [];
        $date_range = $this->request->get('date_range');
        $date_range = $date_range ? $date_range : 'all';
        if ($date_range == '3days'){
            $time = time() - $seconds*3;
        }elseif ($date_range == '7days'){
            $time = time() - $seconds*7;
        }elseif ($date_range == 'oneMonth'){
            $time = time() - $seconds*30;
        }elseif ($date_range == 'threeMonth'){
            $time = time() - $seconds*90;
        }elseif ($date_range == 'oneYear'){
            $time = time() - $seconds*365;
        }

        if ($time) $condition[] = ['trade_time', '>', $time];
        if ($date_range != 'all') $params['date_range'] = $date_range;

        $trade_type = $this->request->get('trade_type');
        $trade_type = $trade_type ? $trade_type : 'all';
        if ($trade_type != 'all') {
            $condition[] = ['trade_type', '=', strtolower($trade_type)];
            $params['trade_type'] = $trade_type;
        }

        $pay_type = $this->request->get('pay_type');
        $pay_type = $pay_type ? $pay_type : 'all';
        if ($pay_type != 'all') {
            $condition[] = ['pay_type', '=', $pay_type];
            $params['pay_type'] = $pay_type;
        }

        $this->appends([
            'menu' => 'wallet',
            'wallet' => Wallet::getData($this->uid),
            'itemlist' => [],
            'q' => $this->request->get('q'),
            'date_range' => $date_range,
            'trade_type' => $trade_type,
            'pay_type' => $pay_type
        ]);

        $itemlist = Trade::where($condition)->where(function ($query){
            $query->where('payer_uid', $this->uid)->orWhere('payee_uid', $this->uid);
        })->orderBy('trade_id', 'DESC')->paginate(20);
        $this->appends(['pagination'=>$itemlist->appends($params)->links(), 'totalCount'=>$itemlist->total()]);

        $trade_status = trans('member.trade_status');
        if ($itemlist) {
            foreach ($itemlist as $item) {
                $item->trade_status_name = $trade_status[$item->trade_status];
                $this->data['itemlist'][$item->trade_id] = $item->toArray();
            }
        }

        return view('member.wallet', $this->data);
    }
}
