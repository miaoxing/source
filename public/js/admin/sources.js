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

  return new Sources;
});
