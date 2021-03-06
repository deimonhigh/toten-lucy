(function (angular) {
  "use strict";
  angular.module('appToten')
         .controller('cadastroController', cadastroController);

  cadastroController.$inject = ['$scope', '$rootScope', 'apiService', 'latinizeService', '$filter', '$state'];

  function cadastroController($scope, $rootScope, apiService, latinizeService, $filter, $state) {
    var vm = $scope;
    var root = $rootScope;

    var enviarParaSalvar = {
      "id": null,
      "documento": null,
      "nome": null,
      "telefone": null,
      "celular": null,
      "enderecos": [],
    };

    vm.dados = {};
    vm.dados.enderecoCerto = true;
    vm.dados.sexo = "M";
    vm.dados.outro = {};

    vm.estados = cidadesEstados.estados.map(function (obj) {
      return {
        "sigla": obj.sigla,
        "nome": obj.nome
      };
    });

    //region Procura Cidades
    vm.$watch(function ($scope) {
      return $scope.dados.uf;
    }, function (nVal) {
      if (nVal) {
        vm.procuraCidades(nVal);
      }
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

      root.$broadcast('cidadeLoaded');
    };

    vm.$watch(function ($scope) {
      return $scope.dados.outro.uf;
    }, function (nVal) {
      if (nVal) {
        vm.procuraCidadesOutro(nVal);
      }
    });

    vm.procuraCidadesOutro = function (uf) {
      vm.cidadesOutro = cidadesEstados.estados.filter(function (obj) {
        return obj.sigla === uf.sigla;
      })[0].cidades.map(function (obj) {
        return {
          "nome": obj,
          "cidade": latinizeService.latinize(obj.toUpperCase())
        };
      });

      root.$broadcast('cidadeLoadedOutro');
    };
    //endregion

    //region Carregar Cidades
    vm.$on('cidadeLoaded', function () {
      if (vm.dados.cidadeTemp) {
        var temp = $filter('filter')(vm.cidades, {'cidade': latinizeService.latinize(vm.dados.cidadeTemp).toUpperCase()}, true);
        vm.dados.cidade = temp && temp[0] ? temp[0] : {};
        delete vm.dados.cidadeTemp;
      }
    });

    vm.$on('cidadeLoadedOutro', function () {
      if (vm.dados.outro.cidadeTempOutro) {
        var tempOutro = $filter('filter')(vm.cidadesOutro, {'cidade': latinizeService.latinize(vm.dados.outro.cidadeTempOutro).toUpperCase()}, true);
        vm.dados.outro.cidade = tempOutro && tempOutro[0] ? tempOutro[0] : {};
        delete vm.dados.outro.cidadeTempOutro;
      }
    });
    //endregion

    //region Cliente
    vm.procurarCliente = function (cpf) {
      if (!cpf || cpf.length < 11) {
        return;
      }

      apiService
        .search('clientes', cpf)
        .then(function (res) {
          vm.dados.documento = res.result.documento;
          vm.dados.nome = res.result.nome;
          vm.dados.telefone = res.result.telefone;
          vm.dados.celular = res.result.celular;
          vm.dados.id = res.result.id;
          vm.dados.sexo = res.result.sexo;
          vm.dados.email = res.result.email;

          if (res.result.enderecos.length == 1) {
            vm.dados.enderecoCerto = true;
            vm.dados.cep = res.result.enderecos[0].cep;
            vm.dados.numero = res.result.enderecos[0].numero;
            vm.dados.endereco = res.result.enderecos[0].endereco;
            vm.dados.bairro = res.result.enderecos[0].bairro;
            vm.dados.uf = $filter('filter')(vm.estados, {'sigla': res.result.enderecos[0].uf.toUpperCase()}, true)[0];
            vm.dados.cidadeTemp = res.result.enderecos[0].cidade;
          } else {
            vm.dados.enderecoCerto = false;
            res.result.enderecos.map(function (obj) {
              if (obj.enderecooriginal == 1) {
                vm.dados.outro.cep = obj.cep;
                vm.dados.outro.numero = obj.numero;
                vm.dados.outro.endereco = obj.endereco;
                vm.dados.outro.bairro = obj.bairro;
                vm.dados.outro.uf = $filter('filter')(vm.estados, {'sigla': obj.uf.toUpperCase()}, true)[0];
                vm.dados.outro.cidadeTempOutro = obj.cidade;
              } else {
                vm.dados.cep = obj.cep;
                vm.dados.numero = obj.numero;
                vm.dados.endereco = obj.endereco;
                vm.dados.bairro = obj.bairro;
                vm.dados.uf = $filter('filter')(vm.estados, {'sigla': obj.uf.toUpperCase()}, true)[0];
                vm.dados.cidadeTemp = obj.cidade;
              }
            });
          }

        }, function (err) {
//          console.log(err);
        });
    };

    vm.salvarDados = function () {
      var enviar = angular.copy(vm.dados);
      enviarParaSalvar.enderecos = [];

      enviarParaSalvar.id = enviar.id;
      enviarParaSalvar.documento = enviar.documento;
      enviarParaSalvar.nome = enviar.nome;
      enviarParaSalvar.telefone = enviar.telefone;
      enviarParaSalvar.celular = enviar.celular;
      enviarParaSalvar.email = enviar.email;
      enviarParaSalvar.sexo = enviar.sexo;

      var endereco1 = {
        "cep": enviar.cep,
        "endereco": enviar.endereco,
        "numero": enviar.numero,
        "bairro": enviar.bairro,
        "uf": enviar.uf.sigla,
        "cidade": enviar.cidade.nome,
        "enderecoOriginal": enviar.enderecoCerto
      };
      enviarParaSalvar.enderecos.push(endereco1);

      if (!enviar.enderecoCerto) {
        var endereco2 = {
          "cep": enviar.outro.cep,
          "endereco": enviar.outro.endereco,
          "numero": enviar.outro.numero,
          "bairro": enviar.outro.bairro,
          "uf": enviar.outro.uf.sigla,
          "cidade": enviar.outro.cidade.nome,
          "enderecoOriginal": !enviar.enderecoCerto
        };
        enviarParaSalvar.enderecos.push(endereco2);
      }

      enviarParaSalvar.peso = apiService.getStorage('carrinho').reduce(function (carry, next) {
        return carry + parseFloat(next.peso);
      }, 0);

      apiService.post('clientes/save', enviarParaSalvar).then(function (res) {
        apiService.setStorage('cliente', res.result);
        if (root.temaStorage.mercado_pago) {
          $state.go('pagamentoMP');
        } else {
          $state.go('pagamento');
        }
      }, function (err) {
        alert('Ocorreu um erro ao salvar os dados do Cliente.')
      })
    };
    //endregion

    //region Limpar Endereços
    var limpaEndereco = function () {
      vm.dados.endereco = "";
      vm.dados.bairro = "";
      vm.dados.uf = "";
      delete vm.dados.cidadeTemp;
    };

    var limpaOutroEndereco = function () {
      vm.dados.outro.endereco = "";
      vm.dados.outro.bairro = "";
      vm.dados.outro.uf = "";
      delete vm.dados.outro.cidadeTempOutro;
    };
    //endregion

    //region Procurar CEP's
    vm.procuraCep = function (cep) {
      apiService.cep(cep).then(function (res) {
        limpaEndereco();
        vm.dados.endereco = res.logradouro;
        vm.dados.bairro = res.bairro;
        vm.dados.uf = $filter('filter')(vm.estados, {'sigla': res.uf}, true)[0];
        vm.dados.cidadeTemp = res.localidade;
      });
    };

    vm.procuraOutroCep = function (cep) {
      apiService.cep(cep).then(function (res) {
        limpaOutroEndereco();
        vm.dados.outro.endereco = res.logradouro;
        vm.dados.outro.bairro = res.bairro;
        vm.dados.outro.uf = $filter('filter')(vm.estados, {'sigla': res.uf}, true)[0];
        vm.dados.outro.cidadeTempOutro = res.localidade;
      });
    };
    //endregion
  }
})
(angular);