<?php

namespace App\Models;

/**
 * App\Models\Wallet
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $uid 会员ID
 * @property float $balance 账户余额
 * @property float $total_income 累计收入
 * @property float $total_cost 累计支出
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wallet whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wallet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wallet whereTotalCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wallet whereTotalIncome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wallet whereUid($value)
 */
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
