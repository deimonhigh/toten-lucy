(function (angular) {
  "use strict";
  angular.module('appToten')
         .controller('pagamentoController', pagamentoController);

  pagamentoController.$inject = ['$scope', '$rootScope', 'apiService', '$state', '$timeout'];

  function pagamentoController($scope, $rootScope, apiService, $state, $timeout) {
    var vm = $scope;
    var root = $rootScope;
    vm.dadosVendedor = {};
    vm.formaPagamento = '';
    vm.editarPagamentoFlag = false;
    vm.cliente = apiService.getStorage('cliente');
    vm.formaPagamentoStorage = apiService.getStorage('formaPagamento');
    vm.comprovante = apiService.getStorage('comprovante');
    vm.frete = apiService.getStorage('frete');

    vm.totalCarrinho = 0;
    vm.totalCarrinhoFrete = 0;

    var getComprovante = function () {
      $timeout(function () {
        vm.comprovante = apiService.getStorage('comprovante');
      });

      if (!vm.comprovante) {
        getComprovante();
      }
    };

    vm.listaCompras = apiService.getStorage('carrinho') || [];

    var calcTotal = function () {
      return vm.listaCompras.reduce(function (previousValue, obj) {
        return previousValue + (obj.preco * obj.qnt);
      }, 0);
    };

    vm.totalCarrinho = calcTotal();

    var padLeft = function (nr, n, str) {
      return Array(n - String(nr).length + 1).join(str || '0') + nr;
    };

    vm.idPedido = 'SF.' + padLeft(vm.cliente.idPedido, 13).replace(/^(\d{4})(\d{4})(\d+)(\d{2})/, '$1.$2.$3-$4');

    vm.validarVendedor = function () {
      var enviar = {};
      apiService.delStorage('comprovante');
      enviar.identificacao = vm.dadosVendedor.identificacao;
      enviar.senha = vm.dadosVendedor.senha;
      apiService.post('vendedores/validate', enviar).then(function (res) {
        apiService.setStorage('vendedor', res.result);
        root.openFoto();
      }, function (err) {
        alert(err.error);
      })
    };

    vm.editarPagamento = function () {
      vm.editarPagamentoFlag = !vm.editarPagamentoFlag;

      apiService.setStorage('formaPagamento', vm.formaPagamento);

      if (vm.editarPagamentoFlag && vm.formaPagamento.total) {
        $timeout(function () {
          vm.totalCarrinho = vm.formaPagamento.total;
          var frete = 0;
          if (vm.frete) {
            frete = parseFloat(vm.frete.valor);
          }
          vm.totalCarrinhoFrete = vm.formaPagamento.total + frete;
        });
      }
    };

    var calcularFrete = function (cep) {
      var dados = {
        "cep": cep,
        "peso": vm.listaCompras.reduce(function (carry, next) {
          return carry + parseFloat(next.peso);
        }, 0),
        "total": calcTotal()
      };
      getFrete(dados);
    };

    var getFrete = function (dados) {
      apiService
        .post('frete', dados)
        .then(function (res) {
          apiService.setStorage('frete', res.result);
          vm.frete = res.result;
          vm.totalCarrinhoFrete = dados.total + parseFloat(res.result.valor);
        });
    };

    vm.$on('confirmarImg', function () {
      var formaPagamento = apiService.getStorage('formaPagamento');
      vm.comprovante = apiService.getStorage('comprovante');
      var comprovantes = apiService.getStorage('comprovanteCodigos');
      var auth = apiService.getStorage('auth');
      vm.cliente = apiService.getStorage('cliente');
      var vendedor = apiService.getStorage('vendedor');

      var send = {};
      send.idcliente = vm.cliente.id;
      send.email = auth.email;
      send.frete = vm.frete.valor;
      send.prazo = vm.frete.prazo;
      send.total = vm.formaPagamentoStorage.total;
      send.totalSemJuros = vm.listaCompras.reduce(function (previousValue, obj) {
        return previousValue + (obj.preco * obj.qnt);
      }, 0);
      send.idPedido = vm.cliente.idPedido;
      send.img = vm.comprovante;

      send.produtos = vm.listaCompras.map(function (obj) {
        return {
          "produto_id": obj.id,
          "codigoproduto": obj.codigoproduto,
          "qnt": obj.qnt,
          "preco": obj.preco,
        };
      });

      if (comprovantes) {
        send.comprovantes = comprovantes.map(function (obj) {
          return {
            "bandeira": obj.bandeira.id,
            "codigo": obj.codigo,
            "vendedor_id": vendedor.id
          };
        });
      }

      send.parcelas = formaPagamento.parcelas;
      send.aVista = formaPagamento.aVista;

      apiService.post('pedidos/save', send).then(function (res) {
        alert('Pedido finalizado com sucesso!');
        apiService.setStorage('boleto', res.result);
        $state.go('finalizacao');
      }, function (err) {
        if (err.code === 1) {
          alert(err.error);
        } else {
          alert('Pedido não concluída, por favor tente novamente!');
        }
        $state.go('pagamento');
      });
    });

    var comJurosAVista = vm.totalCarrinho + vm.totalCarrinho * (root.temaStorage['parcela0'] / 100);
    vm.listaPagamentos = [
      {
        "index": 0,
        "parcelas": 0,
        "aVista": true,
        "descricao": 'À vista | R$ ' + comJurosAVista.toFixed(2).replace('.', ','),
        "total": comJurosAVista
      }
    ];

    var maxParcelas = root.temaStorage.max_parcelas;

    for (var i = 1; i <= maxParcelas; i++) {
      var comJuros = vm.totalCarrinho + vm.totalCarrinho * (root.temaStorage['parcela' + i] / 100);
      var pagamento = {
        "index": i + 1,
        "parcelas": i,
        "aVista": false,
        "descricao": 'Cartão de crédito | ' + i + 'x de R$ ' + (comJuros / i).toFixed(2).replace('.', ','),
        "total": comJuros
      };

      if (root.temaStorage['parcela' + i] == 0) {
        pagamento.descricao += " s/ juros"
      }

      vm.listaPagamentos.push(pagamento);
    }

    calcularFrete(vm.cliente.cep);
  }

})
(angular);