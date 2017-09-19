<?php

namespace Miaoxing\Source;

use Miaoxing\Member\Service\MemberRecord;
use Miaoxing\Order\Service\Order;
use miaoxing\plugin\BasePlugin;
use Miaoxing\Plugin\Service\User;
use Miaoxing\Source\Service\SourceLogRecord;
use Miaoxing\Wechat\Service\WechatAccount;
use Miaoxing\WechatCard\Service\WechatCardRecord;
use Wei\WeChatApp;

class Plugin extends BasePlugin
{
    /**
     * {@inheritdoc}
     */
    protected $name = '来源';

    /**
     * {@inheritdoc}
     */
    protected $description = '用户来源管理';

    public function onAfterScript()
    {
        if (wei()->request['mx_source']) {
            $this->display();
        }
    }

    public function onAsyncPostScoreChange(array $data)
    {
        $user = wei()->user()->findById($data['user_id']);
        if (!$user['source']) {
            return;
        }

        $source = wei()->source()->curApp()->find(['code' => $user['source']]);
        if (!$source) {
            return;
        }

        wei()->sourceLog->create($source, [
            'user_id' => $data['user_id'],
            'action' => $data['score'] > 0 ? SourceLogRecord::ACTION_ADD_SCORE : SourceLogRecord::ACTION_SUB_SCORE,
            'value' => abs($data['score']),
        ]);
    }

    public function onAsyncPostOrderPay(Order $order)
    {
        // TODO 订单记录会员卡号
        /** @var MemberRecord $member */
        $member = wei()->member()->find(['user_id' => $order['id']]);
        if (!$member) {
            return;
        }

        $user = $member->user;
        if (!$user['source']) {
            return;
        }

        $source = wei()->source()->curApp()->find(['code' => $user['source']]);
        if (!$source) {
            return;
        }

        wei()->sourceLog->create($source, [
            'action' => SourceLogRecord::ACTION_CONSUME_MEMBER,
        ]);
    }

    public function onWechatUserGetCard(WeChatApp $app, User $user, WechatAccount $account)
    {
        if (!$user['source']) {
            return;
        }

        $source = wei()->source()->curApp()->find(['code' => $user['source']]);
        if (!$source) {
            return;
        }

        $card = wei()->wechatCard()->find(['wechat_id' =>  $app->getAttr('CardId')]);
        if (!$card) {
            return;
        }

        wei()->sourceLog->create($source, [
            'action' => $card['type'] == WechatCardRecord::TYPE_MEMBER_CARD ?
                SourceLogRecord::ACTION_RECEIVE_MEMBER : SourceLogRecord::ACTION_RECEIVE_CARD,
        ]);
    }

    public function onWechatUserConsumeCard(WeChatApp $app, User $user, WechatAccount $account)
    {
        if (!$user['source']) {
            return;
        }

        $source = wei()->source()->curApp()->find(['code' => $user['source']]);
        if (!$source) {
            return;
        }

        wei()->sourceLog->create($source, [
            'action' => SourceLogRecord::ACTION_CONSUME_CARD,
        ]);
    }

    public function onWechatUserFirstSubscribe(User $user)
    {
        // TODO 直接关注的情况？
        if (!$user['source']) {
            return;
        }

        $source = wei()->source()->curApp()->find(['code' => $user['source']]);
        if (!$source) {
            return;
        }

        wei()->sourceLog->create($source, [
            'action' => SourceLogRecord::ACTION_SUBSCRIBE,
        ]);

        wei()->sourceLog->create($source, [
            'action' => SourceLogRecord::ACTION_NET_SUBSCRIBE,
            'value' => 1,
        ]);
    }

    public function onWechatUserFirstUnsubscribe(User $user)
    {
        if (!$user['source']) {
            return;
        }

        $source = wei()->source()->curApp()->find(['code' => $user['source']]);
        if (!$source) {
            return;
        }

        wei()->sourceLog->create($source, [
            'action' => SourceLogRecord::ACTION_UNSUBSCRIBE,
        ]);

        wei()->sourceLog->create($source, [
            'action' => SourceLogRecord::ACTION_NET_SUBSCRIBE,
            'value' => -1,
        ]);
    }

    public function onAdminNavGetNavs(&$navs, &$categories, &$subCategories)
    {
        $navs[] = [
            'parentId' => 'marketing-stat',
            'url' => 'admin/sources',
            'name' => '来源管理',
        ];
    }
}
