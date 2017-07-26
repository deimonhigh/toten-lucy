(function (angular) {
  "use strict";
  angular.module('appToten')
         .controller('pagamentoMpController', pagamentoMpController);

  pagamentoMpController.$inject = ['$scope', '$rootScope', 'apiService', '$state', '$timeout', 'mercadoPago', 'cfpLoadingBar'];

  function pagamentoMpController($scope, $rootScope, apiService, $state, $timeout, mercadoPago, cfpLoadingBar) {
    var vm = $scope;
    var root = $rootScope;
    vm.dadosVendedor = {};
    vm.formaPagamento = '';
    vm.editarPagamentoFlag = false;
    vm.cliente = apiService.getStorage('cliente');
    vm.comprovante = apiService.getStorage('comprovante');
    vm.frete = apiService.getStorage('frete');

    vm.dados = {
      'type': 'CPF',
      'cpf': vm.cliente.documento
    };

    vm.okCartaoCredito = false;

    vm.infoNeeded = true;

    vm.tipoPagamento = apiService.getStorage('tiposPagamentoMP') || [];

    vm.totalCarrinho = 0;
    vm.totalCarrinhoFrete = 0;

    vm.listaCompras = apiService.getStorage('carrinho') || [];

    if (vm.tipoPagamento.length === 0) {
      mercadoPago.getPaymentsMethods().then(function (res) {
        console.log(res);
        apiService.setStorage('tiposPagamentoMP', res.response);
        vm.tipoPagamento = res.response;
      });
    }

    vm.mesValidade = Array.apply(null, Array(12)).map(function (_, i) {
      return {
        "name": i + 1,
        "id": i + 1
      };
    });
    vm.dados.mes = 1;

    var anoAtual = new Date().getFullYear();
    vm.anoValidade = Array.apply(null, Array(12)).map(function (_, i) {
      return {
        "name": anoAtual + i,
        "id": anoAtual + i
      };
    });
    vm.dados.ano = anoAtual;

    vm.validaCartao = function (cartao) {
      if (cartao && cartao.toString().length >= 6) {
        mercadoPago.getBin(cartao.toString()).then(function (res) {
          vm.okCartaoCredito = res.status !== 200 && res.status !== 201;
          if (res.status !== 200 && res.status !== 201) {
            alert('Parece que seu cartão não é válido.');
          }
          vm.tipoPagamento.map(function (obj) {
            if (res.status !== 200 && res.status !== 201) {
              obj.active = false;
            } else {
              vm.dados.typeId = res.response[0].id;
              obj.active = obj.id === res.response[0].id;
            }
          });
        });
      }
    };

    vm.salvarPagamento = function () {
      var formaPagamento = apiService.getStorage('formaPagamento');
      var comprovante = apiService.getStorage('comprovante');
      var auth = apiService.getStorage('auth');
      var cliente = apiService.getStorage('cliente');
      var vendedor = apiService.getStorage('vendedor');
      var formaPagamentoStorage = apiService.getStorage('formaPagamento');

      cfpLoadingBar.start();

      mercadoPago.getIdTypes().then(function (res) {
        vm.dados.type = res.response[0].id;
        mercadoPago.mPago().clearSession();

        var form = document.getElementById("formaPagamento");
        mercadoPago.createToken(form).then(function (res) {
          cfpLoadingBar.complete();

          if (res.status !== 200 && res.status !== 201) {
            alert('Algumas informações do seu cartão não estão corretas, por favor verifique.');
            return;
          }
          var send = {};
          send.token = res.response.id;
          send.method = vm.dados.typeId;
          send.idcliente = cliente.id;
          send.email = auth.email;
          send.frete = vm.frete.valor;
          send.prazo = vm.frete.prazo;
          send.total = formaPagamentoStorage.total;
          send.totalSemJuros = vm.listaCompras.reduce(function (previousValue, obj) {
            return previousValue + (obj.preco * obj.qnt);
          }, 0);

          send.idPedido = cliente.idPedido;

          send.produtos = vm.listaCompras.map(function (obj) {
            return {
              "produto_id": obj.id,
              "codigoproduto": obj.codigoproduto,
              "qnt": obj.qnt,
              "preco": obj.preco,
            };
          });

          send.parcelas = formaPagamento.parcelas;
          send.aVista = formaPagamento.aVista;

          apiService.post('pedidos/saveMp', send).then(function (res) {
            if (res.result.boleto) {
              alert('Pedido esperando finalização!');
            } else {
              alert('Pedido finalizado com sucesso!');
            }

            apiService.setStorage('boleto', res.result);
            $state.go('finalizacao');
          }, function (err) {
            if (err.code == 1) {
              alert(err.error.msg);
            } else {
              alert('Pedido não concluída, por favor tente novamente!');
            }
            $state.go('pagamentoMP');
          });

        });
      });
    };

    //region Informações do pagamento
    var calcTotal = function () {
      return vm.listaCompras.reduce(function (previousValue, obj) {
        return previousValue + (obj.preco * obj.qnt);
      }, 0);
    };

    vm.totalCarrinho = calcTotal();

    vm.editarPagamento = function () {
      vm.editarPagamentoFlag = !vm.editarPagamentoFlag;

      apiService.setStorage('formaPagamento', vm.formaPagamento);

      if (vm.editarPagamentoFlag && vm.formaPagamento.total) {
        $timeout(function () {
          var frete = 0;
          if (vm.frete) {
            frete = parseFloat(vm.cliente.freteValor.valor);
          }
          vm.totalCarrinhoFrete = angular.copy(vm.totalCarrinho) + frete;
        });
      }

      if ((vm.formaPagamento.boleto) || (!vm.formaPagamento.boleto && vm.formaPagamento.aVista)) {
        $timeout(function () {
          vm.infoNeeded = false;
          vm.dados.typeId = 'bolbradesco';
          vm.tipoPagamento.map(function (obj) {
            obj.active = obj.id === 'bolbradesco';
          });
        });
      } else {
        vm.infoNeeded = true;
      }
    };

    var padLeft = function (nr, n, str) {
      return Array(n - String(nr).length + 1).join(str || '0') + nr;
    };

    vm.idPedido = 'TESTE.' + padLeft(vm.cliente.idPedido, 13).replace(/^(\d{4})(\d{4})(\d+)(\d{2})/, '$1.$2.$3-$4');
    //endregion

    //region Frete
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
    //endregion

    //region Gerar Select Pagamento
    var comJurosAVista = (vm.totalCarrinho + vm.totalCarrinho * (parseFloat(root.temaStorage['parcela0']) / 100)) + parseFloat(vm.cliente.freteValor.valor);
    vm.listaPagamentos = [
      {
        "index": 90,
        "parcelas": 0,
        "boleto": true,
        "aVista": true,
        "descricao": 'Boleto | R$ ' + comJurosAVista.toFixed(2).replace('.', ','),
        "total": comJurosAVista
      }
    ];

    var maxParcelas = root.temaStorage.max_parcelas;

    for (var i = 1; i <= maxParcelas; i++) {
      var comJuros = (vm.totalCarrinho + vm.totalCarrinho * (parseFloat(root.temaStorage['parcela' + i]) / 100)) + parseFloat(vm.cliente.freteValor.valor);
      var pagamento = {
        "index": i + 1,
        "parcelas": i,
        "boleto": false,
        "aVista": false,
        "descricao": 'Cartão de crédito | ' + i + 'x de R$ ' + (comJuros / i).toFixed(2).replace('.', ','),
        "total": comJuros
      };

      if (root.temaStorage['parcela' + i] == 0) {
        pagamento.descricao += " s/ juros"
      }

      vm.listaPagamentos.push(pagamento);
    }
    //endregion

    calcularFrete(vm.cliente.cep);
  }

})
(angular);