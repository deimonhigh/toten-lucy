(function (angular) {
  "use strict";
  angular.module('appGoPharma')
         .controller('homeController', homeController);

  homeController.$inject = ['$scope', '$rootScope', 'apiService', '$stateParams', '$mdSidenav', '$mdComponentRegistry', '$httpParamSerializer', '$timeout', '$mdDialog', 'DBService', '$state'];

  function homeController($scope, $rootScope, apiService, $stateParams, $mdSidenav, $mdComponentRegistry, $httpParamSerializer, $timeout, $mdDialog, DBService, $state) {
    var vm = $scope;
    var root = $rootScope;

    //region Geral
    vm.currentNavItem = !!$stateParams.nav ? $stateParams.nav : 'farmacias';
    vm.enderecoStorage = {};
    vm.gps = false;

    vm.noLocation = false;
    vm.pesquisa = true;
    vm.noResults = false;

    vm.busca = "";

    var usuario = apiService.getStorage('usuario');
    vm.usuarioLogado = usuario.hasOwnProperty('UsuarioNome');

    vm.loadingMore = false;

    vm.queryResult = [];

    vm.filtros = [
      {
        "api": "Atendimento24h",
        "label": "24 horas",
        "selected": false
      },
      {
        "api": "AcessoDeficiente",
        "label": "Acessibilidade",
        "selected": false
      },
      {
        "api": "CartaoAposentado",
        "label": "Cartão Aposentado",
        "selected": false
      },
      {
        "api": "CartaoCredito",
        "label": "Cartão Crédito",
        "selected": false
      },
      {
        "api": "CartaoDebito",
        "label": "Cartão Débito",
        "selected": false
      },
      {
        "api": "CartaoFidelidade",
        "label": "Cartão fidelidade",
        "selected": false
      },
      {
        "api": "ConvenioEmpresa",
        "label": "Convênio para Empresas",
        "selected": false
      },
      {
        "api": "DescontoPlanoSaude",
        "label": "Desconto para Plano de Saúde",
        "selected": false
      },
      {
        "api": "EntregaDomicilio",
        "label": "Entrega em Domicílio",
        "selected": false
      },
      {
        "api": "Estacionamento",
        "label": "Estacionamento",
        "selected": false
      },
      {
        "api": "FarmaciaPopular",
        "label": "Farmácia Popular",
        "selected": false
      },
      {
        "api": "SalaAplicacao",
        "label": "Sala de Aplicação",
        "selected": false
      }
    ];
    vm.endereco = {}

    vm.loaderData = true;

    var params = {
      "Latitude": "",
      "Longitude": "",
      "Raio": "10000",
      "Logradouro": "",
      "NomeFarmacia": "",
      "RegistrosPorPagina": 6,
      "Pagina": 1,
      "TotalRegistros": 0,
      "Origem": "Android",
      "Estacionamento": false,
      "FarmaciaPopular": false,
      "Atendimento24h": false,
      "AcessoDeficiente": false,
      "CartaoAposentado": false,
      "CartaoCredito": false,
      "CartaoDebito": false,
      "CartaoFidelidade": false,
      "ConvenioEmpresa": false,
      "DescontoPlanoSaude": false,
      "EntregaDomicilio": false,
      "ProgramaPaciente": 0,
      "SalaAplicacao": false,
      "ProgramaBeneficiosFiltro": [],
      "idProduto": 0,
      "Selo": 0
    };

    if ($stateParams.beneficio != undefined && $stateParams.beneficio != null) {
      params.ProgramaBeneficiosFiltro.push($stateParams.beneficio);
    } else {
      params.ProgramaBeneficiosFiltro = [];
    }
    //endregion

    //region GPS
    var reverseGeo = function (gpsValue, location) {
      if (typeof location == 'object') {

        vm.enderecoStorage = apiService.getStorage('locationAddress');

        if (
          vm.enderecoStorage.location &&
          vm.enderecoStorage.location.hasOwnProperty('lat') &&
          (vm.enderecoStorage.location.lat == location.lat && vm.enderecoStorage.location.long == location.long)
        ) {
          vm.endereco.formated = vm.enderecoStorage.endereco.formatted_address;
          root.$broadcast('gpsLoaded');
          vm.gps = gpsValue;
        } else {
          apiService.reverseGeocoder(location.lat, location.long).then(function (res) {
            if (res.status == "OK") {
              vm.gps = gpsValue;
              vm.endereco.formated = res.results[0].formatted_address;
              var salvarStorage = {}
              salvarStorage.endereco = res.results[0];
              salvarStorage.location = location;
              vm.enderecoStorage = salvarStorage;

              apiService.setStorage('locationAddress', salvarStorage);
              root.$broadcast('gpsLoaded');
            }
          });
        }
      }
    };

    if (apiService.getStorage('enderecoLocalizacao').hasOwnProperty('location')) {

      var locationAddress = apiService.getStorage('locationAddress');

      apiService
        .geocoder(locationAddress.endereco.formatted_address)
        .then(function (res) {
          locationAddress.location = {};
          locationAddress.location.lat = res.results[0].geometry.location.lat;
          locationAddress.location.long = res.results[0].geometry.location.lng;
          apiService.setStorage('locationAddress', locationAddress);

          reverseGeo(false, locationAddress.location);
        });
    }
    else {
      var location = {};
      apiService
        .userLocation()
        .then(
          function (res) {
            location = res;
            apiService.setStorage('locationGeo', res);

            reverseGeo(true, location);
          },
          function (err) {
            if (err.code == 1) {
              $mdDialog.confirm()
                       .title('Ops!')
                       .textContent('Parece que você não liberou acesso a sua localização, então teremos problemas em achar você.')
                       .ariaLabel('Confirmar erro GPS')
                       .ok('Ok');
            }

            if (err.code == 2 || err.code == 3) {
              $mdDialog.confirm()
                       .title('Ops!')
                       .textContent('Não conseguimos encontrar a sua localização, seu GPS está ligado?.')
                       .ariaLabel('Erro sinal de GPS não encontrado')
                       .ok('Ok');
            }
            vm.noLocation = true;
            root.$broadcast('gpsLoaded');
          }
        );
    }

    vm.$on('gpsLoaded', function () {
      root.$broadcast(vm.currentNavItem);

      //region Farmacias
      if ($stateParams.nav == 'farmacias') {
        vm.loaderData = false;
        vm.infiniteItemsFarmacias = {
          numLoaded_: 0,
          toLoad_: 0,
          items: [],
          totalPaginas: 0,
          verificacao: 0,
          ok: true,

          getItemAtIndex: function (index) {
            if (index > this.numLoaded_) {
              this.fetchMoreItems_(index);
              return null;
            }

            return this.items[index];
          },

          getLength: function () {
            return this.numLoaded_ + 6;
          },

          fetchMoreItems_: function (index) {
            vm.loadingMore = true;
            if (this.toLoad_ < index && this.ok) {
              this.toLoad_ += 5;
              var infosGeo = vm.enderecoStorage;

              params.Latitude = infosGeo.location.lat;
              params.Longitude = infosGeo.location.long;
              params.Logradouro = infosGeo.endereco.formatted_address;

              params.Pagina = Math.ceil(this.numLoaded_ / 6);

              var programas = apiService.getStorage('programasBeneficioFiltro');
              if (programas.hasOwnProperty('beneficios')) {
                params.ProgramaBeneficiosFiltro = programas.beneficios.join(',');
                apiService.delStorage('programasBeneficioFiltro');
              }

              vm.loaderData = true;

              apiService
                .post('pontos-de-venda/AdquirirFarmaciasProximas', $httpParamSerializer(params), true)
                .then(
                  angular.bind(this, function (obj) {
                    if (obj.length == 0) {
                      $timeout(function () {
                        vm.loaderData = false;
                        vm.loadingMore = false;
                      })
                      return;
                    }
                    if (this.verificacao == 0) {
                      this.totalPaginas = obj[0].totalPaginas;
                      this.verificacao++;
                    }

                    this.ok = Math.ceil(this.numLoaded_ / 6) <= this.totalPaginas;

                    $timeout(function () {
                      vm.loaderData = false;
                      vm.loadingMore = false;
                    });
                    this.items = this.items.concat(obj);
                    this.numLoaded_ = this.toLoad_;

                  }), function (err) {
                    apiService.errorCall(err);
                  });
            } else {
              vm.loadingMore = false;
            }
          }
        };
      }
      //endregion

      //region Beneficios
      if ($stateParams.nav == 'beneficios') {
        apiService.delStorage('programasBeneficioFiltro');

        DBService
          .query("SELECT COUNT(1) FROM etProgramaBeneficios")
          .then(function (data, tx) {
            var total = data.rows.item(1);

            DBService
              .query("SELECT * FROM etProgramaBeneficios WHERE programaBeneficiosAtivo = 1")
              .then(function (data, tx) {

                var items = [];

                for (var i = 0; i < data.rows.length; i++) {
                  var obj = data.rows.item(i);
                  items.push(obj);
                }

                items = items.map(function (obj) {
                  obj.imgs = 'url("assets/images/programas/' + obj.programaBeneficiosLogomarca + '")';
                  return obj;
                })

                vm.loaderData = false;

                vm.onDemand = true;
                vm.dataset = {
                  _items: [],
                  _refresh: function (data) {
                    this._items = data.filter(function (el) {
                      return !angular.isDefined(el._excluded) || el._excluded === false;
                    })
                  },
                  getItemAtIndex: function (index) {
                    return this._items[index];
                  }, //getItemAtIndex
                  getLength: function () {
                    return this._items.length
                  } //getLenth
                }; //dataset

                vm.dataset._refresh(items);
              }, function (err) {
                apiService.errorCall(err);
              });

          }, function (err) {
            apiService.errorCall(err);
          });

        vm.procurarFarmacias = function (item) {
          var obj = {
            "beneficios": [item.idProgramaBeneficios]
          }
          apiService.setStorage("programasBeneficioFiltro", obj);

          $state.go('farmacias');
        }

        vm.procurarProgramas = function (search) {
          vm.loaderData = true;
          var query;
          if (search) {
            vm.noResults = false;
            query = "SELECT * FROM etProgramaBeneficios WHERE programaBeneficiosNome LIKE '%" + search + "%'";
          } else {
            query = "SELECT * FROM etProgramaBeneficios"
          }

          DBService
            .query(query, [])
            .then(function (data) {

              if (data.rows.length == 0) {
                vm.noResults = true;
                vm.loaderData = false;
                return;
              }

              var items = [];

              for (var i = 0; i < data.rows.length; i++) {
                var obj = data.rows.item(i);
                items.push(obj);
              }

              items = items.map(function (obj) {
                obj.imgs = 'url("assets/images/programas/' + obj.programaBeneficiosLogomarca + '")';
                return obj;
              });

              vm.loaderData = false;

              vm.dataset._refresh(items);
            }, function (err) {
              apiService.errorCall(err);
            });
        }
      }
      //endregion

      //region Produtos
      if ($stateParams.nav == 'produtos') {
        apiService.delStorage('programasBeneficioFiltro');
        vm.loaderData = false;

        vm.queryResult = [];

        vm.searchTextChange = function (search) {
          vm.pesqusia = false;
          vm.loaderData = true;
          if (search && search.length > 3) {
            var query = "SELECT * FROM etProduto WHERE produtoNome LIKE '%" + search + "%'";

            DBService.query(query, []).then(function (data) {
              var temp = []
              for (var i = 0; i < data.rows.length; i++) {
                var obj = data.rows.item(i);
                temp.push(obj);
              }

              if (temp.lenth == 0) {
                vm.pesquisa = true;
                vm.loaderData = false;
              } else {
                $timeout(function () {
                  vm.loaderData = false;

                  $timeout(function () {
                    vm.queryResult = temp;
                  });
                });
              }

            }, function (err) {
              apiService.errorCall(err);
            });
          } else {
            params.idProduto = 0;
            vm.pesqusia = false;
          }
        };

        vm.infiniteItemsProdutos = {
          numLoaded_: 0,
          toLoad_: 0,
          items: [],
          totalPaginas: 0,
          verificacao: 0,
          ok: true,

          getItemAtIndex: function (index) {
            if (index > this.numLoaded_) {
              this.fetchMoreItems_(index);
              return null;
            }

            return this.items[index];
          },
          getLength: function () {
            return this.numLoaded_ + 6;
          },

          fetchMoreItems_: function (index) {
            vm.loadingMore = true;
            if (this.toLoad_ < index && params.idProduto != 0) {
              this.toLoad_ += 5;
              var infosGeo = vm.enderecoStorage;

              params.Latitude = infosGeo.location.lat;
              params.Longitude = infosGeo.location.long;
              params.Logradouro = infosGeo.endereco.formatted_address;

              params.Pagina = Math.ceil(this.numLoaded_ / 6) + 1;

              vm.loaderData = true;
              vm.pesquisa = false;

              apiService
                .post('pontos-de-venda/AdquirirFarmaciasProximas', $httpParamSerializer(params), true)
                .then(
                  angular.bind(this, function (obj) {
                    if (obj && obj.length == 0) {
                      $timeout(function () {
                        vm.loaderData = false;
                        vm.loadingMore = false;
                        vm.pesquisa = true;
                        vm.noResults = true;
                      });
                      return;
                    }

                    $timeout(function () {
                      vm.loaderData = false;
                      vm.loadingMore = false;
                      vm.pesquisa = false;
                      vm.noResults = false;
                    });

                    obj = obj.map(function (objeto) {
                      objeto.imgs = 'url("assets/images/busca/' + (parseInt(objeto.selo) == 0 ? 'selo-cinza.png' : 'selo-amarelo.png') + '")';
                      return objeto;
                    })

                    if (vm.infiniteItemsProdutos.verificacao == 0) {
                      vm.infiniteItemsProdutos.totalPaginas = obj[0].totalPaginas;
                      vm.infiniteItemsProdutos.verificacao++;
                    }

                    vm.infiniteItemsProdutos.ok = Math.ceil(vm.infiniteItemsProdutos.numLoaded_ / 6) <= vm.infiniteItemsProdutos.totalPaginas;

                    $timeout(function () {
                      vm.infiniteItemsProdutos.items = vm.infiniteItemsProdutos.items.concat(obj);
                      vm.infiniteItemsProdutos.numLoaded_ = vm.infiniteItemsProdutos.toLoad_;
                    });

                  }), function (err) {
                    apiService.errorCall(err);
                  });
            } else {
              vm.loadingMore = false;
            }
          }
        };

        vm.selectedItemChange = function (item) {
          if (item != undefined) {
            params.idProduto = item.idProduto;

            $timeout(function () {
              vm.pesquisa = false;
            });

            vm.infiniteItemsProdutos.numLoaded_ = 0;
            vm.infiniteItemsProdutos.toLoad_ = 0;
            vm.infiniteItemsProdutos.items = [];
            vm.infiniteItemsProdutos.totalPaginas = 0;
            vm.infiniteItemsProdutos.verificacao = 0;

            vm.infiniteItemsProdutos.getItemAtIndex(1);
          }
        }
      }
      //endregion
    });
    //endregion

    //region Utils
    vm.selFarmacia = function (farmacia) {
      apiService.setStorage('farmaciaEscolhida', farmacia);
    };
    //endregion

    //region Filtro Lateral
    vm.toggleRight = function () {
      $mdSidenav('filter').toggle();
    };

    vm.close = function () {
      $mdSidenav('filter').close();
    };

    $mdComponentRegistry.when('filter').then(function () {
      $mdSidenav('filter').onClose(function () {
        alterFilter();
      });
    });

    var alterFilter = function () {
      vm.filtros.map(function (obj) {
        params[obj.api] = obj.selected;
      });

      if (vm.infiniteItemsFarmacias) {
        vm.infiniteItemsFarmacias.items = []
        vm.infiniteItemsFarmacias.numLoaded_ = 0;
        vm.infiniteItemsFarmacias.toLoad_ = 0;
        vm.infiniteItemsFarmacias.totalPaginas = 0;
        vm.infiniteItemsFarmacias.verificacao = 0;
      }

      if (vm.infiniteItemsProdutos) {
        vm.infiniteItemsProdutos.numLoaded_ = 0;
        vm.infiniteItemsProdutos.toLoad_ = 0;
        vm.infiniteItemsProdutos.items = [];
        vm.infiniteItemsProdutos.totalPaginas = 0;
        vm.infiniteItemsProdutos.verificacao = 0;
      }

    };

    vm.buscaFarmacias = function (busca) {
      vm.filtros.map(function (obj) {
        params[obj.api] = obj.selected;
      });

      params.NomeFarmacia = busca;

      if (vm.infiniteItemsFarmacias) {
        vm.infiniteItemsFarmacias.items = []
        vm.infiniteItemsFarmacias.numLoaded_ = 0;
        vm.infiniteItemsFarmacias.toLoad_ = 0;
        vm.infiniteItemsFarmacias.totalPaginas = 0;
        vm.infiniteItemsFarmacias.verificacao = 0;
      }

      if (vm.infiniteItemsProdutos) {
        vm.infiniteItemsProdutos.numLoaded_ = 0;
        vm.infiniteItemsProdutos.toLoad_ = 0;
        vm.infiniteItemsProdutos.items = [];
        vm.infiniteItemsProdutos.totalPaginas = 0;
        vm.infiniteItemsProdutos.verificacao = 0;
      }

    };
    //endregion

  }

})
(angular);