(function (angular) {
  "use strict";
  angular.module('appToten')
         .controller('fotoController', fotoController);

  fotoController.$inject = ['$scope', '$rootScope', 'apiService'];

  function fotoController($scope, $rootScope, apiService) {
    var vm = $scope;
    var root = $rootScope;

    vm.hideButtonComprovante = false;

    var _video = null;

    vm.bandeiras = [
      {
        "id": 0,
        "descricao": "Selecione a bandeira"
      },
      {
        "id": "visa",
        "descricao": "Visa"
      },
      {
        "id": "master",
        "descricao": "MasterCard"
      },
      {
        "id": "hyper",
        "descricao": "HyperCard"
      },
      {
        "id": "dinners",
        "descricao": "Dinners"
      },
    ];

    var comprovanteBase = {
      "bandeira": vm.bandeiras[0],
      "codigo": null
    };

    vm.comprovantes = [
      angular.copy(comprovanteBase)
    ];

    vm.removeItem = function (item) {
      vm.comprovantes = vm.comprovantes.filter(function (obj) {
        return obj.$$hashKey != item.$$hashKey;
      });
      vm.hideButtonComprovante = vm.comprovantes.length > 4;
    };

    vm.addComprovante = function () {
      if (vm.comprovantes.length < 5) {
        vm.comprovantes.push(angular.copy(comprovanteBase));
      }
      vm.hideButtonComprovante = vm.comprovantes.length > 4;
    };

    vm.closeModal = function () {
      root.$broadcast('confirmarImg');
      root.foto = false;
      vm.confirmFoto = false;
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
      w: 600,
      h: 540
    };

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
        apiService.setStorage('comprovante', vm.imgResponse);
      }
    };

    var getVideoData = function getVideoData(x, y, w, h) {
      var hiddenCanvas = document.createElement('canvas');

      hiddenCanvas.width = _video.width;
      hiddenCanvas.height = _video.height;
      var ctx = hiddenCanvas.getContext('2d');
      ctx.drawImage(_video, 0, 0, _video.width, _video.height);
      return ctx.getImageData(x, y, w, h);
    };
  }

})
(angular);