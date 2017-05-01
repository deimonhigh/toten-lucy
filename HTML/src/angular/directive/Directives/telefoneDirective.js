(function (angular) {
  "use strict";
  angular.module('appToten')
         .directive('telefone', telefone);

  telefone.$inject = [];

  function telefone() {
    return {
      restrict: 'A',
      require: 'ngModel',
      link: function (scope, element, attrs, ngModel) {
        var SPMaskBehavior = function (val) {
              return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            },
            spOptions      = {
              onKeyPress: function (val, e, field, options) {
                field.mask(SPMaskBehavior.apply({}, arguments), options);
              }
            };

        $(element).mask(SPMaskBehavior, spOptions);

        ngModel.$setValidity('telefone', true);

        ngModel.$parsers.push(function (value) {
          if (value) {
            return value.toString().replace(/[^0-9]/g, '');
          }
        });

        ngModel.$parsers.push(function (value) {
          if (value && value.length >= 10) {
            ngModel.$setValidity('telefone', true);
            return value;
          } else {
            ngModel.$setValidity('telefone', false);
            return undefined;
          }
        });
      }
    };

  }

})(angular);
