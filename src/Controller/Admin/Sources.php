<?php

namespace Miaoxing\Source\Controller\Admin;

use Miaoxing\Plugin\BaseController;
use Miaoxing\Source\Service\SourceRecord;

class Sources extends BaseController
{
    protected $controllerName = '来源管理';

    protected $actionPermissions = [
        'index' => '列表',
        'new,create' => '创建',
        'edit,update' => '编辑',
        'destroy' => '删除',
        'generateLink' => '生成链接',
    ];

    protected $displayPageHeader = true;

    public function indexAction($req)
    {
        switch ($req['_format']) {
            case 'json':
                $sources = wei()->source()->curApp();

                $sources
                    ->notDeleted()
                    ->limit($req['rows'])
                    ->page($req['page']);

                if ($req['name']) {
                    $sources->andWhere('name LIKE ?', '%' . $req['name'] . '%');
                }

                if ($req['start_date']) {
                    $sources->andWhere('created_at >= ?', $req['start_date']);
                }

                if ($req['end_date']) {
                    $sources->andWhere('created_at <= ?', $req['end_date'] . ' 23:59:59');
                }

                // 排序
                $sort = $req['sort'] ?: 'id';
                $order = $req['order'] == 'asc' ? 'ASC' : 'DESC';
                $sources->orderBy($sort, $order);

                // 数据
                $data = [];
                /** @var SourceRecord $source */
                foreach ($sources->findAll() as $source) {
                    $data[] = $source->toArray() + [
                        ];
                }

                return $this->suc([
                    'data' => $data,
                    'page' => (int) $req['page'],
                    'rows' => (int) $req['rows'],
                    'records' => $sources->count(),
                ]);

            default:
                return get_defined_vars();
        }
    }

    public function newAction($req)
    {
        return $this->editAction($req);
    }

    public function editAction($req)
    {
        $source = wei()->source()->curApp()->notDeleted()->findId($req['id']);

        return get_defined_vars();
    }

    public function updateAction($req)
    {
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
}
