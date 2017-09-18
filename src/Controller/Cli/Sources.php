<?php

namespace Miaoxing\Source\Controller\Cli;

use miaoxing\plugin\BaseController;

class Sources extends BaseController
{
    public function statAction($req)
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
        /*foreach ($data as $row) {
            $last = wei()->leqeeMemberChannelStat()
                ->andWhere(['channel_id' => $row['channel_id']])
                ->desc('stat_date')
                ->find();
            $channel = wei()->leqeeMemberChannel()->findOrInitById($row['channel_id']);
            $channel->save([
                'pay_user' => $last['total_pay_user'],
                'pay_count' => $last['total_pay_count'],
                'pay_amount' => $last['total_pay_amount'],
                'pay_product_quantity' => $last['total_pay_product_quantity'],
            ]);
        }*/

        return $this->suc();
    }
}
