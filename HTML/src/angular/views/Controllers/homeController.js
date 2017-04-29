(function (angular) {
  "use strict";
  angular.module('appToten')
         .controller('homeController', homeController);

  homeController.$inject = ['$scope', '$rootScope', 'apiService', '$timeout'];

  function homeController($scope, $rootScope, apiService, $timeout) {
    var vm = $scope;
    var root = $rootScope;

  }

})
(angular);