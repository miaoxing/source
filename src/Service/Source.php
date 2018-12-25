<?php

namespace Miaoxing\Source\Service;

use Miaoxing\Config\ConfigTrait;
use Miaoxing\Plugin\BaseService;
use Miaoxing\Plugin\Service\User;

/**
 * @property array $columns
 * @property string statType
 */
class Source extends BaseService
{
    use ConfigTrait;

    const PARAM_NAME = 'mx_source';

    const SOURCE_USER = 0;

    const SOURCE_ADMIN = 1;

    protected $configs = [
        'statType' => [
            'default' => '', // 空或weekly
        ],
        'columns' => [
            'default' => ['viewCount', 'viewUser', 'orderCount', 'orderAmountValue'],
        ],
    ];

    public function __invoke()
    {
        return wei()->sourceRecord();
    }

    public function create($data)
    {
        $source = wei()->source()->curApp()->findId($data['id']);
        $source->save($data);

        // 同步到二维码
        $qrcode = wei()->weChatQrcode()->findOrInit(['sceneId' => $source['code']]);
        $qrcode->save([
            'name' => $source['name'],
            'source' => static::SOURCE_ADMIN,
        ]);
    }

    public function updateUser($source, User $user = null)
    {
        $user || $user = wei()->curUser;

        $user['source'] = $source;
        $user->save();
    }

    /**
     * 根据用户获取来源对象
     *
     * @param User|null $user
     * @return $this|false|null
     */
    public function getByUser(User $user = null)
    {
        $user || $user = wei()->curUser;

        if (!$user['source']) {
            return;
        }

        $source = wei()->source()->curApp()->find(['code' => $user['source']]);

        return $source;
    }

    /**
     * 获取当前下一个标识
     *
     * @return int
     */
    public function getNextCode()
    {
        return wei()->source()
                ->curApp()
                ->notDeleted()
                ->select('MAX(CAST(code AS UNSIGNED))')
                ->andWhere('code > 0')
                ->fetchColumn() + 1;
    }
}
