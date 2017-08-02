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

    protected $createAtColumn = 'created_at';

    protected $updateAtColumn = 'updated_at';

    protected $createdByColumn = 'created_by';

    protected $updatedByColumn = 'updated_by';

    protected $deletedAtColumn = 'deleted_at';

    protected $deletedByColumn = 'deleted_by';
}
