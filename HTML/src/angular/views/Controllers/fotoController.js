(function (angular) {
  "use strict";
  angular.module('appToten')
         .controller('fotoController', fotoController);

  fotoController.$inject = ['$scope', '$rootScope'];

  function fotoController($scope, $rootScope) {
    var vm = $scope;
    var root = $rootScope;

    var _video = null;

    vm.closeModal = function () {
      root.foto = false;
    };

    vm.okFoto = function () {
      vm.confirmFoto = true;
    };

    vm.notOkFoto = function () {
      vm.confirmFoto = false;
    };

    vm.patOpts = {
      x: 0,
      y: 0,
      w: 400,
      h: 400
    };

    // Setup a channel to receive a video property
    // with a reference to the video element
    // See the HTML binding in main.html
    vm.channel = {};

    vm.onError = function (err) {
      console.log(err);
    };

    vm.onSuccess = function () {
      _video = vm.channel.video;
      vm.$apply(function () {
        vm.patOpts.w = _video.width;
        vm.patOpts.h = _video.height;
      });
    };

    vm.makeSnapshot = function () {
      if (_video) {
        var patCanvas = document.querySelector('#snapshot');
        if (!patCanvas) return;
        var ctxPat = patCanvas.getContext('2d');

        var idata = getVideoData(vm.patOpts.x, vm.patOpts.y, vm.patOpts.w, vm.patOpts.h);
        ctxPat.putImageData(idata, 0, 0);

        vm.confirmFoto = true;

        vm.imgResponse = patCanvas.toDataURL();

      }
    };

    var getVideoData = function getVideoData(x, y, w, h) {
      var hiddenCanvas = document.createElement('canvas');

      console.log(_video.height);

      hiddenCanvas.width = _video.width;
      hiddenCanvas.height = _video.height;
      var ctx = hiddenCanvas.getContext('2d');
      ctx.drawImage(_video, 0, 0, _video.width, _video.height);
      return ctx.getImageData(x, y, w, h);
    };
  }

})
(angular);