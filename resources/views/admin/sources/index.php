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

      <table class="js-source-table record-table table table-bordered table-hover">
        <thead>
        <tr>
          <th>名称</th>
          <th>最后修改时间</th>
          <th class="t-12">操作</th>
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

<script id="action-tpl" type="text/html">
  <a href="<%= $.url('admin/sources-stats/show', {source_id: id}) %>">统计</a>
  <a href="<%= $.url('admin/sources/%s/edit', id) %>">编辑</a>
  <a class="delete-record text-danger" href="javascript:"
    data-href="<%= $.url('admin/sources/%s/destroy', id) %>">删除</a>
</script>

<?= $block('js') ?>
<script>
  require(['plugins/source/js/admin/sources'], function (source) {
    source.indexAction();
  });
</script>
<?= $block->end() ?>
