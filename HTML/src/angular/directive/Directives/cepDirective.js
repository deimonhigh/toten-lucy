(function (angular) {
  "use strict";
  angular.module('appToten')
         .directive('cep', cep);

  cep.$inject = ['$timeout'];

  function cep($timeout) {
    return {
      restrict: 'A',
      require: 'ngModel',
      scope: {
        ngModel: '=ngModel'
      },
      link: function (scope, element, attrs, ngModelCtrl) {

        ngModelCtrl.$formatters.push(function (value) {
          return formatter(value);
        });

        ngModelCtrl.$parsers.push(function (value) {
          if (value) {
            var transformedInput = value.replace(/[^0-9]/g, '');
            ngModelCtrl.$setViewValue(formatter(transformedInput.substring(0, 8)));
            ngModelCtrl.$render();

            $timeout(function () {
              if (ngModelCtrl.$viewValue) {
                setCaretPosition(element[0], ngModelCtrl.$viewValue.length);
              }
            });

            return value.replace(/[^0-9]/g, "");
          }
        });
      }
    };

    function setCaretPosition(el) {
      if (typeof el.selectionStart == "number") {
        el.selectionStart = el.selectionEnd = el.value.length;
      } else if (typeof el.createTextRange != "undefined") {
        el.focus();
        var range = el.createTextRange();
        range.collapse(false);
        range.select();
      }
    }

    function formatter(value) {
      if (value) {
        value = value.toString().replace(/D/g, "");
        value = value.replace(/^(\d{5})(\d)/, "$1-$2");
        return value;
      }
    }

  }

})(angular);
