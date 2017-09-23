<?php

namespace Miaoxing\Source\Controller\Admin;

use DateTime;
use miaoxing\plugin\BaseController;

class SourceWeeklyStats extends BaseController
{
    protected $controllerName = '来源每周统计';

    protected $actionPermissions = [
        'show' => '查看',
    ];

    protected $displayPageHeader = true;

    public function showAction($req)
    {
        $source = wei()->source()->curApp();
        if (isset($req['source_code'])) {
            $source->findOne(['code' => $req['source_code']]);
        } else {
            $source->findOneById($req['source_id']);
        }

        // 获取查询的日期范围
        $startDate = $req['start_date'] ?: date('Y-m-d', strtotime('-8 weeks'));
        $endDate = $req['end_date'] ?: date('Y-m-d');
        $startDate = wei()->sourceLog->getFirstDayOfWeek(strtotime($startDate));
        $endDate = wei()->sourceLog->getFirstDayOfWeek(strtotime($endDate));

        switch ($req['_format']) {
            case 'json':
                // 1. 读出统计数据
                $stats = wei()->sourceWeeklyStat()
                    ->andWhere(['source_id' => $source['id']])
                    ->andWhere('stat_date BETWEEN ? AND ? ', [$startDate, $endDate])
                    ->fetchAll();

                // 2. 如果取出的数据和日期不一致,补上缺少的数据
                $date1 = new DateTime($startDate);
                $date2 = new DateTime($endDate);
                $dateCount = $date1->diff($date2)->days + 1;
                if (count($stats) != $dateCount) {
                    // 找到最后一个有数据的日期
                    $lastStat = wei()->sourceWeeklyStat()
                        ->andWhere('stat_date < ?', $startDate)
                        ->desc('id')
                        ->findOrInit(['source_id' => $source['id']])
                        ->toArray();

                    $defaults = wei()->sourceWeeklyStatRecord->getData();

                    $stats = wei()->statV2->normalize(
                        'sourceWeeklyStatRecord',
                        $stats,
                        $defaults,
                        $lastStat,
                        $startDate,
                        $endDate,
                        86400 * 7
                    );
                }

                // 3. 转换为数字
                $stats = wei()->chart->convertNumbers($stats);
                foreach ($stats as &$stat) {
                    $stat['stat_week'] = $this->getWeek($stat['stat_date']) . '（' . $stat['stat_date'] . '）';
                }

                return $this->suc([
                    'data' => $stats,
                ]);

            default:
                return get_defined_vars();
        }
    }

    /**
     * @param $date
     * @return int
     * @link https://stackoverflow.com/questions/16057039/how-to-get-weeks-starting-on-sunday
     */
    protected function getWeek($date)
    {
        $time = strtotime($date);
        $week = intval(date('W', $time));

        // 0 = Sunday
        if (date('w', $time) == 0) {
            ++$week;
        }

        return $week;
    }
}
