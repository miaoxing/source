<?php

use Miaoxing\Source\Service\Source;

$view->layout();
?>

<?= $block('header-actions') ?>
<a class="btn btn-default" href="<?= $url('admin/sources') ?>">返回列表</a>
<?= $block->end() ?>

<div class="row">
  <div class="col-xs-12">
    <form class="form-horizontal js-source-form" role="form" method="post">

      <div class="form-group">
        <label class="col-lg-2 control-label" for="name">
          名称
        </label>

        <div class="col-lg-4">
          <p class="form-control-static" id="name"><?= $e($source['name']) ?></p>
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="source">
          标识
        </label>

        <div class="col-lg-4">
          <p class="form-control-static" id="source"><?= $e($source['code']) ?></p>
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="link-to">
          选择预设链接
        </label>

        <div class="col-lg-4">
          <p class="js-link-to form-control-static" id="link-to"></p>
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="url">
          输入自定义链接
        </label>

        <div class="col-lg-4">
          <input type="text" class="js-url form-control" id="url" value="<?= $url->full('') ?>">
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="result">
          生成结果
        </label>

        <div class="col-lg-4">
          <input type="text" class="js-result form-control" id="result" value="" readonly>
        </div>
      </div>

      <div class="clearfix form-actions form-group">
        <div class="col-lg-offset-2">
          <button class="js-copy btn btn-primary" type="button">
            <i class="fa fa-copy bigger-110"></i>
            复制结果
          </button>
          &nbsp; &nbsp; &nbsp;
          <a class="btn btn-default" href="<?= $url('admin/sources') ?>">
            <i class="fa fa-undo bigger-110"></i>
            返回列表
          </a>
        </div>
      </div>
    </form>
  </div>
</div>

<?php require $view->getFile('@link-to/link-to/link-to.php') ?>

<?= $block('js') ?>
<script>
  require(['plugins/source/js/admin/sources'], function (sources) {
    sources.generateLinkAction({
      data: <?= $source->toJson() ?>,
      paramName: '<?= Source::PARAM_NAME ?>'
    });
  });
</script>
<?= $block->end() ?>
