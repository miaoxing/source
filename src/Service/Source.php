<?php

namespace Miaoxing\Source\Service;

use miaoxing\plugin\BaseService;

class Source extends BaseService
{
    const PARAM_NAME = 'mx_source';

    const TYPE_USER = 0;

    const TYPE_ADMIN = 1;

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
