(function (angular) {
  "use strict";
  angular.module('appGoPharma')
         .directive('limit', limit);

  limit.$inject = [];

  function limit() {
    return {
      restrict: 'A',
      link: function (scope, element) {
        $(element).on('keydown keyup', function () {
          var maxLength = $(this).attr('maxlength');
          if ($(this).val().length > maxLength) {
            $(this).val($(this).val().substring(0, maxLength));
          }
        });

        $(element).on('input paste', function (evt) {
          var el = $(this);
          var maxLength = el.attr('maxlength');
          setTimeout(function () {
            if (el.val().length > maxLength) {
              el.val(el.val().substring(0, maxLength));
            }
          }, 100);
        });

      }
    };
  }

})(angular);
