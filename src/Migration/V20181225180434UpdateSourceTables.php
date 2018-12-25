<?php

namespace Miaoxing\Source\Migration;

use Miaoxing\Plugin\BaseMigration;

class V20181225180434UpdateSourceTables extends BaseMigration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->schema->table('sources')
            ->int('order_count')
            ->decimal('order_amount_value')
            ->exec();

        $this->schema->table('source_logs')
            ->decimal('value')->change()
            ->exec();

        $this->schema->table('source_weekly_stats')
            ->int('order_count')->comment('完成订单数')
            ->decimal('order_amount_value')->comment('完成订单金额')
            ->int('total_order_count')->comment('累积完成订单数')
            ->decimal('total_order_amount_value')->comment('累积完成订单金额')
            ->exec();
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->schema->table('sources')
            ->dropColumn('order_count')
            ->dropColumn('order_amount_value')
            ->exec();

        $this->schema->table('source_logs')
            ->int('value')->change()
            ->exec();

        $this->schema->table('source_weekly_stats')
            ->dropColumn('order_count')
            ->dropColumn('order_amount_value')
            ->dropColumn('total_order_count')
            ->dropColumn('total_order_amount_value')
            ->exec();
    }
}
