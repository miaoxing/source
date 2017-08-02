<?php

namespace Miaoxing\Source\Service;

use miaoxing\plugin\BaseService;

class Source extends BaseService
{
    const PARAM_NAME = 'mx_source';

    public function __invoke()
    {
        return wei()->sourceRecord();
    }
}
