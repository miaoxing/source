<?php

namespace Miaoxing\Source\Service;

use Miaoxing\Plugin\BaseService;

class SourceLog extends BaseService
{
    public function __invoke()
    {
        return wei()->sourceLogRecord();
    }

    /**
     * @param SourceRecord|SourceModel $source
     * @param $data
     * @throws \Exception
     */
    public function create($source, array $data)
    {
        if (wei()->source->statType == 'weekly') {
            $date = $this->getFirstDayOfWeek();
        } else {
            $date = wei()->time->today();
        }

        $data += [
            'user_id' => wei()->curUser['id'],
            'created_date' => $date,
        ];

        // 记录来源和关联的来源
        wei()->appDb->transactional(function () use ($data, $source) {
            wei()->sourceLog()->setAppId()->save($data + ['source_id' => $source['id']]);
            foreach ($source['related_ids'] as $id) {
                if ($id) {
                    wei()->sourceLog()->setAppId()->save($data + ['source_id' => $id]);
                }
            }
        });
    }

    public function getFirstDayOfWeek($now = null)
    {
        // 传入null会认为是0,默认传入当前时间
        $now || $now = time();

        return date('Y-m-d', strtotime('-' . date('w', $now) . ' days', $now));
    }
}
