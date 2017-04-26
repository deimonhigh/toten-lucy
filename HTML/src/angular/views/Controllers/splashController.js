(function (angular) {
  "use strict";
  angular.module('appGoPharma')
         .controller('splashController', splashController);

  splashController.$inject = ['$scope', '$state', 'DBService', 'config', 'apiService', '$filter', '$mdDialog'];

  function splashController($scope, $state, DBService, config, apiService, $filter, $mdDialog) {
    var vm = $scope;
    vm.valueLoading = 0;
    vm.loadingInfoArray = ['Olá, estamos carregando', 'Ajustando a pesquisa', 'Preparando o ambiente', 'Mexendo em configurações', 'Melhorando o ambiente para você'];
    vm.loadingInfo = "";

    if (!!window.cordova) {
      apiService.token().then(function (res) {
        var tomorrow = new Date((new Date()).getTime() + 1000 * res.expires_in);

        var auth = {
          "token": 'Bearer ' + res.access_token,
          "expires": tomorrow
        };

        apiService.setStorage("autenticacao", auth);

        if (!!window.cordova) {
          copyDB(function () {
            vm.loadingInfo = vm.loadingInfoArray[1];
            updateData(function () {
              apiService.delStorage('ProgramasBeneficiosLista');
              apiService.delStorage('ProgramaBeneficiosFiltro');
              GetProgramasBeneficiosDB(function () {
                $state.go('farmacias');
                apiService.setStorage('splashOk', {
                  "ok": true
                });
              });
            });
          });
        } else {
          if (apiService.connect()) {
            apiService.errorCall();
          } else {
            apiService.noInternet()
          }

        }

      }, function (erro) {
        console.debug(erro);
        if (apiService.connect()) {
          apiService.errorCall();
        } else {
          apiService.noInternet()
        }

      });
    } else {
      if (apiService.connect()) {
        $state.reload();
      } else {
        apiService.noInternet()
      }

    }

    var getAtualizacao = function (callback) {
      vm.loadingData = false;

      DBService
        .query('SELECT ProdutoDataAtualizacao FROM etConfiguracao', [])
        .then(function (res) {
          var dataAtualizacao;

          if (res != undefined && res != null && res.rows != null && res.rows != undefined && res.rows.item != null && res.rows.item != undefined && res.rows.item(0) != null && res.rows.item(0).ProdutoDataAtualizacao != null) {
            dataAtualizacao = res.rows.item(0).ProdutoDataAtualizacao.toString().substring(0, 10);
          }
          else {
            dataAtualizacao = $filter('date')(new Date(), "yyyy-MM-dd");
          }
          vm.valueLoading = 10;

          callback(dataAtualizacao);

        }, function (e) {
          console.log("ERROR SELECT DATA: ");
          console.log(e);

        })
    };

    //######################
    // Produtos
    //######################

    var getProdutos = function (dataAtualizacao, callback) {
      vm.loadingData = false;

      if (dataAtualizacao !== null) {

        GetProdutosWS(dataAtualizacao, function (Produtos) {
          GeraSQLInsertProdutos(Produtos, function (arraySqlProduto) {

            if (arraySqlProduto !== null && arraySqlProduto.length > 0) {
              var indexLoopSQLInsert = 0;

              arraySqlProduto.map(function (obj, i) {
                LoopExecuteSQLInsert(obj, function (data) {
                  indexLoopSQLInsert++;

                  vm.valueLoading += (Math.round((i + 1) * 100 / arraySqlProduto.length) * 0.25);

                  if (indexLoopSQLInsert === arraySqlProduto.length) {
                    console.log("ALL PROD INSERT DONE");
                    callback();
                  }
                });
              })
            }
            else {
              callback();
            }
          });
        });
      }
      else {
        console.log("dataAtualizacao nula");
        _callback();
      }
    };

    var GetProdutosWS = function (dataAtualizacao, _callback) {
      apiService
        .get("produto/dataAtualizacao/" + dataAtualizacao + "/Atualizar", {})
        .then(function (res) {
          _callback(res);
        }, function (err) {
          apiService.errorCall(err);
        });
    };

    var GeraSQLInsertProdutos = function (Produtos, callback) {
      if (Produtos !== null && Produtos.length > 0) {

        var insertSQL = "";
        var flagInsertINI = true;

        var arraySqlProduto = [];

        Produtos.forEach(function (obj, i) {
          if (flagInsertINI) {
            insertSQL += 'INSERT OR REPLACE INTO etProduto (idProduto, idLaboratorio, produtoNome, produtoCodEAN, idProgramaBeneficios, produtoAtivo) ';
            insertSQL += 'VALUES (' + obj.id + ', ' + obj.lab + ', "' + obj.desc + '", "' + obj.ean + '", ' + obj.adm + ', 1)';

            flagInsertINI = false;
          }
          else {
            insertSQL += ', (' + obj.id + ', ' + obj.lab + ', "' + obj.desc + '", "' + obj.ean + '", ' + obj.adm + ', 1)';
          }

          if (Produtos.length > 1000) {
            if ((i % 1000) === 0) {
              flagInsertINI = true;

              arraySqlProduto.push(insertSQL);
            }
          }
          else {
            if ((i % 100) === 0) {
              flagInsertINI = true;
              arraySqlProduto.push(insertSQL);
            }
          }
        });

        if (insertSQL !== null && insertSQL !== "") {
          arraySqlProduto.push(insertSQL);
        }

        callback(arraySqlProduto);
      }
      else {
        callback([]);
      }
    };

    //######################
    // Farmácias
    //######################

    var GetFarmacias = function (dataAtualizacao, _callback) {
      if (dataAtualizacao !== null) {
        vm.loadingData = false;

        GetFarmaciasWS(dataAtualizacao, function (dataAtualizacao, res) {
          if (Array.isArray(res)) {
            GeraSQLInsertFarmacias(res, function (arraySqlFarmacia) {
              if (arraySqlFarmacia !== null && arraySqlFarmacia.length > 0) {
                var indexLoopSQLInsert = 0;
                arraySqlFarmacia.forEach(function (element, i) {

                  LoopExecuteSQLInsert(element, function () {
                    indexLoopSQLInsert++;

                    vm.valueLoading += (Math.round((i + 1) * 100 / arraySqlFarmacia.length) * 0.25);

                    if (indexLoopSQLInsert === arraySqlFarmacia.length) {
                      console.log("ALL LAB INSERT DONE");
                      _callback();
                    }
                  });
                });
              }
              else {
                _callback();
              }
            });
          } else {
            apiService.errorCall();
          }

        });
      }
      else {
        console.log("dataAtualizacao nula");
        _callback();
      }
    }

    var GetFarmaciasWS = function (dataAtualizacao, _callback) {
      apiService
        .get("laboratorio/dataAtualizacao/" + dataAtualizacao + "/Atualizar", {})
        .then(function (res) {
          _callback(dataAtualizacao, res);
        }, function (err) {
          console.log(err);
          _callback(dataAtualizacao)
        });
    };

    var GeraSQLInsertFarmacias = function (Farmacias, _callback) {
      if (Farmacias !== null && Farmacias.length > 0) {

        var arraySqlFarmacia = Farmacias.map(function (obj) {
          var insertSQL = "INSERT OR REPLACE INTO etLaboratorio (idLaboratorio, laboratorioNome, laboratorioAtivo) ";
          insertSQL += "VALUES (" + obj.idLaboratorio + ", " + obj.laboratorioNome + ", 1);";

          return insertSQL;
        });

        _callback(arraySqlFarmacia);
      }
      else {
        _callback([]);
      }
    };

    //######################
    // Programas
    //######################
    var GetProgramas = function (dataAtualizacao, _callback) {
      vm.loadingData = false;

      if (dataAtualizacao !== null) {
        GetProgramasWS(dataAtualizacao, function (dataAtualizacao, res) {
          GeraSQLInsertProgramas(res, function (arraySqlPrograma) {
            if (arraySqlPrograma !== null && arraySqlPrograma.length > 0) {
              var indexLoopSQLInsert = 0;
              arraySqlPrograma.forEach(function (element, i) {

                LoopExecuteSQLInsert(element, function () {
                  indexLoopSQLInsert++;

                  vm.valueLoading += (Math.round((i + 1) * 100 / arraySqlPrograma.length) * 0.25);

                  if (indexLoopSQLInsert === arraySqlPrograma.length) {
                    console.log("ALL PROG INSERT DONE");
                    _callback();
                  }
                });
              });
            }
            else {
              _callback();
            }
          });
        });
      }
      else {
        console.log("dataAtualizacao nula");
        _callback();
      }
    };

    var GetProgramasWS = function (dataAtualizacao, _callback) {
      apiService
        .get("programa-beneficios/dataAtualizacao/" + dataAtualizacao + "/Atualizar", {})
        .then(function (res) {
          _callback(dataAtualizacao, res);
        }, function (err) {
          console.log(err);
          _callback(dataAtualizacao)
        });
    };

    var GeraSQLInsertProgramas = function (Programas, _callback) {
      if (Programas !== null && Programas.length > 0) {

        var arraySqlPrograma = Programas.map(function (obj, i) {
          var _adesao = 0;
          if (obj.permiteAdesaoApp) {
            _adesao = 1;
          }

          var insertSQL = "INSERT OR REPLACE INTO etobjBeneficios (idobjBeneficios, idLaboratorio, programaBeneficiosNome, programaBeneficiosDescricao, programaBeneficiosLogomarca, programaBeneficiosAtivo, programaBeneficiosURL, permiteAdesaoApp) ";
          insertSQL += "VALUES (" + obj.idobjBeneficios + ", " + obj.idLaboratorio + ", " + obj.programaBeneficiosNome + ", " + obj.programaBeneficiosDescricao + ", " + obj.programaBeneficiosLogomarca + ",1 , " + obj.programaBeneficiosURL + ", " + _adesao + ");";

          return insertSQL;
        });

        _callback(arraySqlPrograma);
      }
      else {
        _callback([]);
      }
    };

    //######################
    // Utils
    //######################
    var LoopExecuteSQLInsert = function (insertSQL, _callback) {
      DBService
        .query(insertSQL, []).then(function (res) {
        _callback(res);

      }, function (e) {
        console.log("ERROR TX LOOP INSERT: ");
        _callback();
      })
    };

    var UpdateDataUltimaAtualizacao = function (_callback) {

      var dataHora = $filter('date')(new Date(), "yyyy-MM-dd");

      DBService
        .query("UPDATE etConfiguracao SET ProdutoDataAtualizacao = ? WHERE idConfiguracao = ?", [dataHora, 1])
        .then(function (res) {
          console.log("UPDATED: ");
          _callback(res);

        })
        .then(function (err) {
          console.log("ERROR UPDATE: ");
          console.log(err);

          _callback();
        });
    };

    var copyDB = function (_callback) {
      if (!!window.plugins) {
        window.plugins.sqlDB.copy(config.sBancoNome, config.dbLocation,
                                  function () {
                                    console.log("Copy Success");
                                    _callback();

                                  },
                                  function (err) {
                                    if (err.code == 516) {
                                      _callback();
                                    } else {
                                      location.reload();
                                    }

                                  });
      } else {
        $state.reload();
      }

    }

    //######################
    // Update Geral
    //######################

    var dt = 0;
    var updateData = function (callback) {
      getAtualizacao(function (dataAtualizacao) {
        dt = dataAtualizacao;

        getProdutos(dt, function () {
          vm.loadingInfo = vm.loadingInfoArray[2];

          GetFarmacias(dt, function () {
            vm.loadingInfo = vm.loadingInfoArray[3];

            GetProgramas(dt, function () {
              vm.loadingInfo = vm.loadingInfoArray[4];

              UpdateDataUltimaAtualizacao(function () {
                callback();
              });
            });
          });
        })
      })
    }

    var GetProgramasBeneficiosDB = function (_callback) {
      DBService
        .query('SELECT * FROM etProgramaBeneficios WHERE ProgramaBeneficiosAtivo = 1 order by programaBeneficiosNome', [])
        .then(function (res) {
          if (res != undefined && res != null && res.rows != null && res.rows.length != null && res.rows.length > 0) {
            var lista = [];

            for (var i = 0; i < res.rows.length; i++) {
              var item = res.rows.item(i);

              lista.push(item);
            }

            apiService.setStorage('ProgramasBeneficiosLista', lista);

            _callback();
          }

        }, function (err) {
          console.log("ERROR SELECT PROG: ");
          console.log(err);
          _callback();

        })
    };

  }

})(angular);