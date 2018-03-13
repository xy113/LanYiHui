<?php

namespace App\Models;

class Wallet extends BaseModel
{
    protected $table = 'wallet';
    protected $primaryKey = 'uid';

    /**
     * @param $uid
     * @return array
     */
    public static function getData($uid){
        $wallet = Wallet::where('uid', $uid)->first()->toArray();
        if ($wallet) {
            return $wallet;
        }else {
            $wallet = [
                'uid'=>$uid,
                'balance'=>0.00,
                'total_income'=>0.00,
                'total_cost'=>0.00
            ];
            Wallet::insert($wallet);
            return $wallet;
        }
    }
}
