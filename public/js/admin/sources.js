define([
  'template',
  'form',
  'validator',
  'dataTable'
], function (template) {
  var Sources = function () {
    this.data = {};
    this.$el = $('body');
  };

  Sources.prototype.$ = function (selector) {
    return this.$el.find(selector);
  };

  Sources.prototype.indexAction = function () {
    var $recordTable = this.$('.js-source-table').dataTable({
      ajax: {
        url: $.queryUrl('admin/sources.json')
      },
      columns: [
        {
          data: 'name'
        },
        {
          data: 'updated_at'
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

    $recordTable.deletable();
  };

  Sources.prototype.editAction = function (options) {
    $.extend(this, options);

    this.$('.js-source-form')
      .loadJSON(this.data)
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
      var param = {};
      param[that.paramName] = that.data.id;
      $result.val($.appendUrl($url.val(), param));
    }
  };

  return new Sources();
});
