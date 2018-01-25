<?php
namespace Miaoxing\Source\Migration;

use Miaoxing\Plugin\BaseMigration;

class V20180125103021UpdateValueInSourceLogsTable extends BaseMigration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->schema->table('source_logs')
            ->int('value')->unsigned(false)->comment('操作的值，如积分')->change()
            ->exec();
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->schema->table('source_logs')
            ->int('value')->unsigned()->comment('操作的值，如积分')->change()
            ->exec();
    }
}
