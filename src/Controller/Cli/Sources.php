<?php

namespace Miaoxing\Source\Controller\Cli;

use Miaoxing\Plugin\BaseController;

class Sources extends BaseController
{
    public function statAction($req)
    {
        // 1. 获取统计的时间范围
        $today = wei()->time->today();
        list($startDate, $endDate) = explode('~', (string) $req['date']);
        if (!$startDate) {
            $startDate = $today;
        }
        if (!$endDate) {
            $endDate = $startDate;
        }

        $stat = wei()->statV2;

        // 2. 读取各天统计数据
        $logs = $stat->createQuery('sourceLogRecord', $startDate, $endDate);
        $logs = $logs->fetchAll();

        // 3. 按日期,编号格式化
        $data = $stat->format('sourceLogRecord', $logs);

        // 4. 记录到统计表中
        $stat->save('sourceLogRecord', $data, 'sourceStatRecord');

        // 5. 更新到总表中
        $this->updateMain($data);

        return $this->suc();
    }

    public function weeklyStatAction($req)
    {
        // 1. 获取统计的时间范围
        $today = wei()->sourceLog->getFirstDayOfWeek();
        list($startDate, $endDate) = explode('~', (string) $req['date']);
        if (!$startDate) {
            $startDate = $today;
        }
        if (!$endDate) {
            $endDate = $startDate;
        }

        $stat = wei()->statV2;

        // 2. 读取各天统计数据
        $logs = $stat->createQuery('sourceLogRecord', $startDate, $endDate);
        $logs = $logs->fetchAll();

        // 3. 按日期,编号格式化
        $data = $stat->format('sourceLogRecord', $logs);

        // 4. 记录到统计表中
        $stat->save('sourceLogRecord', $data, 'sourceWeeklyStatRecord');

        // 5. 更新到总表中
        $this->updateMain($data);

        return $this->suc();
    }

    protected function updateMain($data)
    {
        foreach ($data as $row) {
            // TODO week
            $last = wei()->sourceStat()
                ->desc('stat_date')
                ->find(['source_id' => $row['source_id']]);
            $source = wei()->source()->findOrInitById($row['source_id']);
            $source->save([
                'view_count' => $last['total_view_count'],
                'view_user' => $last['total_view_user'],
                'subscribe_user' => $last['total_subscribe_user'],
                'unsubscribe_user' => $last['total_unsubscribe_user'],
                'net_subscribe_value' => $last['total_net_subscribe_value'],
                'consume_member_user' => $last['total_consume_member_user'],
                'receive_member_count' => $last['total_receive_member_count'],
                'receive_card_count' => $last['total_receive_card_count'],
                'consume_card_count' => $last['total_consume_card_count'],
                'add_score_value' => $last['total_add_score_value'],
                'sub_score_value' => $last['total_sub_score_value'],
                'order_count' => $last['total_order_count'],
                'order_amount_value' => $last['total_order_amount_value'],
            ]);
        }
    }
}
