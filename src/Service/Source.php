<?php

namespace Miaoxing\Source\Service;

use miaoxing\plugin\BaseService;

class Source extends BaseService
{
    const PARAM_NAME = 'mx_source';

    const SOURCE_USER = 0;

    const SOURCE_ADMIN = 1;

    public function __invoke()
    {
        return wei()->sourceRecord();
    }

    public function updateUser($source, $user = null)
    {
        $user || $user = wei()->curUser;

        if (!$user['source']) {
            $user['source'] = $source;
            $user->save();
        }
    }
}
