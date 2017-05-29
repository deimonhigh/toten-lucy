(function (angular) {
  "use strict";
  angular.module('appToten')
         .directive('telefone', telefone);

  telefone.$inject = ['$timeout'];

  function telefone($timeout) {
    return {
      restrict: 'A',
      require: 'ngModel',
      scope: {
        ngModel: '=ngModel'
      },
      link: function (scope, element, attrs, ngModelCtrl) {
        ngModelCtrl.$setValidity('cpf', true);

        ngModelCtrl.$formatters.push(function (value) {
          return maskTelefone(value);
        });

        ngModelCtrl.$parsers.push(function (value) {
          if (value) {
            var transformedInput = value.replace(/[^0-9]/g, '');
            ngModelCtrl.$setViewValue(maskTelefone(transformedInput.substring(0, 11)));
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

    function formatterDefault(value) {
      if (value) {
        value = value.replace(/\D/g, "");
        value = value.replace(/^(\d{2})(\d)/g, "($1) $2");
        value = value.replace(/(\d)(\d{4})$/, "$1-$2");

        return value;
      }
    }

    function formatterNoDdd(value) {
      if (value) {
        value = value.replace(/\D/g, "");
        value = value.replace(/(\d)(\d{4})$/, "$1-$2");

        return value;
      }
    }

    function formatterGeral(value) {
      if (value) {
        value = value.replace(/\D/g, "");
        value = value.replace(/^(\d{4})(\d)/, "$1-$2");
        value = value.replace(/(\d)(\d{4})$/, "$1-$2");

        return value;
      }
    }

    function maskTelefone(value) {
      if (value) {
        var len = value.replace(/\D/g, "").length;

        if (len > 9 && len <= 11 && value.indexOf('0800') == -1) {
          return formatterDefault(value);
        } else if (len <= 9) {
          return formatterNoDdd(value);
        }
        if (len == 11 && value.indexOf('0800') > -1) {
          return formatterGeral(value);
        }
      } else {
        return value
      }
    }
  }

})(angular);
