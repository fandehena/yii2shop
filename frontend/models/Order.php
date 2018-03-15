<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $member_id 用户id
 * @property string $name 收货人
 * @property string $province 省
 * @property string $city 市
 * @property string $area 区
 * @property string $address 收货地址
 * @property string $tel 电话号码
 * @property int $delivery_id 配送方式id
 * @property string $delivery_name 配送方式名称
 * @property double $delivery_price 配送方式价格
 * @property string $payment_id 支付方式id
 * @property string $payment_name 支付方式名称
 * @property string $total 订单金额
 * @property int $status 订单状态（0已取消1待付款2待发货3待收货4完成）
 * @property string $trade_no 第三方支付交易号
 * @property int $create_time 创建时间
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */

    /**
     * @inheritdoc
     */
}
