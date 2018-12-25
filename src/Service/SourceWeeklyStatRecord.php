<?php

namespace Miaoxing\Source\Service;

use Miaoxing\Plugin\BaseModel;

class SourceWeeklyStatRecord extends BaseModel
{
    protected $table = 'source_weekly_stats';

    protected $providers = [
        'db' => 'app.db',
    ];

    protected $appIdColumn = 'app_id';

    protected $createdAtColumn = 'created_at';

    protected $updatedAtColumn = 'updated_at';

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
        'order_count' => 0,
        'order_amount_value' => 0,
        'total_view_count' => 0,
        'total_view_user' => 0,
        'total_subscribe_user' => 0,
        'total_unsubscribe_user' => 0,
        'total_net_subscribe_value' => 0,
        'total_consume_member_user' => 0,
        'total_receive_member_count' => 0,
        'total_receive_card_count' => 0,
        'total_consume_card_count' => 0,
        'total_add_score_value' => 0,
        'total_sub_score_value' => 0,
        'total_order_count' => 0,
        'total_order_amount_value' => 0,
    ];
}
