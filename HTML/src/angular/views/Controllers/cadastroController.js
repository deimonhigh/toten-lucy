(function (angular) {
  "use strict";
  angular.module('appGoPharma')
         .controller('cadastroController', cadastroController);

  cadastroController.$inject = ['$scope', 'apiService', '$state', '$httpParamSerializer'];

  function cadastroController($scope, apiService, $state, $httpParamSerializer) {
    var vm = $scope;

    vm.dados = {};

    var usuario = {
      "isUsuario": null,
      "Username": null,
      "Senha": null,
      "Perfil": null,
      "Email": null,
      "Telefone": null,
      "CPF": null,
      "idDispositivo": null,
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

    var facebook = apiService.getStorage('dadosFacebook');

    if (facebook.hasOwnProperty('name')) {
      vm.dados.Username = facebook.name;
    }

    if (facebook.hasOwnProperty('email')) {
      vm.dados.Email = facebook.email;
    }

    if (facebook.hasOwnProperty('id')) {
      vm.dados.FacebookID = facebook.id;
      vm.dados.Facebook = true;
    }

    vm.loaderData = false;

    var user = apiService.getStorage('usuario');
    vm.logado = user.hasOwnProperty('usename');

    if (vm.logado) {
      $state.go('me');
    }
    
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
          console.log(res);
          vm.loaderData = false;

          if (res.status == 0) {
            apiService.setStorage('usuario', res.retorno);
            apiService.customMessage(res.mensagem);
            apiService.delStorage('dadosFacebook')
            $state.go('me');
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