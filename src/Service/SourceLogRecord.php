<?php

namespace Miaoxing\Source\Service;

use miaoxing\plugin\BaseModel;

class SourceLogRecord extends BaseModel
{
    const ACTION_VIEW = 1;

    const ACTION_SUBSCRIBE = 2;

    const ACTION_UNSUBSCRIBE = 3;

    const ACTION_NET_SUBSCRIBE = 4;

    const ACTION_ADD_SCORE = 5;

    const ACTION_SUB_SCORE = 6;

    const ACTION_CONSUME_MEMBER = 7;

    const ACTION_RECEIVE_MEMBER = 8;

    const ACTION_RECEIVE_CARD = 9;

    const ACTION_CONSUME_CARD = 10;

    protected $appIdColumn = 'app_id';

    protected $createAtColumn = 'created_at';

    protected $table = 'source_logs';

    protected $providers = [
        'db' => 'app.db',
    ];

    /**
     * @var array
     */
    protected $statFields = ['app_id', 'source_id'];

    /**
     * @var array
     */
    protected $statActions = [
        self::ACTION_VIEW => 'view',
        self::ACTION_SUBSCRIBE => 'subscribe',
        self::ACTION_UNSUBSCRIBE => 'unsubscribe',
        self::ACTION_NET_SUBSCRIBE => 'net_subscribe',
        self::ACTION_ADD_SCORE => 'add_score',
        self::ACTION_SUB_SCORE => 'sub_score',
        self::ACTION_CONSUME_MEMBER => 'consume_member',
        self::ACTION_RECEIVE_MEMBER => 'receive_member',
        self::ACTION_RECEIVE_CARD => 'receive_card',
        self::ACTION_CONSUME_CARD => 'consume_card',
    ];

    /**
     * @var bool
     */
    protected $statTotal = true;

    /**
     * @var array
     */
    protected $statSums = ['value'];
}
