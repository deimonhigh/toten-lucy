(function (angular) {
  "use strict";
  angular.module('appGoPharma')
         .directive('cpf', cpf);

  cpf.$inject = [];

  function cpf() {
    return {
      restrict: 'A',
      require: 'ngModel',
      link: function (scope, element) {
        $(element).mask('000.000.000-00', {reverse: true});
      }
    };

  }

})(angular);
