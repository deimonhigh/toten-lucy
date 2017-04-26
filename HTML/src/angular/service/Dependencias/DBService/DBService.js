(function () {
  "use strict";

  angular.module("appGoPharma").service("DBService", DBService);

  DBService.$inject = ['$cordovaSQLite', 'config', '$q', '$window'];

  function DBService($cordovaSQLite, config, $q, $window) {

    // for opening a background db:
    var _db = function () {
      return $window.sqlitePlugin.openDatabase({
                                                 name: config.sBancoNome,
                                                 bgType: 0,
                                                 location: config.dbLocation
                                               });
    };

    var _query = function (query, data) {
      var deferred = $q.defer();

      $cordovaSQLite
        .execute(_db(), query, data)
        .then(function (res) {
          deferred.resolve(res);
        }, function (err) {
          deferred.reject(err);
        });

      return deferred.promise;
    };

    return {
      "query": _query,
      "openDb": _db
    }
  }

})();