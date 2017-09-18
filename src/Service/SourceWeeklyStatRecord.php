<?php

namespace Miaoxing\Source\Service;

use miaoxing\plugin\BaseModel;

class SourceWeeklyStatRecord extends BaseModel
{
    protected $table = 'source_weekly_stats';

    protected $providers = [
        'db' => 'app.db',
    ];

    protected $appIdColumn = 'app_id';

    protected $createAtColumn = 'created_at';

    protected $updateAtColumn = 'updated_at';

    protected $data = [
        'view_count' => 0,
        'view_user' => 0,
        'subscribe_user' => 0,
        'unsubscribe_user' => 0,
        'net_subscribe_value' => 0,
        'consume_member_user' => 0,
        'receive_member_count' => 0,
        'receive_card_count' => 0,
        'consume_card_count' => 0,
        'add_score_value' => 0,
        'sub_score_value' => 0,
    ];
}
