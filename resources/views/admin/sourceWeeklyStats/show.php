<?php

$view->layout();
?>

<?= $block->css() ?>
<link rel="stylesheet" href="<?= $asset('plugins/stat/css/stat.css') ?>"/>
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
          <label class="control-label" for="range-date">周数的日期范围</label>
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
        <a href="#subscribe" class="nav-link" aria-controls="subscribe" role="tab" data-toggle="tab">关注数</a>
      </li>
      <li role="presentation" class="nav-item">
        <a href="#member" class="nav-link" aria-controls="member" role="tab" data-toggle="tab">会员数</a>
      </li>
      <li role="presentation" class="nav-item">
        <a href="#card" class="nav-link" aria-controls="card" role="tab" data-toggle="tab">卡券数</a>
      </li>
      <li role="presentation" class="nav-item">
        <a href="#score" class="nav-link" aria-controls="score" role="tab" data-toggle="tab">积分数</a>
      </li>
    </ul>
    <div class="tab-content mt-3 border-0">
      <div role="tabpanel" class="js-chart-pane tab-pane text-center active" id="view">
        加载中...
      </div>
      <div role="tabpanel" class="js-chart-pane tab-pane" id="subscribe"></div>
      <div role="tabpanel" class="js-chart-pane tab-pane" id="member"></div>
      <div role="tabpanel" class="js-chart-pane tab-pane" id="card"></div>
      <div role="tabpanel" class="js-chart-pane tab-pane" id="score"></div>
    </div>

    <hr>

    <h5 class="stat-title">详细数据</h5>

    <table class="js-stat-table table table-center table-head-bordered">
      <thead>
      <tr>
        <th>日期（周）</th>
        <th>PV</th>
        <th>关注数</th>
        <th>取关数</th>
        <th>净增关注数</th>
        <th>有消费会员数</th>
        <th>领取会员卡数</th>
        <th>领取优惠券数</th>
        <th>核销优惠券数</th>
        <th>增加积分数</th>
        <th>使用积分数</th>
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
    plugins/app/libs/artTemplate/template.min,
    'plugins/stat/js/highcharts',
    'form',
    'plugins/admin/js/data-table',
    'plugins/admin/js/date-range-picker'
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
          data: 'stat_week'
        },
        {
          data: 'view_count'
        },
        {
          data: 'subscribe_user'
        },
        {
          data: 'unsubscribe_user'
        },
        {
          data: 'net_subscribe_value'
        },
        {
          data: 'consume_member_user'
        },
        {
          data: 'receive_member_count'
        },
        {
          data: 'receive_card_count'
        },
        {
          data: 'consume_card_count'
        },
        {
          data: 'add_score_value'
        },
        {
          data: 'sub_score_value'
        }
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
          }
        ],
        xAxis: {
          categoriesSource: 'stat_week'
        }
      },
      {
        id: 'subscribe',
        series: [
          {
            name: '关注数',
            dataSource: 'subscribe_user'
          },
          {
            name: '取关数',
            dataSource: 'unsubscribe_user'
          },
          {
            name: '净增关注数',
            dataSource: 'net_subscribe_value'
          }
        ],
        xAxis: {
          categoriesSource: 'stat_week'
        }
      },
      {
        id: 'member',
        series: [
          {
            name: '有消费会员数',
            dataSource: 'consume_member_user'
          },
          {
            name: '领取会员卡数',
            dataSource: 'receive_member_count'
          }
        ],
        xAxis: {
          categoriesSource: 'stat_week'
        }
      },
      {
        id: 'card',
        series: [
          {
            name: '领取优惠券数',
            dataSource: 'receive_card_count'
          },
          {
            name: '核销优惠券数',
            dataSource: 'consume_card_count'
          }
        ],
        xAxis: {
          categoriesSource: 'stat_week'
        }
      },
      {
        id: 'score',
        series: [
          {
            name: '增加积分数',
            dataSource: 'add_score_value'
          },
          {
            name: '使用积分数',
            dataSource: 'sub_score_value'
          }
        ],
        xAxis: {
          categoriesSource: 'stat_week'
        }
      }
    ];

    var $form = $('.js-chart-form');

    function render() {
      $.ajax({
        url: $.queryUrl('admin/source-weekly-stats/show.json'),
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
      showWeekNumbers: true
    }, function (start, end) {
      $('.js-start-date').val(start.format(this.format));
      $('.js-end-date').val(end.format(this.format));
      this.element.trigger('change');
    });
  });
</script>
<?= $block->end() ?>
