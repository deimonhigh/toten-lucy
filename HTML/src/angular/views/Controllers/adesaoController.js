(function (angular) {
  "use strict";
  angular.module('appGoPharma')
         .controller('adesaoController', adesaoController);

  adesaoController.$inject = ['$scope', 'apiService', '$state', '$httpParamSerializer', 'latinizeService'];

  function adesaoController($scope, apiService, $state, $httpParamSerializer, latinizeService) {
    var vm = $scope;

    vm.tabSelected = 0;

    vm.save = false;

    //region Endereço
    vm.estados = cidadesEstados.estados.map(function (obj) {
      return {
        "sigla": obj.sigla,
        "nome": obj.nome
      }
    });

    vm.procuraCidades = function (estado, callback) {
      vm.cidades = cidadesEstados.estados.filter(function (obj) {
        return obj.sigla == (estado ? estado : vm.endereco.estado.sigla);
      })[0].cidades.map(function (obj) {
        return {
          "nome": obj,
          "cidade": latinizeService.latinize(obj.toUpperCase())
        }
      });

      if (typeof callback == "function") {
        callback();
      }
    };
    //endregion

    vm.dados = apiService.getStorage('usuario');

    vm.endereco = {
      "CEP": vm.dados.cep,
      "estado": vm.dados.UF,
      "endereco": vm.dados.TpLogra + vm.dados.Logra + ", " + vm.dados.NrEnder + (vm.dados.ComplEnder ? " - " + vm.dados.ComplEnder : ""),
    };

    if (vm.endereco.estado) {
      vm.procuraCidades(vm.endereco.estado, function () {
        vm.endereco.cidades = {
          "nome": vm.dados.Cid,
          "cidade": latinizeService.latinize(vm.dados.Cid.toUpperCase())
        }
      });
    }

    vm.beneficios = vm.dados;

    vm.loaderData = false;

    vm.logado = apiService.getStorage('usuario').hasOwnProperty('Usuario');

    vm.cadastrar = function (dados) {
      vm.loaderData = true;

      apiService
        .post("usuario/Editar", $httpParamSerializer(dados), true)
        .then(function (res) {
          vm.loaderData = false;

          if (res.status == 0) {
            apiService.setStorage('usuario', dados);
            apiService.customMessage(res.mensagem);
          } else {
            apiService.delStorage('usuario');
            apiService.customMessage(res.mensagem);
          }
        }, function (err) {
          apiService.errorCall(err);
        });
    };

  }

})(angular);