(function (angular) {
  "use strict";
  angular.module('appGoPharma')
         .controller('pesquisaController', pesquisaController);

  pesquisaController.$inject = ['$scope', '$rootScope', '$timeout', 'apiService', "$stateParams", '$httpParamSerializer'];

  function pesquisaController($scope, $rootScope, $timeout, apiService, $stateParams, $httpParamSerializer) {
    var vm = $scope;
    var root = $rootScope;

    vm.perguntas = {};
    var indexPesquisa = 0;
    var total = 0;

    vm.fimPesquisa = false;

    vm.loaderData = true;

    vm.answer = [];

    var usuario = apiService.getStorage('usuario');
    var localizacao = apiService.getStorage('locationAddress');

    apiService
      .get('pesquisa-aplicada/id/' + $stateParams.pesquisa)
      .then(function (res) {
        vm.loaderData = false;

        vm.perguntas = res;
        console.log(res);
        total = vm.perguntas.length;

        $timeout(function () {
          var question = vm.perguntas.perguntas[indexPesquisa];
          vm.pesquisa = question;
          vm.answer = question.Alternativas;
        });

      }, function (err) {
        apiService.errorCall(err);
      });

    vm.nextQuestion = function () {
      vm.loaderData = true;
      indexPesquisa++;

      if ((indexPesquisa + 1) >= total) {
        vm.fimPesquisa = true;
        return;
      }

      var question = vm.perguntas.perguntas[indexPesquisa];
      vm.pesquisa = question;
      vm.answer = question.Alternativas;
      vm.loaderData = false;
    };

    vm.salvarQuestion = function (pesquisa) {
      vm.loaderData = true;
      var question = vm.perguntas.perguntas[indexPesquisa];
      question.selected = true;

      var data = {
        "IdPesquisaAplicadaUsuario": pesquisa.IdPesquisaAplicadaUsuario,
        "IdAlternativa": pesquisa.alternativa.IdAlternativa,
      }

      apiService
        .post('pesquisa-aplicada/SalvarUsuarioResposta/', $httpParamSerializer(data), true)
        .then(function (res) {
          indexPesquisa++;

          if ((indexPesquisa + 1) >= total) {
            vm.fimPesquisa = true;
            finalizarPesquisa();
            return;
          }

          $timeout(function () {
            var question = perguntas.perguntas[indexPesquisa];
            vm.pesquisa = question;
            vm.answer = question.Alternativas;
          });

          vm.loaderData = false;
        }, function (err) {
          apiService.errorCall(err);
        })

    };

    var finalizarPesquisa = function () {
      vm.loaderData = true;
      var data = {
        "IdPesquisaAplicada": vm.perguntas.IdPesquisaAplicada,
        "IdUsuario": usuario.idUsuario,
        "IdDispositivo": 0,
        "Declinada": false,
        "Latitude": localizacao.location.lat,
        "Longitude": localizacao.location.long,
      }

      apiService
        .post('pesquisa-aplicada/Salvar/', $httpParamSerializer(data), true)
        .then(function (res) {
          console.log(res);
        }, function (err) {
          apiService.errorCall(err);
        })
    }
  }

})(angular);