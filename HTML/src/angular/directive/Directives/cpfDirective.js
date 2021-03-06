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
          return chooseFormatter(value);
        });

        ngModelCtrl.$parsers.push(function (value) {
          if (value) {
            var transformedInput = value.toString().replace(/[^0-9]/g, '');
            var tamanho = transformedInput.length <= 11 ? 11 : 14;

            $timeout(function () {
              ngModelCtrl.$setViewValue(chooseFormatter(transformedInput.substring(0, tamanho)));
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
            var cond = chooseValidation(value.toString());
            if (cond) {
              ngModelCtrl.$setValidity('cpf', true);
              return value;
            } else {
              ngModelCtrl.$setValidity('cpf', false);
              return undefined;
            }
          }
        });
      }
    };

    function chooseValidation(value) {
      if (value) {
        if (value.length <= 11) {
          return validarCPF(value);
        } else {
          return validarCNPJ(value);
        }
      }
    }

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

    function chooseFormatter(value) {
      if (value) {
        value = value.toString();

        if (value.length <= 11) {
          return formatterCPF(value);
        } else {
          return formatterCNPJ(value);
        }
      }
    }

    //region CNPJ
    function validarCNPJ(cnpj) {
      cnpj = cnpj.toString().replace(/[^\d]+/g, '');

      if (cnpj.length === 0) return false;

      if (cnpj.length !== 14) {
        return false;
      }

      // Elimina CNPJs invalidos conhecidos
      if (cnpj == "00000000000000" ||
          cnpj == "11111111111111" ||
          cnpj == "22222222222222" ||
          cnpj == "33333333333333" ||
          cnpj == "44444444444444" ||
          cnpj == "55555555555555" ||
          cnpj == "66666666666666" ||
          cnpj == "77777777777777" ||
          cnpj == "88888888888888" ||
          cnpj == "99999999999999") {
        return false;
      }

      // Valida DVs
      var tamanho = cnpj.length - 2;
      var numeros = cnpj.substring(0, tamanho);
      var digitos = cnpj.substring(tamanho);
      var soma = 0;
      var pos = tamanho - 7;
      for (var i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2) {
          pos = 9;
        }
      }
      var resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
      if (resultado != digitos.charAt(0)) {
        return false;
      }

      tamanho = tamanho + 1;
      numeros = cnpj.substring(0, tamanho);
      soma = 0;
      pos = tamanho - 7;
      for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2) {
          pos = 9;
        }
      }
      resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
      return resultado == digitos.charAt(1);
    }

    function formatterCNPJ(value) {
      if (value) {
        value = value.replace(/\D/g, "");
        value = value.replace(/^(\d{2})(\d)/, "$1.$2");
        value = value.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3");
        value = value.replace(/\.(\d{3})(\d)/, ".$1/$2");
        value = value.replace(/(\d{4})(\d)/, "$1-$2");
        return value;
      }
    }

    //endregion

    //region CPF
    function validarCPF(cpf) {
      if (!cpf) {
        return false;
      }
      cpf = cpf.toString().replace(/[^0-9]+/g, '');
      if (cpf.length === 0) return false;
      var rev;

      // Elimina CPFs invalidos conhecidos
      if (cpf.length !== 11 ||
          cpf === "00000000000" ||
          cpf === "11111111111" ||
          cpf === "22222222222" ||
          cpf === "33333333333" ||
          cpf === "44444444444" ||
          cpf === "55555555555" ||
          cpf === "66666666666" ||
          cpf === "77777777777" ||
          cpf === "88888888888" ||
          cpf === "99999999999") {
        return false;
      }
      // Valida 1o digito
      var add = 0;
      for (var i = 0; i < 9; i++) {
        add += parseInt(cpf.charAt(i)) * (10 - i);
      }
      rev = 11 - (add % 11);
      if (rev === 10 || rev === 11) {
        rev = 0;
      }
      if (rev !== parseInt(cpf.charAt(9))) {
        return false;
      }
      // Valida 2o digito
      add = 0;
      for (var i = 0; i < 10; i++) {
        add += parseInt(cpf.charAt(i)) * (11 - i);
      }
      rev = 11 - (add % 11);
      if (rev === 10 || rev === 11) {
        rev = 0;
      }

      return rev === parseInt(cpf.charAt(10));
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

    //endregion

  }

})(angular);
