angular
  .module("appGoPharma")
  .constant("config", {
    sBancoNome: "0000000000000001.db",
    sBancoVersao: "1.0",
    sBancoNomeExibicao: "Base de Dados GoPharma",
    sBancoTamanho: 1500000,

    sVersao: "1.0.0.D",
    sDataVersao: "01/12/2015",
    dbLocation: 0,
    appNome: "GoPharma",
    appCliente: "GoPharma",
    appEmpresa: "Entire Tecnologia da Informação",
    appVersao: "v3.0.0",
    appVersaoDate: "21/04/2017",
    analyticsID: "UA-71432340-1",
    apiKeyGoogle: "AIzaSyCG7hxi9Da7_UQXx_fB2dWmHqGKB8D3cTY",
    AMBIENTE: {
      DesenvCAP: {
        URL: "http://172.16.32.22/GoPharmaWS/Servico.asmx/",
        URLDownload: "http://172.16.32.22/GoPharmaWS/"
      },
      DesenvSPO: {
        URL: "http://172.22.22.63/GoPharma/webservice/Servico.asmx/",
        URLDownload: "http://172.22.22.63/GoPharma/webservice/",
        URL_OAUTH: "https://homolog1.pharmalinkonline.com.br/GoPharma_HOM/oauthgopharma/token",
        URL_S: "https://172.22.22.63/GoPharma/webapi/"
      },
      ProducaoIOS: {
        URL: "http://www.gopharma.com.br/webservicesIOS/Servico.asmx/",
        URLDownload: "http://www.gopharma.com.br/webservicesIOS/"
      },
      Producao: {
        URL: "http://www.gopharma.com.br/wsgopharma/servico.asmx/",
        URLDownload: "http://www.gopharma.com.br/wsgopharma/",
        URL_OAUTH: "https://www.gopharma.com.br/oauthgopharma/token",
        URL_S: "https://www.gopharma.com.br/apigopharma/"
      },
      Gopharma_HOM: {
        URL: "http://homolog1.pharmalinkonline.com.br:6080/gopharma/wsgopharma/servico.asmx/",
        URLDownload: "http://homolog1.pharmalinkonline.com.br:6080/gopharma/wsgopharma/",
        URL_OAUTH: "https://homolog1.pharmalinkonline.com.br/GoPharma_HOM/oauthgopharma/token",
        URL_S: "https://homolog1.pharmalinkonline.com.br/GoPharma_HOM/apigopharma/"
      },
      GoPharma_DEV: {
        URL: "http://homolog1.pharmalinkonline.com.br:6080/gopharma/wsgopharma/servico.asmx/",
        URLDownload: "http://homolog1.pharmalinkonline.com.br:6080/gopharma/wsgopharma/",
        URL_OAUTH: "https://homolog1.pharmalinkonline.com.br/GoPharma_DEV/oauthgopharma/token",
        URL_S: "https://homolog1.pharmalinkonline.com.br/GoPharma_DEV/apigopharma/"
      }
    },
    accessToken: {
      'grant_type': 'client_credentials',
      'client_id': 'gopharma.app',
      'client_secret': 'fkp12q@',
      'scope': 'r:pdv r:produto r:pbm r:lab w:pbm'
    },
    header: {
      "headers": {
        "Content-Type": "application/x-www-form-urlencoded"
      }
    }
  });
