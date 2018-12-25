<?php

use Miaoxing\Source\Service\Source;

$view->layout();
$isWxa = wei()->plugin->isInstalled('wxa');
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
          <input type="text" class="js-url form-control" id="url"
            value="<?= $isWxa ? $url->url('') : $url->full('') ?>">
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

          <?php if ($isWxa) { ?>
            <button class="js-wxa-code-show btn btn-primary" type="button" data-path="">
              <i class="fa fa-wechat bigger-110"></i>
              查看小程序码
            </button>
            &nbsp; &nbsp; &nbsp;
          <?php } ?>

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
<?php require $view->getFile('@wxa-code/admin/_codeModal.php') ?>

<?= $block->js() ?>
<script>
  var isWxa = <?= json_encode($isWxa) ?>;
  require(['linkTo'], function () {
    var generateLinkAction = function (options) {
      $.extend(this, options);

      var that = this;
      var $url = $('.js-url');
      var $result = $('.js-result');

      updateUrl();

      $url.change(updateUrl);

      // 选择预设链接
      $('.js-link-to').linkTo({
        linkText: '请选择',
        hide: {
          keyword: true,
          decorator: true
        },
        update: function (data) {
          $url.val($.url(data.value));
          updateUrl();
        }
      });

      // 点击复制活动链接
      $('.js-copy').click(function () {
        if (!$result.val()) {
          $.err('请先输入链接');
          return;
        }

        $result[0].select();
        document.execCommand('copy');
        $.suc('复制成功');
      });

      function updateUrl() {
        var val = $url.val();
        if (val === '') {
          $result.val('');
          return;
        }

        var param = {};
        param[that.paramName] = that.data.code;
        var url = $.appendUrl($url.val(), param);
        if (isWxa) {
          url = $.appendUrl('/pages/index/index', {url: url});
        }

        $result.val(url);
        $('.js-wxa-code-show').data('path', url);
      }
    };

    generateLinkAction({
      data: <?= $source->toJson() ?>,
      paramName: '<?= Source::PARAM_NAME ?>'
    });
  });
</script>
<?= $block->end() ?>
