(function (angular) {
  "use strict";
  angular.module('appGoPharma')
         .controller('farmaciaController', farmaciaController);

  farmaciaController.$inject = ['$scope', 'apiService', 'DBService', '$window', '$state'];

  function farmaciaController($scope, apiService, DBService, $window, $state) {
    var vm = $scope;

    vm.progBeneficios = [];

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

    vm.farmacias = apiService.getStorage('farmaciaEscolhida');
    vm.farmacias.urlMapa = "https://maps.google.com/maps?q=" + vm.farmacias.latitude + "," + vm.farmacias.longitude + "&hl=es;z=16&output=embed";

    vm.openRotas = function () {
      $window.open('google.navigation:q=' + vm.farmacias.latitude + ',' + vm.farmacias.longitude + '&mode=d', '_system');
    }

    vm.searchFarmacias = function (item) {
      $state.go('farmacias', {"beneficio": vm.farmacias.idProgramaBeneficios});
    }

    vm.filtros = vm.filtros.map(function (obj) {
      obj.api = vm.farmacias[obj.api] ? vm.farmacias[obj.api] : false;
      return obj;
    }).filter(function (obj) {
      return obj.selected;
    });

    var query = 'SELECT * FROM etProgramaBeneficios WHERE ProgramaBeneficiosAtivo = 1 AND idProgramaBeneficios IN (' + vm.farmacias.programaBeneficios + ')';

    DBService
      .query(query, [])
      .then(function (data, tx) {
        if (data != undefined && data != null && data.rows != null && data.rows != undefined && data.rows.length > 0) {
          for (var i = 0; i < data.rows.length; ++i) {
            vm.progBeneficios.push(data.rows.item(i));
          }
        }

        console.log(vm.progBeneficios);

      }, function (err) {
        apiService.errorCall(err)
      })

  }

})(angular);