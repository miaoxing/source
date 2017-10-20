<?php

namespace Miaoxing\Source;

use Miaoxing\Member\Service\MemberRecord;
use Miaoxing\Order\Service\Order;
use miaoxing\plugin\BasePlugin;
use Miaoxing\Plugin\Service\User;
use Miaoxing\Source\Service\SourceLogRecord;
use Miaoxing\Source\Service\SourceRecord;
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

    protected $adminNavId = 'marketing';

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
        $user = $order->getUser();
        if (!$user['source']) {
            return;
        }

        $member = wei()->member->getMember($user);
        if ($member->isNew()) {
            return;
        }

        $source = wei()->source()->curApp()->find(['code' => $user['source']]);
        if (!$source) {
            return;
        }

        wei()->sourceLog->create($source, [
            'user_id' => $user['id'],
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

        $card = wei()->wechatCard()->find(['wechat_id' => $app->getAttr('CardId')]);
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

    public function onWechatSubscribe(WeChatApp $app, User $user, WechatAccount $account)
    {
        // 触发事件时,还未执行保存来源操作,需提前设置好来源
        if (!$user['source']) {
            $user['source'] = $app->getScanSceneId();
        }

        $this->recordSubscribe($user, SourceLogRecord::ACTION_SUBSCRIBE);
    }

    public function onWechatUnsubscribe(WeChatApp $app, User $user, WechatAccount $account)
    {
        $this->recordSubscribe($user, SourceLogRecord::ACTION_UNSUBSCRIBE);
    }

    protected function recordSubscribe($user, $action)
    {
        $source = wei()->source->getByUser($user);
        if (!$source) {
            return;
        }

        // 关注/取关过则不再记录
        $sourceLog = wei()->sourceLog()->fetchColumn([
            'source_id' => $source['id'],
            'user_id' => $user['id'],
            'action' => $action,
        ]);
        if ($sourceLog) {
            return;
        }

        /** @var SourceRecord $source */
        wei()->sourceLog->create($source, [
            'action' => $action,
        ]);

        wei()->sourceLog->create($source, [
            'action' => SourceLogRecord::ACTION_NET_SUBSCRIBE,
            'value' => $action == SourceLogRecord::ACTION_SUBSCRIBE ? 1 : -1,
        ]);
    }

    public function onAdminNavGetNavs(&$navs, &$categories, &$subCategories)
    {
        $navs[] = [
            'parentId' => 'marketing-activities',
            'url' => 'admin/sources',
            'name' => '来源管理',
        ];
    }
}
