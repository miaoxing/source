<?php

namespace Miaoxing\Source\Controller;

use miaoxing\plugin\BaseController;
use Miaoxing\Source\Service\SourceLogRecord;

class SourceLogs extends BaseController
{
    public function createAction($req)
    {
        $source = wei()->source()->curApp()->findOne(['source' => $req['source']]);

        wei()->source->updateUser($source['source']);
        wei()->sourceLog->create($source, [
            'action' => SourceLogRecord::ACTION_VIEW,
        ]);

        $this->response->setHeader('Content-Type', 'image/gif');

        return base64_decode('R0lGODlhAQABAJAAAP8AAAAAACH5BAUQAAAALAAAAAABAAEAAAICBAEAOw==');
    }
}
