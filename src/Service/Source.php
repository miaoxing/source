<?php

namespace Miaoxing\Source\Service;

use miaoxing\plugin\BaseService;

class Source extends BaseService
{
    public function __invoke()
    {
        return wei()->sourceRecord();
    }
}
