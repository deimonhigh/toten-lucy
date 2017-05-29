(function (angular) {
  "use strict";
  angular.module('appToten')
         .directive('cpf', cpf);

  cpf.$inject = ['$timeout'];

  function cpf($timeout) {
    return {
      restrict: 'A',
      require: 'ngModel',
      scope: {
        ngModel: '=ngModel'
      },
      link: function (scope, element, attrs, ngModelCtrl) {
        ngModelCtrl.$setValidity('cpf', true);

        ngModelCtrl.$formatters.push(function (value) {
          return formatterCPF(value);
        });

        ngModelCtrl.$parsers.push(function (value) {
          if (value) {
            var transformedInput = value.replace(/[^0-9]/g, '');
            ngModelCtrl.$setViewValue(formatterCPF(transformedInput.substring(0, 11)));
            ngModelCtrl.$render();

            $timeout(function () {
              if (ngModelCtrl.$viewValue) {
                setCaretPosition(element[0], ngModelCtrl.$viewValue.length);
              }
            });

            return transformedInput;
          }
        });

        ngModelCtrl.$parsers.push(function (value) {

          if (value) {
            var cond = validarCPF(value.toString());
            if (cond) {
              ngModelCtrl.$setValidity('cpf', true);
              return value;
            } else {
              ngModelCtrl.$setValidity('cpf', false);
              return value;
            }
          }
        });

        //$(element).mask('000.000.000-00', {reverse: true});
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

    function validarCPF(cpf) {
      if (!cpf) {
        return false;
      }
      cpf = cpf.replace(/[^0-9]+/g, '');
      if (cpf == '') return false;
      var rev;

      // Elimina CPFs invalidos conhecidos
      if (cpf.length != 11 ||
          cpf == "00000000000" ||
          cpf == "11111111111" ||
          cpf == "22222222222" ||
          cpf == "33333333333" ||
          cpf == "44444444444" ||
          cpf == "55555555555" ||
          cpf == "66666666666" ||
          cpf == "77777777777" ||
          cpf == "88888888888" ||
          cpf == "99999999999") {
        return false;
      }
      // Valida 1o digito
      var add = 0;
      for (var i = 0; i < 9; i++) {
        add += parseInt(cpf.charAt(i)) * (10 - i);
      }
      rev = 11 - (add % 11);
      if (rev == 10 || rev == 11) {
        rev = 0;
      }
      if (rev != parseInt(cpf.charAt(9))) {
        return false;
      }
      // Valida 2o digito
      add = 0;
      for (var i = 0; i < 10; i++) {
        add += parseInt(cpf.charAt(i)) * (11 - i);
      }
      rev = 11 - (add % 11);
      if (rev == 10 || rev == 11) {
        rev = 0;
      }
      if (rev != parseInt(cpf.charAt(10))) {
        return false;
      }
      return true;
    }

    function formatterCPF(value) {
      if (value) {
        value = value.replace(/[^0-9]/g, "");
        value = value.replace(/(\d{3})(\d)/, "$1.$2");
        value = value.replace(/(\d{3})(\d)/, "$1.$2");
        value = value.replace(/(\d{3})(\d{1,2})$/, "$1-$2");

        return value;
      }
    }

  }

})(angular);
