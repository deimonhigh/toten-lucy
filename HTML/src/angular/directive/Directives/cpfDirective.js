(function (angular) {
  "use strict";
  angular.module('appToten')
         .directive('cpf', cpf);

  cpf.$inject = [];

  function cpf() {
    return {
      restrict: 'A',
      require: 'ngModel',
      link: function (scope, element, attrs, ngModel) {
        var options = {
          onKeyPress: function (cpf, ev, el, op) {
            var masks = ['000.000.000-000', '00.000.000/0000-00'],
                mask  = (cpf.length > 14) ? masks[1] : masks[0];
            el.mask(mask, op);
          }
        }

        $(element).mask('000.000.000-000', options);

//        $(element).mask('000.000.000-00', {reverse: true});

        ngModel.$setValidity('cpf', true);
        ngModel.$setValidity('cnpj', true);

        ngModel.$parsers.push(function (value) {
          if (value) {
            return value.toString().replace(/[^0-9]/g, '');
          }
        });

        ngModel.$parsers.push(function (value) {

          if (value.toString().length > 11) {
            var cond = validarCNPJ(value);
            if (cond) {
              ngModel.$setValidity('cnpj', true);
              ngModel.$setValidity('cpf', true);
              return value;
            } else {
              ngModel.$setValidity('cpf', true);
              ngModel.$setValidity('cnpj', false);
              return undefined;
            }
          } else {
            var cond = validarCPF(value);
            if (cond) {
              ngModel.$setValidity('cpf', true);
              ngModel.$setValidity('cnpj', true);
              return value;
            } else {
              ngModel.$setValidity('cpf', false);
              ngModel.$setValidity('cnpj', true);
              return undefined;
            }
          }

        });
      }
    };

  }

  function validarCPF(cpf) {
    cpf = cpf.replace(/[^\d]+/g, '');
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

  function validarCNPJ(cnpj) {

    cnpj = cnpj.replace(/[^\d]+/g, '');

    if (cnpj == '') return false;

    if (cnpj.length != 14) {
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
    var tamanho = cnpj.length - 2
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
    for (var i = tamanho; i >= 1; i--) {
      soma += numeros.charAt(tamanho - i) * pos--;
      if (pos < 2) {
        pos = 9;
      }
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(1)) {
      return false;
    }

    return true;

  }
})(angular);
