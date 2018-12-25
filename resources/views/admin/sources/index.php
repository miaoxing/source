<?php

use Miaoxing\Source\Service\Source;

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
          <th>关注二维码</th>
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
  <a class="js-qrcode-show" href="javascript:;" data-scene-id="<%= code %>">查看</a>
</script>

<script id="action-tpl" type="text/html">
  <a href="<%= $.url('admin/source-weekly-stats/show', {source_id: id}) %>">统计</a>
  <a href="<%= $.url('admin/sources/%s/generate-link', id) %>">生成链接</a>
  <% if (source != <?= Source::SOURCE_ADMIN ?>) { %>
    <a href="<%= $.url('admin/sources/%s/edit', id) %>">编辑</a>
    <a class="delete-record text-danger" href="javascript:"
      data-href="<%= $.url('admin/sources/%s/destroy', id) %>">删除</a>
  <% } %>
</script>

<?= $block->js() ?>
<script>
  require([
    'template',
    'linkTo',
    'form',
    'validator',
    'dataTable',
    'daterangepicker',
    'plugins/app/libs/jquery.populate/jquery.populate',
  ], function (template) {
    var Sources = function () {
      this.data = {};
      this.$el = $('body');
    };

    Sources.prototype.$ = function (selector) {
      return this.$el.find(selector);
    };

    Sources.prototype.indexAction = function () {
      var $table = this.$('.js-source-table').dataTable({
        sorting: [[0, 'desc']],
        ajax: {
          url: $.queryUrl('admin/sources.json')
        },
        columns: [
          {
            data: 'id',
            visible: false
          },
          {
            data: 'code'
          },
          {
            data: 'name'
          },
          {
            data: 'view_count',
            sortable: true
          },
          {
            data: 'subscribe_user',
            sortable: true
          },
          {
            data: 'unsubscribe_user',
            sortable: true
          },
          {
            data: 'net_subscribe_value',
            sortable: true
          },
          {
            data: 'consume_member_user',
            sortable: true
          },
          {
            data: 'receive_member_count',
            sortable: true
          },
          {
            data: 'receive_card_count',
            sortable: true
          },
          {
            data: 'consume_card_count',
            sortable: true
          },
          {
            data: 'add_score_value',
            sortable: true
          },
          {
            data: 'sub_score_value',
            sortable: true
          },
          {
            data: 'id',
            render: function (data, type, full) {
              return template.render('js-qrcode-scene-id-tpl', full);
            }
          },
          {
            data: 'created_at',
            render: function (data) {
              return data.substr(10) + '<br>' + data.substr(0, 10);
            }
          },
          {
            data: 'id',
            sClass: 'text-center',
            render: function (data, type, full) {
              return template.render('action-tpl', full);
            }
          }
        ]
      });

      $table.deletable();


      this.$('.js-source-form')
        .loadParams()
        .submit(function (e) {
          $table.reload($(this).serialize(), false);
          e.preventDefault();
        });

      // 日期范围选择
      $('.js-range-date').daterangepicker({
        format: 'YYYY-MM-DD',
        separator: ' ~ '
      }, function (start, end) {
        $('.js-start-date').val(start.format(this.format));
        $('.js-end-date').val(end.format(this.format));
        this.element.trigger('change');
      });
    };

    Sources.prototype.editAction = function (options) {
      $.extend(this, options);

      this.$('.js-source-form')
        .populate(this.data)
        .ajaxForm({
          url: $.url('admin/sources/update'),
          dataType: 'json',
          beforeSubmit: function (arr, $form) {
            return $form.valid();
          },
          success: function (ret) {
            $.msg(ret, function () {
              if (ret.code === 1) {
                window.location.href = $.url('admin/sources');
              }
            });
          }
        })
        .validate();
    };

    Sources.prototype.paramName = 'mx_source';

    Sources.prototype.generateLinkAction = function (options) {
      $.extend(this, options);

      var that = this;
      var $url = $('.js-url');
      var $result = $('.js-result');

      updateUrl();

      $url.change(updateUrl);

      // 选择预设链接
      this.$('.js-link-to').linkTo({
        linkText: '请选择',
        hide: {
          keyword: true,
          decorator: true
        },
        update: function (data) {
          $url.val(window.location.origin + $.url(data.value));
          updateUrl();
        }
      });

      // 点击复制活动链接
      this.$('.js-copy').click(function () {
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
        $result.val($.appendUrl($url.val(), param));
      }
    };

    var source =  new Sources();
    source.indexAction();
  });
</script>
<?= $block->end() ?>
