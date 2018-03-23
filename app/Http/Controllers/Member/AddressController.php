<?php

namespace App\Http\Controllers\Member;

use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddressController extends Controller
{
    /**
     *
     */
    public function index(){


        if ($this->isOnSubmit()) {
            $address = $this->request->post('address');
            $address_id = intval($this->request->post('address_id'));
            if ($address_id) {
                Address::where('address_id', $address_id)->update($address);
                return $this->showSuccess(trans('ui.update_succeed'));
            }else {
                $address['uid'] = $this->uid;
                Address::insert($address);
                return $this->showSuccess(trans('ui.save_succeed'));
            }
        }else {
            $address_id = $this->request->get('address_id');
            $this->assign([
                'menu' => 'address',
                'address_id' => $address_id,
                'address' => [
                    'consignee' => '',
                    'phone' => '',
                    'province' => '',
                    'city' => '',
                    'district' => '',
                    'street' => '',
                    'isdefault' => 0,
                    'postcode' => ''
                ],
                'itemlist' => []
            ]);

            if ($address_id) {
                $address = Address::where('address_id', $address_id)->first();
                if ($address) $this->assign(['address' => $address]);
            }

            foreach (Address::all() as $addr) {
                $this->data['itemlist'][$addr->address_id] = $addr;
            }

            return $this->view('member.address');
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function setdefault(){
        $address_id = intval($this->request->input('address_id'));
        Address::where('uid', $this->uid)->update(['isdefault'=>0]);
        Address::where([['uid', '=', $this->uid], ['address_id', '=', $address_id]])->update(['isdefault'=>1]);
        return ajaxReturn();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(){
        $address_id = intval($this->request->input('address_id'));
        Address::where([['uid', '=', $this->uid], ['address_id', '=', $address_id]])->delete();
        return ajaxReturn();
    }
}
