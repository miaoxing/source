<?php

namespace Miaoxing\Source\Service;

use Miaoxing\Plugin\BaseService;

class SourceWeeklyStat extends BaseService
{
    public function __invoke()
    {
        return wei()->sourceWeeklyStatRecord();
    }
}
