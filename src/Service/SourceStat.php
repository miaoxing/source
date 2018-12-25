<?php

namespace Miaoxing\Source\Service;

use Miaoxing\Plugin\BaseService;

class SourceStat extends BaseService
{
    public function __invoke()
    {
        return wei()->sourceStatRecord();
    }
}
