<?php

namespace App\Models;

/**
 * App\Models\Trade
 *
 * @mixin \Eloquent
 * @property int $trade_id
 * @property int $payer_uid 付款方ID
 * @property string $payer_name 付款方账号
 * @property int $payee_uid 收款方ID
 * @property string $payee_name 收款方账户
 * @property string $pay_type 支付方式
 * @property int $pay_status 支付状态,0=未支付，1=已支付
 * @property string $trade_no 交易号
 * @property string $trade_name 交易名称
 * @property string $trade_desc 交易描述
 * @property float $trade_fee 交易金额
 * @property string $trade_type 交易类型
 * @property string $trade_status 交易状态
 * @property string $trade_time 交易时间
 * @property string $out_trade_no 第三方支付订单号
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trade whereOutTradeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trade wherePayStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trade wherePayType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trade wherePayeeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trade wherePayeeUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trade wherePayerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trade wherePayerUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trade whereTradeDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trade whereTradeFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trade whereTradeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trade whereTradeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trade whereTradeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trade whereTradeStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trade whereTradeTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trade whereTradeType($value)
 */
class Trade extends BaseModel
{
    protected $table = 'trade';
    protected $primaryKey = 'trade_id';
}
