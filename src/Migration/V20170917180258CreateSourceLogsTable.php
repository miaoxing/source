<?php

namespace Miaoxing\Source\Migration;

use Miaoxing\Plugin\BaseMigration;

class V20170917180258CreateSourceLogsTable extends BaseMigration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->schema->table('source_logs')
            ->id()
            ->int('app_id')
            ->int('source_id')
            ->int('user_id')
            ->tinyInt('action')
            ->int('value')->unsigned()->comment('操作的值，如积分')
            ->date('created_date')
            ->timestamp('created_at')
            ->exec();
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->schema->drop('source_logs');
    }
}
