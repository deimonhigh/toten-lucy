(function (angular) {
  "use strict";
  angular.module('appToten')
         .directive('cartaoCredito', cartaoCredito);

  cartaoCredito.$inject = ['$timeout'];

  function cartaoCredito($timeout) {
    return {
      restrict: 'A',
      require: 'ngModel',
      scope: {
        ngModel: '=ngModel'
      },
      link: function (scope, element, attrs, ngModelCtrl) {
        ngModelCtrl.$setValidity('cartaoCredito', true);

        ngModelCtrl.$formatters.push(function (value) {
          return formatCartao(value);
        });

        ngModelCtrl.$parsers.push(function (value) {
          if (value) {
            var transformedInput = value.toString().replace(/[^0-9]/g, '');
            $timeout(function () {
              ngModelCtrl.$setViewValue(formatCartao(transformedInput.substring(0, 18)));
              ngModelCtrl.$render();

              if (ngModelCtrl.$viewValue) {
                setCaretPosition(element[0], ngModelCtrl.$viewValue.length);
              }
            });

            return transformedInput;
          }
        });

        ngModelCtrl.$parsers.push(function (value) {
          if (value) {
            if (value.toString().replace(/\s/g, '').length >= 14) {
              ngModelCtrl.$setValidity('cartaoCredito', true);
              return value;
            } else {
              ngModelCtrl.$setValidity('cartaoCredito', false);
              return;
            }
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

    //region Cartao Credito
    function formatCartao(value) {
      if (value) {
        value = value.replace(/\D/g, "");
        value = value.replace(/^(\d{4})(\d)/g, "$1 $2");
        value = value.replace(/^(\d{4})\s(\d{4})(\d)/g, "$1 $2 $3");
        value = value.replace(/^(\d{4})\s(\d{4})\s(\d{4})(\d)/g, "$1 $2 $3 $4");
        return value;
      }
    }

    //endregion

  }

})(angular);
