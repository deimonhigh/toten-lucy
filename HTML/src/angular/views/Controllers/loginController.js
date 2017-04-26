(function (angular) {
  "use strict";
  angular.module('appGoPharma')
         .controller('loginController', loginController);

  loginController.$inject = ['$scope', 'apiService', '$state', '$httpParamSerializer', '$cordovaDevice'];

  function loginController($scope, apiService, $state, $httpParamSerializer, $cordovaDevice) {
    var vm = $scope;

    vm.dados = {};

    vm.platform = $cordovaDevice.getPlatform();

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

    vm.logado = apiService.getStorage('usuario').hasOwnProperty('usename');

    vm.listagemMenu = [
      {
        "aria": "Perfil e configurações",
        "url": "meInterna",
        "interna": true
      },
      {
        "aria": "Meus benefícios",
        "url": "meusBeneficios",
        "interna": true
      },
      {
        "aria": "Compartilhe",
        "url": "pesquisas",
        "interna": true
      },
      {
        "aria": "Fale Conosco",
        "url": "mailto:contato@gopharma.com.br",
        "interna": false
      }
    ];

    if (vm.platform.toLowerCase().indexOf('ios') > -1) {
      vm.listagemMenu.push({
                             "aria": "Avalie-nos na AppStore",
                             "url": "itms-apps://itunes.apple.com/app/com.interplayers.GoPharma",
                             "interna": false
                           });
    } else {
      vm.listagemMenu.push({
                             "aria": "Avalie-nos na Google Play",
                             "url": "market://details?id=com.interplayers.GoPharma",
                             "interna": false
                           });
    }

    vm.loginEmail = function (dados) {
      vm.loaderData = true;
      apiService
        .get("usuario/email/" + dados.email + "/senha/" + dados.senha + "/Validar")
        .then(function (res) {
          console.log(res);
          vm.loaderData = false;

          if (res.status == 0) {
            apiService.setStorage('usuario', res.retorno);
            apiService.customMessage(res.mensagem, "Sucesso");
            $state.go('me');
          } else {
            apiService.delStorage('usuario');
            apiService.customMessage(res.mensagem);
          }
        }, function (err) {
          apiService.errorCall(err);
        });
    };

    vm.loginFacebook = function () {
      apiService.setStorage('urlVoltar', {
        "url": "me"
      });

      $cordovaFacebook.getLoginStatus()
                      .then(function (success) {
                        console.log(success);

                        if (success.status == "unknown") {
                          $cordovaFacebook.login(["public_profile", "email"])
                                          .then(function () {
                                            $cordovaFacebook.api("me?fields=id,email,name,first_name,last_name,picture", ["public_profile", "email"])
                                                            .then(function (success) {
                                                              apiService.setStorage('dadosFacebook', success);

                                                              var dados = {
                                                                "Email": success.email,
                                                                "FacebookID": success.id,
                                                                "Facebook": true
                                                              }

                                                              consultarUsuario(dados, function (retorno, res) {
                                                                if (retorno) {
                                                                  $state.reload();
                                                                } else {
                                                                  $state.go('cadastrar');
                                                                }
                                                              })

                                                            }, function (error) {
                                                              apiService.errorCall(error, "Houve um erro na comunicação com o facebook. Você gostaria de tentar novamente?");
                                                            });
                                          }, function (error) {
                                            apiService.errorCall(error, "Houve um erro na comunicação com o facebook. Você gostaria de tentar novamente?");
                                          });
                        } else {
                          $cordovaFacebook.getAccessToken()
                                          .then(function () {
                                            $cordovaFacebook.api("me?fields=id,email,name,first_name,last_name,picture", ["public_profile", "email"])
                                                            .then(function (success) {
                                                              apiService.setStorage('dadosFacebook', success);
                                                              $state.go('cadastrar');
                                                            }, function (error) {
                                                              apiService.errorCall(error, "Houve um erro na comunicação com o facebook. Você gostaria de tentar novamente?");
                                                            });

                                          }, function (error) {
                                            apiService.errorCall(error, "Houve um erro na comunicação com o facebook. Você gostaria de tentar novamente?");
                                          });

                        }

                      }, function (error) {
                        apiService.errorCall(error, "Houve um erro na comunicação com o facebook. Você gostaria de tentar novamente?");
                        $cordovaFacebook.login(["public_profile", "email"])
                                        .then(function () {
                                          $cordovaFacebook.api("me?fields=id,email,name,first_name,last_name,picture", ["public_profile", "email"])
                                                          .then(function (success) {
                                                            console.log(success);
                                                          }, function (error) {
                                                            apiService.errorCall(error, "Houve um erro na comunicação com o facebook. Você gostaria de tentar novamente?");
                                                          });

                                        }, function (error) {
                                          apiService.errorCall(error, "Houve um erro na comunicação com o facebook. Você gostaria de tentar novamente?");
                                        });
                      });

    };
    var consultarUsuario = function (data, callback) {
      apiService
        .post("usuario/Adicionar", $httpParamSerializer(dados), true)
        .then(function (res) {
          callback(true, res);
          console.log(res);
        }, function (err) {
          callback(false, res);
          console.log(err);
        })
    }

    vm.loginTelefoneValido = function (dados) {
      console.log(dados);
      //apiService.post()
    };
  }

})(angular);