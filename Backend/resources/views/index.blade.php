<!DOCTYPE html><html lang="pt-BR" ng-app="appToten"><head> <meta charset="utf-8"> <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,user-scalable=no"> <meta name="robots" content="noindex,nofollow"> <title>Toten Lucy</title> <meta name="theme-color" content="#FF9800"> <meta name="msapplication-navbutton-color" content="#FF9800"> <meta name="apple-mobile-web-app-status-bar-style" content="#FF9800"> <meta name="mobile-web-app-capable" content="yes"> <meta name="apple-mobile-web-app-capable" content="yes"> <script type="text/javascript">if (document.location.protocol !="https:"){document.location=document.URL.replace(/^http:/i, "https:");}</script> <link rel="stylesheet" type="text/css" href="{{url('assets/css/style.min.css') . "?" . round(microtime(true) * 1000)}}"> <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700" rel="stylesheet"> <link href="https://fonts.googleapis.com/css?family=Lato:400,600,700" rel="stylesheet"> <style ng-bind="tema"></style></head><body ng-class="{'inicio': inicio}"> <ui-view class="ng-cloak"></ui-view> <div ng-controller="fotoController" class="hidden" ng-class="{'hidden': !foto}"> <div class="tableModal full fixed black animate-if"> <div class="tCell"> <div class="dib foto"> <div class="grid"> <div class="column"> <div class="right"> <div class="btnHolder"><h3>COMPROVANTE <br>DE PAGAMENTO</h3></div></div><form name="comprovantesForm" ng-submit="false"> <ul> <li ng-repeat="item in comprovantes"> <button ng-click="removeItem(item)">- Excluir</button> <div class="formField"><select name="bandeira" ng-model="item.bandeira" required ng-options="item as item.descricao for item in bandeiras track by item.id"> <option value selected="selected">Selecione a bandeira</option> </select></div><div class="formField"><input type="number" required name="codigo" ng-model="item.codigo" placeholder="Digite o código do cupom"></div></li></ul> <div class="btnHolder"> <button type="button" ng-if="!hideButtonComprovante" class="btn btnFoto no-animate" ng-click="addComprovante()">+ ADICIONAR OUTRO </button> </div></form> </div><div class="column" ng-if="!confirmFoto"> <div class="imgExample"> <webcam channel="channel" on-streaming="onSuccess()" on-error="onError(err)" on-stream="onStream(stream)" ng-if="!picture"></webcam> <button type="button" class="btn" ng-click="makeSnapshot()"> <div class="img"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 490 490" width="512" height="512"> <style>.a{fill : #FFF;}</style> <path d="M0 167.85v216.2c0 33 26.8 59.8 59.8 59.8h370.4c33 0 59.8-26.8 59.8-59.8v-216.2c0-31.4-25.5-56.9-56.9-56.9h-79.6l-1.9-8.3c-7.7-33.3-37-56.5-71.2-56.5h-70.9c-34.1 0-63.4 23.2-71.2 56.5l-1.9 8.3H56.9C25.5 110.95 0 136.55 0 167.85zM146.2 135.45c5.7 0 10.6-3.9 11.9-9.5l4.1-17.8c5.2-22.1 24.6-37.5 47.3-37.5h70.9c22.7 0 42.1 15.4 47.3 37.5l4.1 17.8c1.3 5.5 6.2 9.5 11.9 9.5H433c17.9 0 32.4 14.5 32.4 32.4v216.2c0 19.5-15.8 35.3-35.3 35.3H59.8c-19.5 0-35.3-15.8-35.3-35.3v-216.2c0-17.9 14.5-32.4 32.4-32.4H146.2z" class="a"/> <circle cx="82.9" cy="187.75" r="16.4" class="a"/> <path d="M245 380.95c56.7 0 102.9-46.2 102.9-102.9s-46.2-102.9-102.9-102.9 -102.9 46.1-102.9 102.9S188.3 380.95 245 380.95zM245 199.65c43.2 0 78.4 35.2 78.4 78.4s-35.2 78.4-78.4 78.4 -78.4-35.2-78.4-78.4S201.8 199.65 245 199.65z" class="a"/> </svg> </div>fotografar </button> </div></div><div class="column" ng-if="confirmFoto"> <div class="imgExample OkFoto"><img ng-src="@{{imgResponse}}" alt="Foto"> <button type="button" class="btn tp" ng-click="notOkFoto()"> <div class="img"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 490 490" width="512" height="512"> <style>.a{fill : #FFF;}</style> <path d="M0 167.85v216.2c0 33 26.8 59.8 59.8 59.8h370.4c33 0 59.8-26.8 59.8-59.8v-216.2c0-31.4-25.5-56.9-56.9-56.9h-79.6l-1.9-8.3c-7.7-33.3-37-56.5-71.2-56.5h-70.9c-34.1 0-63.4 23.2-71.2 56.5l-1.9 8.3H56.9C25.5 110.95 0 136.55 0 167.85zM146.2 135.45c5.7 0 10.6-3.9 11.9-9.5l4.1-17.8c5.2-22.1 24.6-37.5 47.3-37.5h70.9c22.7 0 42.1 15.4 47.3 37.5l4.1 17.8c1.3 5.5 6.2 9.5 11.9 9.5H433c17.9 0 32.4 14.5 32.4 32.4v216.2c0 19.5-15.8 35.3-35.3 35.3H59.8c-19.5 0-35.3-15.8-35.3-35.3v-216.2c0-17.9 14.5-32.4 32.4-32.4H146.2z" class="a"/> <circle cx="82.9" cy="187.75" r="16.4" class="a"/> <path d="M245 380.95c56.7 0 102.9-46.2 102.9-102.9s-46.2-102.9-102.9-102.9 -102.9 46.1-102.9 102.9S188.3 380.95 245 380.95zM245 199.65c43.2 0 78.4 35.2 78.4 78.4s-35.2 78.4-78.4 78.4 -78.4-35.2-78.4-78.4S201.8 199.65 245 199.65z" class="a"/> </svg> </div>repetir foto </button> <button type="button" class="btn no-animate" ng-click="closeModal()" ng-if="comprovantesForm.$valid"><i class="fa fa-check" aria-hidden="true"></i> confirmar </button> </div></div><canvas id="snapshot" width="300" height="240"></canvas> </div></div></div></div></div><script src="{{url('assets/js/scripts.min.js') . "?" . round(microtime(true) * 1000)}}"></script> <script src="{{url('assets/angular/app.min.js') . "?" . round(microtime(true) * 1000)}}"></script> <script src="{{url('assets/angular/config/configModule.min.js') . "?" . round(microtime(true) * 1000)}}"></script> <script src="{{url('assets/angular/views/viewsModule.min.js') . "?" . round(microtime(true) * 1000)}}"></script> <script src="{{url('assets/angular/service/serviceModule.min.js') . "?" . round(microtime(true) * 1000)}}"></script> <script src="{{url('assets/angular/directive/directiveModule.min.js') . "?" . round(microtime(true) * 1000)}}"></script> <script src="{{url('assets/angular/factory/factoryModule.min.js') . "?" . round(microtime(true) * 1000)}}"></script></body></html>