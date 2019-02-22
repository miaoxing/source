define([
  plugins/app/libs/artTemplate/template.min,
  'plugins/link-to/js/link-to',
  'form',
  'plugins/app/js/validation',
  'plugins/admin/js/data-table',
  'plugins/admin/js/date-range-picker',
  'plugins/app/libs/jquery.populate/jquery.populate',
], function (template) {
  var Sources = function () {
    this.data = {};
    this.$el = $('body');
  };

  Sources.prototype.$ = function (selector) {
    return this.$el.find(selector);
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

  return new Sources();
});
