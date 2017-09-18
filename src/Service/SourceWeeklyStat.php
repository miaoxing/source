<?php

namespace Miaoxing\Source\Service;

use miaoxing\plugin\BaseService;

class SourceWeeklyStat extends BaseService
{
    public function __invoke()
    {
        return wei()->sourceWeeklyStatRecord();
    }
}
