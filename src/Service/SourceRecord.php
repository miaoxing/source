<?php

namespace Miaoxing\Source\Service;

use miaoxing\plugin\BaseModel;

class SourceRecord extends BaseModel
{
    protected $table = 'sources';

    protected $providers = [
        'db' => 'app.db',
    ];

    protected $appIdColumn = 'app_id';

    protected $createdAtColumn = 'created_at';

    protected $updatedAtColumn = 'updated_at';

    protected $createdByColumn = 'created_by';

    protected $updatedByColumn = 'updated_by';

    protected $deletedAtColumn = 'deleted_at';

    protected $deletedByColumn = 'deleted_by';

    protected $data = [
        'related_ids' => [],
    ];

    public function beforeSave()
    {
        parent::beforeSave();

        $this['related_ids'] = json_encode($this['related_ids']);
    }

    public function afterFind()
    {
        parent::afterFind();

        $this['related_ids'] = json_decode($this['related_ids'], true);
    }
}
