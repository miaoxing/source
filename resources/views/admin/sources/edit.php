<?php

$view->layout();
?>

<?= $block('header-actions') ?>
<a class="btn btn-secondary" href="<?= $url('admin/sources') ?>">返回列表</a>
<?= $block->end() ?>

<div class="row">
  <div class="col-12">
    <form class="form-horizontal js-source-form" role="form" method="post">

      <div class="form-group">
        <label class="col-lg-2 control-label" for="name">
          <span class="text-warning">*</span>
          名称
        </label>

        <div class="col-lg-4">
          <input type="text" name="name" id="name" class="form-control" required>
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="code">
          <span class="text-warning">*</span>
          标识
        </label>

        <div class="col-lg-4">
          <input type="text" name="code" id="code" class="js-readonly form-control" required>
        </div>

        <label class="col-lg-6 help-text" for="code">唯一标识，保存后不可修改</label>
      </div>

      <?php wei()->event->trigger('adminSourcesEdit', [$source]) ?>

      <div class="clearfix form-actions form-group">
        <input type="hidden" name="id" id="id">

        <div class="offset-lg-2">
          <button class="btn btn-primary" type="submit">
            <i class="fa fa-check bigger-110"></i>
            提交
          </button>
          &nbsp; &nbsp; &nbsp;
          <a class="btn btn-secondary" href="<?= $url('admin/sources') ?>">
            <i class="fa fa-undo bigger-110"></i>
            返回列表
          </a>
        </div>
      </div>
    </form>
  </div>
</div>

<?= $block->js() ?>
<script>
  require(['plugins/source/js/admin/sources'], function (source) {
    source.editAction({
      data: <?= $source->toJson() ?>
    });

    if (source.data.id) {
      $('.js-readonly').prop('disabled', true);
    }
  });
</script>
<?= $block->end() ?>
