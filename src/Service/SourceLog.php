<?php

namespace Miaoxing\Source\Service;

use miaoxing\plugin\BaseService;

class SourceLog extends BaseService
{
    public function __invoke()
    {
        return wei()->sourceLogRecord();
    }

    public function create($data)
    {
        wei()->sourceLog()->setAppId()->save($data + [
            'user_id' => wei()->curUser['id'],
            // 使用本周第一天
            'created_date' => $this->getFirstDayOfWeek(),
        ]);
    }

    public function getFirstDayOfWeek($now = null)
    {
        return date('Y-m-d', strtotime('-' . date('w', $now) . ' days', $now));
    }
}
