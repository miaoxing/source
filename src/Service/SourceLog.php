<?php

namespace Miaoxing\Source\Service;

use miaoxing\plugin\BaseService;

class SourceLog extends BaseService
{
    public function __invoke()
    {
        return wei()->sourceLogRecord();
    }

    public function create(SourceRecord $source, $data)
    {
        $data += [
            'user_id' => wei()->curUser['id'],
            // 使用本周第一天
            'created_date' => $this->getFirstDayOfWeek(),
        ];

        // 记录来源和关联的来源
        wei()->appDb->transactional(function () use ($data, $source) {
            wei()->sourceLog()->setAppId()->save($data + ['source_id' => $source['id']]);
            foreach ($source['related_ids'] as $id) {
                wei()->sourceLog()->setAppId()->save($data + ['source_id' => $id]);
            }
        });
    }

    public function getFirstDayOfWeek($now = null)
    {
        return date('Y-m-d', strtotime('-' . date('w', $now) . ' days', $now));
    }
}
