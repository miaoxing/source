define([
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

  return new Sources();
});
