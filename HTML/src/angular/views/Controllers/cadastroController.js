(function (angular) {
  "use strict";
  angular.module('appToten')
         .controller('cadastroController', cadastroController);

  cadastroController.$inject = ['$scope', '$rootScope', 'apiService', 'latinizeService'];

  function cadastroController($scope, $rootScope, apiService, latinizeService) {
    var vm = $scope;
    var root = $rootScope;

    vm.dados = {};
    vm.dados.enderecoCerto = true ;
    vm.dados.outro = {} ;

    vm.listaCompras = [].concat.apply([], new Array(20)).map(function (obj, i) {
      return i;
    });

    vm.estados = cidadesEstados.estados.map(function (obj) {
      return {
        "sigla": obj.sigla,
        "nome": obj.nome
      };
    });

    vm.procuraCidades = function (uf) {
      vm.cidades = cidadesEstados.estados.filter(function (obj) {
        return obj.sigla === uf.sigla;
      })[0].cidades.map(function (obj) {
        return {
          "nome": obj,
          "cidade": latinizeService.latinize(obj.toUpperCase())
        };
      });
    };
    vm.consultarCEP = function (cep) {
      vm.loaderData = true;
      cep = cep.replace(/[^0-9]/g, '');

      apiService
        .cep(cep)
        .then(function (res) {
          vm.loaderData = false;
          console.log(res);

          if (res.status == 0) {
            vm.dados.tipoLogradouroConsumidor = res.retorno.tipoLogradouroConsumidor;
            vm.dados.logradouroConsumidor = res.retorno.logradouroConsumidor;
            vm.dados.UF = res.retorno.ufConsumidor;
            vm.dados.Cidade = res.retorno.cidadeConsumidor;
            vm.dados.Bairro = res.retorno.bairroConsumidor;
          } else {
            apiService.customMessage('Não conseguimos achar seu CEP em nossa base de dados, você o digitou certo?');
          }

        }, function (err) {
          vm.loaderData = false;
          apiService.errorCall(err, true);
        })
    };

  }

})
(angular);