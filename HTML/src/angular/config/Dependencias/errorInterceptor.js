angular
  .module("appToten")
  .factory("errorInterceptor", errorInterceptor);

errorInterceptor.$inject = ['$location'];

function errorInterceptor($location) {
  return {
    responseError: function (rejection) {
      if (rejection.status === 404) {
        $location.path("/404");
      }
      return $q.reject(rejection);
    }
  };
};