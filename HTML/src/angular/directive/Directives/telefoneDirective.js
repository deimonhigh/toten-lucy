(function (angular) {
  "use strict";
  angular.module('appGoPharma')
         .directive('telefone', telefone);

  telefone.$inject = [];

  function telefone() {
    return {
      restrict: 'A',
      require: 'ngModel',
      link: function (scope, element) {
        var SPMaskBehavior = function (val) {
              return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            },
            spOptions      = {
              onKeyPress: function (val, e, field, options) {
                field.mask(SPMaskBehavior.apply({}, arguments), options);
              }
            };

        $(element).mask(SPMaskBehavior, spOptions);
      }
    };

  }

})(angular);
