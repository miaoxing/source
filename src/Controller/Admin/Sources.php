<?php

namespace Miaoxing\Source\Controller\Admin;

use Miaoxing\Admin\Action\IndexTrait;
use Miaoxing\Plugin\BaseController;
use Miaoxing\Plugin\BaseModelV2;
use Miaoxing\Plugin\Service\Request;

class Sources extends BaseController
{
    use IndexTrait;

    protected $controllerName = '来源管理';

    protected $actionPermissions = [
        'index,metadata' => '列表',
        'new,create' => '创建',
        'edit,update' => '编辑',
        'destroy' => '删除',
        'generateLink' => '生成链接',
    ];

    public function __construct(array $options = [])
    {
        parent::__construct($options);

        if ($this->app->getAction() !== 'index') {
            $this->displayPageHeader = true;
        }
    }

    protected function beforeIndexFind(Request $req, BaseModelV2 $models)
    {
        $models->reqQuery();
    }

    public function newAction($req)
    {
        return $this->editAction($req);
    }

    public function editAction($req)
    {
        $source = wei()->source()->curApp()->notDeleted()->findId($req['id']);
        if ($source->isNew()) {
            $source['code'] = wei()->source->getNextCode();
        }

        return get_defined_vars();
    }

    public function updateAction($req)
    {
        $ret = wei()->v()
            ->key('code', '标识')
            ->required(!$req['id'])
            ->notRecordExists(wei()->source()->curApp()->notDeleted()->andWhere('id != ?', $req['id']), 'code')
            ->check($req);
        if ($ret['code'] !== 1) {
            return $ret;
        }

        wei()->source->create($req);

        return $this->suc();
    }

    public function generateLinkAction($req)
    {
        $source = wei()->source()->notDeleted()->findOneById($req['id']);

        return get_defined_vars();
    }

    public function destroyAction($req)
    {
        $source = wei()->source()->notDeleted()->findOneById($req['id']);

        $source->softDelete();

        return $this->suc();
    }

    public function metadataAction()
    {
        return $this->suc([
            'statType' => wei()->source->statType,
            'columns' => wei()->source->columns,
        ]);
    }
}
