(function () {
  "use strict";

  angular.module("appToten").factory("produtoModel", produtoModel);

  produtoModel.$inject = [];

  function produtoModel() {
    return function (load) {
      this.codigobarras = load ? "Carregando..." : null;
      this.codigoprodutoabaco = load ? "Carregando..." : null;
      this.codigoprodutopai = null;
      this.codigoproduto = load ? "Carregando..." : null;
      this.nomeproduto = load ? "Carregando..." : null;
      this.descricao = load ? "Carregando..." : null;
      this.cor = load ? "Carregando..." : null;
      this.categoriaId = load ? "Carregando..." : null;
      this.preco1 = load ? "Carregando..." : null;
      this.precopromocao1 = load ? "Carregando..." : null;
      this.preco2 = load ? "Carregando..." : null;
      this.precopromocao2 = load ? "Carregando..." : null;
      this.peso = load ? "Carregando..." : null;
      this.disabled = false;
    }
  }

})();