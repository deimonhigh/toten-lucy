angular
  .module("appToten")
  .factory("shareData",
           function () {
             var savedData = {}

             function _set(data) {
               savedData = data;
             }

             function _get() {
               return savedData;
             }

             function _clean() {
               savedData = {};
             }

             return {
               set: _set,
               get: _get,
               clean: _clean
             }
           }
  );