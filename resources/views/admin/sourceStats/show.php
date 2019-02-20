<?php

$view->layout();
?>

<?= $block->css() ?>
<link rel="stylesheet" href="<?= $asset('assets/admin/stat.css') ?>"/>
<?= $block->end() ?>

<?= $block('header-actions') ?>
<a class="btn btn-default" href="<?= $url('admin/sources') ?>">返回来源列表</a>
<?= $block->end() ?>

<div class="row">
  <div class="col-12">

    <div class="well well-sm bigger-110">
      名称：<?= $e($source['name']) ?>
    </div>

    <div class="well well-sm">
      <form class="js-chart-form form-inline">
        <div class="form-group">
          <label class="control-label" for="range-date">日期范围</label>
          <input type="text" class="js-range-date form-control text-center input-large" id="range-date"
            value="<?= $e($startDate . ' ~ ' . $endDate) ?>">
          <input type="hidden" class="js-start-date" name="start_date">
          <input type="hidden" class="js-end-date" name="end_date">
        </div>
      </form>
    </div>

    <h5 class="stat-title">趋势图</h5>

    <ul class="js-chart-tabs nav tab-underline">
      <li role="presentation" class="nav-item">
        <a href="#view" class="nav-link active" aria-controls="view" role="tab" data-toggle="tab">访问数</a>
      </li>
      <li role="presentation" class="nav-item">
        <a href="#order" class="nav-link" aria-controls="subscribe" role="tab" data-toggle="tab">订单数</a>
      </li>
    </ul>
    <div class="tab-content mt-3 border-0">
      <div role="tabpanel" class="js-chart-pane tab-pane text-center active" id="view">
        加载中...
      </div>
      <div role="tabpanel" class="js-chart-pane tab-pane" id="order"></div>
    </div>

    <hr>

    <h5 class="stat-title">详细数据</h5>

    <table class="js-stat-table table table-center table-head-bordered">
      <thead>
      <tr>
        <th>日期</th>
        <th>PV</th>
        <th>UV</th>
        <th>订单数</th>
        <th>订单金额</th>
      </tr>
      </thead>
      <tbody>
      </tbody>
    </table>

  </div>
  <!-- /col -->
</div>
<!-- /row -->

<?= $block->js() ?>
<script>
  require([
    'plugins/stat/js/stat',
    'template',
    'plugins/stat/js/highcharts',
    'form',
    'jquery-deparam',
    'plugins/admin/js/data-table',
    'daterangepicker'
  ], function (stat, template) {
    // 渲染底部表格
    var $statTable = $('.js-stat-table').dataTable({
      dom: 't',
      ajax: null,
      processing: false,
      serverSide: false,
      displayLength: 99999,
      columnDefs: [{
        targets: ['_all'],
        sortable: true
      }],
      columns: [
        {
          data: 'stat_date'
        },
        {
          data: 'view_count'
        },
        {
          data: 'view_user'
        },
        {
          data: 'order_count'
        },
        {
          data: 'order_amount_value'
        },
      ]
    });

    // 所有图表的配置
    var charts = [
      {
        id: 'view',
        series: [
          {
            name: 'PV',
            dataSource: 'view_count'
          },
          {
            name: 'UV',
            dataSource: 'view_user'
          }
        ],
        xAxis: {
          categoriesSource: 'stat_date'
        }
      },
      {
        id: 'order',
        series: [
          {
            name: '订单数',
            dataSource: 'order_count'
          },
          {
            name: '订单金额',
            dataSource: 'order_amount_value'
          },
        ],
        xAxis: {
          categoriesSource: 'stat_date'
        }
      }
    ];

    var $form = $('.js-chart-form');

    function render() {
      $.ajax({
        url: $.queryUrl('admin/source-stats/show.json'),
        dataType: 'json',
        data: $form.serializeArray(),
        success: function (ret) {
          if (ret.code !== 1) {
            $.msg(ret);
            return;
          }

          stat.renderChart({
            charts: charts,
            data: ret.data
          });
          $statTable.fnClearTable();
          $statTable.fnAddData(ret.data);
        }
      });
    }

    render();

    // 更新表单时,重新渲染
    $form.update(function () {
      render();
    });

    // 日期范围选择
    $('.js-range-date').daterangepicker({
      format: 'YYYY-MM-DD',
      separator: ' ~ ',
    }, function (start, end) {
      $('.js-start-date').val(start.format(this.format));
      $('.js-end-date').val(end.format(this.format));
      this.element.trigger('change');
    });
  });
</script>
<?= $block->end() ?>
