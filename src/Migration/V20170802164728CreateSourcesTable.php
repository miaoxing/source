<?php

namespace Miaoxing\Source\Migration;

use Miaoxing\Plugin\BaseMigration;

class V20170802164728CreateSourcesTable extends BaseMigration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->schema->table('sources')
            ->id()
            ->int('app_id')
            ->string('name', 32)
            ->timestamps()
            ->userstamps()
            ->softDeletable()
            ->exec();
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->schema->dropIfExists('sources');
    }
}
