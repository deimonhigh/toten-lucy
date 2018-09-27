(function (angular) {
  angular
    .module("appToten")
    .factory('errorInterceptor', errorInterceptor);

  errorInterceptor.$inject = ['$q', '$state', '$injector'];
  function errorInterceptor($q, $state, $injector) {
    return {
      responseError: function (rejection) {
        if (rejection.status === 401) {
          var api = $injector.get('apiService');
          api.clearStorage();
          $state.go("login");
        }
        return $q.reject(rejection);
      }
    }
  }

})(angular);