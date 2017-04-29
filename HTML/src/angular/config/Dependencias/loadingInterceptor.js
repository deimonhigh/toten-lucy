﻿angular
  .module("appToten")
  .factory("loadingInterceptor", loadingInterceptor);

loadingInterceptor.$inject = ['$q', '$rootScope'];

function loadingInterceptor($q, $rootScope) {
  var loadingCount = 0;
  return {
    request: function (config) {
      if (++loadingCount === 1) $rootScope.$broadcast('loading:progress');
      return config || $q.when(config);
    },

    response: function (response) {
      if (--loadingCount === 0) $rootScope.$broadcast('loading:finish');
      return response || $q.when(response);
    },

    responseError: function (response) {
      if (--loadingCount === 0) $rootScope.$broadcast('loading:finish');
      return $q.reject(response);
    }
  };
};