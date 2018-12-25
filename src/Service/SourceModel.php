<?php

namespace Miaoxing\Source\Service;

use Miaoxing\Plugin\BaseModelV2;
use Miaoxing\Plugin\Model\HasAppIdTrait;
use Miaoxing\Plugin\Model\SoftDeleteTrait;
use Miaoxing\Source\Metadata\SourceTrait;

/**
 * SourceModel
 */
class SourceModel extends BaseModelV2
{
    use SourceTrait;
    use HasAppIdTrait;
    use SoftDeleteTrait;
}
