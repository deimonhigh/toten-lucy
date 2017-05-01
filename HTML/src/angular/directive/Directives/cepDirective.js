(function (angular) {
  "use strict";
  angular.module('appToten')
         .directive('cep', cep);

  cep.$inject = [];

  function cep() {
    return {
      restrict: 'A',
      require: 'ngModel',
      link: function (scope, element, attrs, ngModel) {
        $(element).mask('00000-000', {reverse: true});

        ngModel.$setValidity('cep', true);

        ngModel.$parsers.push(function (value) {
          if (value) {
            return value.toString().replace(/[^0-9]/g, '');
          }
        });

        ngModel.$parsers.push(function (value) {
          if (value && value.length >= 8) {
            ngModel.$setValidity('cep', true);
            return value;
          } else {
            ngModel.$setValidity('cep', false);
            return undefined;
          }
        });

      }
    };

  }

})(angular);
