<?php

namespace Miaoxing\Source\Metadata;

/**
 * SourceTrait
 *
 * @property int $id
 * @property int $appId
 * @property string $name
 * @property string $createdAt
 * @property string $updatedAt
 * @property int $createdBy
 * @property int $updatedBy
 * @property string $deletedAt
 * @property int $deletedBy
 * @property string $code 标识
 * @property bool $source 来源,0用户创建,1后台自动创建
 * @property string $relatedIds 关联的多个来源编号
 * @property int $viewCount 即PV
 * @property int $viewUser 即UV
 * @property int $subscribeUser 关注数
 * @property int $unsubscribeUser 取消关注数
 * @property int $netSubscribeValue 净增关注数
 * @property int $consumeMemberUser 有消费的会员数
 * @property int $receiveMemberCount 领取会员卡数
 * @property int $receiveCardCount 领取优惠券数
 * @property int $consumeCardCount 核销优惠券数
 * @property int $addScoreValue 增加积分数
 * @property int $subScoreValue 使用积分数
 * @property int $orderCount
 * @property float $orderAmountValue
 */
trait SourceTrait
{
    /**
     * @var array
     * @see CastTrait::$casts
     */
    protected $casts = [
        'id' => 'int',
        'app_id' => 'int',
        'name' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'created_by' => 'int',
        'updated_by' => 'int',
        'deleted_at' => 'datetime',
        'deleted_by' => 'int',
        'code' => 'string',
        'source' => 'bool',
        'related_ids' => 'string',
        'view_count' => 'int',
        'view_user' => 'int',
        'subscribe_user' => 'int',
        'unsubscribe_user' => 'int',
        'net_subscribe_value' => 'int',
        'consume_member_user' => 'int',
        'receive_member_count' => 'int',
        'receive_card_count' => 'int',
        'consume_card_count' => 'int',
        'add_score_value' => 'int',
        'sub_score_value' => 'int',
        'order_count' => 'int',
        'order_amount_value' => 'float',
    ];
}
