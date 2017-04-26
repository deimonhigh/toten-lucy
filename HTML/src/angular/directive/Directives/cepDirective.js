(function (angular) {
  "use strict";
  angular.module('appGoPharma')
         .directive('cep', cep);

  cep.$inject = [];

  function cep() {
    return {
      restrict: 'A',
      require: 'ngModel',
      link: function (scope, element) {
        $(element).mask('00000-000', {reverse: true});
      }
    };

  }

})(angular);
