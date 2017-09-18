<?php

$view->layout();
?>

<?= $block('header-actions') ?>
<a class="btn btn-success" href="<?= $url('admin/sources/new') ?>">新建来源</a>
<?= $block->end() ?>

<div class="row">
  <div class="col-xs-12">
    <!-- PAGE CONTENT BEGINS -->
    <div class="table-responsive">
      <form class="js-source-form form-horizontal filter-form" role="form">
        <div class="well form-well m-b">
          <div class="form-group form-group-sm">
            <label class="col-md-1 control-label" for="name">名称：</label>

            <div class="col-md-3">
              <input type="text" class="js-name form-control" id="name" name="name">
            </div>

            <div class="form-group form-group-sm">

              <label class="col-md-1 control-label" for="created-at">创建时间：</label>

              <div class="col-md-3">
                <input type="text" class="js-range-date form-control" id="created-at">
                <input type="hidden" class="js-start-date" name="start_date">
                <input type="hidden" class="js-end-date" name="end_date">
              </div>

            </div>

          </div>

          <div class="clearfix form-group form-group-sm">
            <div class="col-md-offset-1 col-md-6">
              <button class="js-user-filter btn btn-primary btn-sm" type="submit">
                查询
              </button>
            </div>
          </div>
        </div>
      </form>

      <table class="js-source-table record-table table table-bordered table-hover">
        <thead>
        <tr>
          <th>编号</th>
          <th>标识</th>
          <th>名称</th>
          <th>点击数</th>
          <th>关注数</th>
          <th>取关数</th>
          <th>剩余关注数</th>
          <th>有消费会员数</th>
          <th>领取会员卡数</th>
          <th>领取优惠券数</th>
          <th>核销优惠券数</th>
          <th>增加积分数</th>
          <th>使用积分数</th>
          <th>二维码</th>
          <th class="t-5">创建时间</th>
          <th class="t-11">操作</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
    <!-- /.table-responsive -->
    <!-- PAGE CONTENT ENDS -->
  </div>
  <!-- /col -->
</div>
<!-- /row -->

<?php require $view->getFile('@wechat/admin/wechatQrcode/qrcodeModal.php') ?>

<script id="js-qrcode-scene-id-tpl" type="text/html">
  <a class="js-qrcode-show" href="javascript:;" data-scene-id="<%= source %>">查看</a>
</script>

<script id="action-tpl" type="text/html">
  <a href="<%= $.url('admin/source-weekly-stats/show', {source_id: id}) %>">统计</a>
  <a href="<%= $.url('admin/sources/%s/generate-link', id) %>">生成链接</a>
  <% if (type != 1) { %>
    <a href="<%= $.url('admin/sources/%s/edit', id) %>">编辑</a>
    <a class="delete-record text-danger" href="javascript:"
      data-href="<%= $.url('admin/sources/%s/destroy', id) %>">删除</a>
  <% } %>
</script>

<?= $block('js') ?>
<script>
  require(['plugins/source/js/admin/sources'], function (source) {
    source.indexAction();
  });
</script>
<?= $block->end() ?>
