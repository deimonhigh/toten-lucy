(function (angular) {
  "use strict";
  angular.module('appGoPharma')
         .controller('perfilController', perfilController);

  perfilController.$inject = ['$scope', 'apiService', '$state', '$httpParamSerializer', '$cordovaDevice', 'latinizeService'];

  function perfilController($scope, apiService, $state, $httpParamSerializer, $cordovaDevice, latinizeService) {
    var vm = $scope;

    var device = $cordovaDevice.getUUID();

    vm.save = false;

    vm.dados = {};

    var usuario = {
      "isUsuario": null,
      "Username": null,
      "Senha": null,
      "Perfil": null,
      "Email": null,
      "Telefone": null,
      "CPF": null,
      "idDispositivo": device,
      "RecebeEmail": null,
      "Facebook": null,
      "FacebookID": null,
      "DataNascimento": null,
      "Sexo": null,
      "CEP": null,
      "UF": null,
      "Cidade": null,
      "Bairro": null,
      "TipoLogradouro": null,
      "Logradouro": null,
      "NrEnder": null,
      "ComplEnder": null,
      "DDDCelular": null,
      "FoneCelular": null,
      "DDDFixo": null,
      "FoneFixo": null,
    };

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

    var dadosStorage = apiService.getStorage('usuario');

    vm.dados.Username = dadosStorage.usename;
    vm.dados.Email = dadosStorage.email;
    vm.dados.CPF = dadosStorage.cpf;
    vm.dados.Telefone = dadosStorage.dddCelular + dadosStorage.foneCelular;
    vm.dados.ReceberEmail = dadosStorage.recebeEmail;

    if (dadosStorage.hasOwnProperty('usename')) {
      vm.endereco = {
        "CEP": dadosStorage.cep,
        "estado": dadosStorage.uf,
        "endereco": dadosStorage.tipoLogradouro + dadosStorage.logradouro + ", " + dadosStorage.nrEnder + (dadosStorage.complEnder ? " - " + dadosStorage.complEnder : ""),
        "bairro": dadosStorage.bairro
      };

      if (vm.endereco.estado) {
        vm.procuraCidades(vm.endereco.estado, function () {
          vm.endereco.cidades = {
            "nome": dadosStorage.cidade,
            "cidade": latinizeService.latinize(dadosStorage.cidade.toUpperCase())
          }
        });
      }

      var dataNascimento = $filter('date')(dadosStorage.dataNascimento, 'YYYY-MM-dd');

      apiService
        .get("usuario/CPFConsumidor/" + dadosStorage.CPF + "/DataNascConsumidor/" + dataNascimento + "/GetUsuarioAdesoes")
        .then(function (res) {
          console.log(res);
          vm.beneficios = res;

        }, function (err) {
          apiService.errorCall(err);
        })
    }

    vm.loaderData = false;

    vm.logado = apiService.getStorage('usuario').hasOwnProperty('usename');

    vm.cadastrar = function (dados) {
      vm.loaderData = true;

      var user = angular.copy(usuario);
      user.idUsuario = dados.idUsuario;
      user.Perfil = dados.Perfil;
      user.DataNascimento = dados.DataNascimento;

      var telefoneNumero = dados.Telefone.replace(/[^0-9]/g, '');

      user.DDDCelular = telefoneNumero.substring(0, 2);
      user.FoneCelular = telefoneNumero.substring(2);

      user.Sexo = dados.Sexo;
      user.Senha = dados.Senha;
      user.Facebook = dados.Facebook ? dados.Facebook : false;
      user.FacebookID = dados.FacebookID ? dados.FacebookID : null;
      user.CPF = dados.CPF.replace(/[^0-9]/g, "");

      apiService
        .post("usuario/Adicionar", $httpParamSerializer(dados), true)
        .then(function (res) {
          vm.loaderData = false;

          if (res.status == 0) {
            apiService.setStorage('usuario', res.retorno);
            apiService.customMessage(res.mensagem).then(function () {
              $state.go('me');
            });
          } else {
            apiService.delStorage('usuario');
            apiService.customMessage(res.mensagem);
          }
        }, function (err) {
          apiService.errorCall(err, true);
        });
    };

    vm.cadastrarEndereco = function (dados) {
      vm.loaderData = true;

      apiService
        .post("usuario/endereco/Editar", $httpParamSerializer(dados), true)
        .then(function (res) {
          console.log(res);
          vm.loaderData = false;

          if (res.status == 0) {
            apiService.setStorage('usuario', res.retorno);
            apiService.customMessage(res.mensagem);
          } else {
            apiService.delStorage('usuario');
            apiService.customMessage(res.mensagem);
          }
        }, function (err) {
          apiService.errorCall(err);
        });
    };

    vm.sair = function () {
      apiService.delStorage('usuario');
      $state.go('me');
    };

    vm.salvar = function () {
      vm.cadastrar(vm.dados);
    };

    vm.alterarSenha = function (dados) {
      vm.loaderData = true;

      var dados = {
        Senha: dados.senha,
        NovaSenha: dados.novaSenha
      }

      var usuario = apiService.getStorage('usuario');

      apiService
        .get("usuario/email/" + usuario.Email + "/Senha/" + dados.Senha + "/NovaSenha/" + dados.novaSenha + "/AlterarSenha", $httpParamSerializer(dados), true)
        .then(function (res) {
          $state.go('meInterna');

        }, function (err) {
          apiService.errorCall(err);
        });
    };

    vm.consultarCEP = function (cep) {
      vm.loaderData = true;
      cep = cep.replace(/[^0-9]/g, '');

      apiService
        .get("usuario/cep/" + cep + "/adm/39/GetEndereco")
        .then(function (res) {
          vm.loaderData = false;
          console.log(res);

          usuario.tipoLogradouroConsumidor = res.tipoLogradouroConsumidor;
          usuario.logradouroConsumidor = res.logradouroConsumidor;
          usuario.UF = res.ufConsumidor;
          usuario.Cidade = res.cidadeConsumidor;
        }, function (err) {
          apiService.errorCall(err, true);
        })
    }

    vm.$on('inputModified.formChanged', function () {
      vm.save = true;
    });
  }

})(angular);