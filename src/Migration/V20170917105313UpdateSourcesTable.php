<?php

namespace Miaoxing\Source\Migration;

use Miaoxing\Plugin\BaseMigration;

class V20170917105313UpdateSourcesTable extends BaseMigration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->schema->table('sources')
            ->string('code', 64)->comment('标识')
            ->tinyInt('source', 1)->comment('来源,0用户创建,1后台自动创建')
            ->text('related_ids')->comment('关联的多个来源编号')
            ->int('view_count')->comment('即PV')
            ->int('view_user')->comment('即UV')
            ->int('subscribe_user')->comment('关注数')
            ->int('unsubscribe_user')->comment('取消关注数')
            ->int('net_subscribe_value')->unsigned(false)->comment('净增关注数')
            ->int('consume_member_user')->comment('有消费的会员数')
            ->int('receive_member_count')->comment('领取会员卡数')
            ->int('receive_card_count')->comment('领取优惠券数')
            ->int('consume_card_count')->comment('核销优惠券数')
            ->int('add_score_value')->comment('增加积分数')
            ->int('sub_score_value')->comment('使用积分数')
            ->exec();
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->schema->table('sources')
            ->dropColumn('code')
            ->dropColumn('source')
            ->dropColumn('related_ids')
            ->dropColumn('view_count')
            ->dropColumn('view_user')
            ->dropColumn('subscribe_user')
            ->dropColumn('unsubscribe_user')
            ->dropColumn('net_subscribe_value')
            ->dropColumn('consume_member_user')
            ->dropColumn('receive_member_count')
            ->dropColumn('receive_card_count')
            ->dropColumn('consume_card_count')
            ->dropColumn('add_score_value')
            ->dropColumn('sub_score_value')
            ->exec();
    }
}
