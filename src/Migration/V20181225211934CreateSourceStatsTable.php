<?php

namespace Miaoxing\Source\Migration;

use Miaoxing\Plugin\BaseMigration;

class V20181225211934CreateSourceStatsTable extends BaseMigration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $table = $this->schema->table('source_stats');
        $table->id()
            ->int('app_id')
            ->int('source_id')
            ->date('stat_date')
            ->int('view_count')->comment('即PV')
            ->int('view_user')->comment('即UV')
            ->int('subscribe_user')->comment('关注数')
            ->int('unsubscribe_user')->comment('取消关注数')
            ->int('net_subscribe_value')->unsigned(false)->comment('净增关注数')
            ->int('consume_member_user')->comment('有消费的会员数')
            ->int('receive_member_count')->comment('领取会员卡数')
            ->int('receive_card_count')->comment('领取优惠券数')
            ->int('consume_card_count')->comment('核销优惠券数');
        $table
            ->int('add_score_value')->comment('增加积分数')
            ->int('sub_score_value')->comment('使用积分数')
            ->int('order_count')->comment('完成订单数')
            ->decimal('order_amount_value')->comment('完成订单金额')
            ->int('total_view_count')->comment('即累积PV')
            ->int('total_view_user')->comment('即累积UV')
            ->int('total_subscribe_user')->comment('累积关注数')
            ->int('total_unsubscribe_user')->comment('累积取消关注数')
            ->int('total_net_subscribe_value')->unsigned(false)->comment('累积净增关注数')
            ->int('total_consume_member_user')->comment('累积有消费的会员数')
            ->int('total_receive_member_count')->comment('累积领取会员卡数');
        $table
            ->int('total_receive_card_count')->comment('累积领取优惠券数')
            ->int('total_consume_card_count')->comment('累积核销优惠券数')
            ->int('total_add_score_value')->comment('累积增加积分数')
            ->int('total_sub_score_value')->comment('累积使用积分数')
            ->int('total_order_count')->comment('累积完成订单数')
            ->decimal('total_order_amount_value')->comment('累积完成订单金额')
            ->timestamp('created_at')
            ->timestamp('updated_at')
            ->exec();
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->schema->drop('source_stats');
    }
}
