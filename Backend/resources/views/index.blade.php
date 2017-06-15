<!DOCTYPE html><html lang="pt-BR" ng-app="appToten"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,user-scalable=no"><title>Toten Lucy</title><meta name="theme-color" content="#FF9800"><meta name="msapplication-navbutton-color" content="#FF9800"><meta name="apple-mobile-web-app-status-bar-style" content="#FF9800"><meta name="mobile-web-app-capable" content="yes"><meta name="apple-mobile-web-app-capable" content="yes"><script type="text/javascript">if (document.location.protocol != "https:") {document.location = document.URL.replace(/^http:/i, "https:");}</script><link rel="stylesheet" type="text/css" href="{{ url('assets/css/style.min.css') }}"><link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700" rel="stylesheet"><link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet"><style ng-bind="tema"></style></head><body ng-class="{'inicio': inicio}"><ui-view class="ng-cloak"></ui-view><div ng-controller="fotoController" class="hidden" ng-class="{'hidden': !foto}"><div class="tableModal full fixed black animate-if" ng-if="foto"><div class="tCell"><div class="dib foto"><div class="closeModal" ng-click="closeModal()"></div><div class="grid"><div class="column"><div class="img"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 390.271 390.271" width="512" height="512"><style>.a{fill:#FFF;}</style><path d="M363.669 168.533C363.669 75.83 288.356 0 195.135 0 102.432 0 26.602 75.313 26.602 168.533c0 68.267 41.18 126.836 99.75 153.406 -20.04 12.477-36.849 30.901-46.093 53.139 -2.327 3.62-0.905 14.481 10.279 15.192h210.295c12.735-1.552 11.378-11.895 10.279-15.192 -9.762-22.238-25.988-40.663-46.093-53.139C322.489 295.37 363.669 236.865 363.669 168.533zM281.826 368.549H108.444c11.378-16.808 27.669-29.802 47.127-36.849 12.994 3.232 25.988 4.849 40.081 4.849 13.576 0 27.087-1.616 40.081-4.849C254.222 338.747 270.448 351.741 281.826 368.549zM195.135 314.893c-69.883 0-128.97-49.325-143.063-115.459h20.04c5.947 0 10.861-4.849 10.861-10.861 0-5.948-4.848-10.861-10.861-10.861H48.84c0-3.232 0-17.907 0-21.657h44.412c5.947 0 10.861-4.849 10.861-10.861 0-6.012-4.849-10.861-10.861-10.861h-41.18C67.782 69.818 125.77 21.592 195.135 21.592c80.743 0 146.877 65.552 146.877 146.877S275.879 314.893 195.135 314.893z" class="a"/><path d="M195.135 83.976c-46.61 0-83.976 37.947-83.976 84.558s37.883 84.04 83.976 84.04c46.61 0 83.976-37.948 83.976-83.976S241.745 83.976 195.135 83.976zM195.135 230.853c-34.715 0-62.319-28.186-62.319-62.319 0-34.715 27.669-62.836 62.319-62.836s62.319 28.186 62.319 62.836C257.455 202.667 229.851 230.853 195.135 230.853z" class="a"/><path d="M195.135 125.22c-5.947 0-10.861 4.848-10.861 10.861 0 6.012 4.849 10.861 10.861 10.861 11.895 0 21.657 9.762 21.657 21.657 0 5.947 4.849 10.861 10.861 10.861 6.012 0 10.861-4.849 10.861-10.861C238.513 144.679 218.99 125.22 195.135 125.22z" class="a"/></svg></div><div class="right"><h3>ANEXAR<br>COMPROVANTE</h3><p>POSICIONE O COMPROVANTE DO PAGEMENTO EM FRENTE A CÂMERA</p></div></div><div class="column" ng-if="!confirmFoto"><div class="imgExample"><webcam channel="channel" on-streaming="onSuccess()" on-error="onError(err)" on-stream="onStream(stream)" ng-if="!picture"></webcam><button type="button" class="btn" ng-click="makeSnapshot()"><div class="img"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 490 490" width="512" height="512"><style>.a{fill:#FFF;}</style><path d="M0 167.85v216.2c0 33 26.8 59.8 59.8 59.8h370.4c33 0 59.8-26.8 59.8-59.8v-216.2c0-31.4-25.5-56.9-56.9-56.9h-79.6l-1.9-8.3c-7.7-33.3-37-56.5-71.2-56.5h-70.9c-34.1 0-63.4 23.2-71.2 56.5l-1.9 8.3H56.9C25.5 110.95 0 136.55 0 167.85zM146.2 135.45c5.7 0 10.6-3.9 11.9-9.5l4.1-17.8c5.2-22.1 24.6-37.5 47.3-37.5h70.9c22.7 0 42.1 15.4 47.3 37.5l4.1 17.8c1.3 5.5 6.2 9.5 11.9 9.5H433c17.9 0 32.4 14.5 32.4 32.4v216.2c0 19.5-15.8 35.3-35.3 35.3H59.8c-19.5 0-35.3-15.8-35.3-35.3v-216.2c0-17.9 14.5-32.4 32.4-32.4H146.2z" class="a"/><circle cx="82.9" cy="187.75" r="16.4" class="a"/><path d="M245 380.95c56.7 0 102.9-46.2 102.9-102.9s-46.2-102.9-102.9-102.9 -102.9 46.1-102.9 102.9S188.3 380.95 245 380.95zM245 199.65c43.2 0 78.4 35.2 78.4 78.4s-35.2 78.4-78.4 78.4 -78.4-35.2-78.4-78.4S201.8 199.65 245 199.65z" class="a"/></svg></div>fotografar</button></div></div><div class="column" ng-if="confirmFoto"><div class="imgExample OkFoto"><img ng-src="@{{ imgResponse }}" alt="Foto"> <button type="button" class="btn tp" ng-click="notOkFoto()"><div class="img"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 490 490" width="512" height="512"><style>.a{fill:#FFF;}</style><path d="M0 167.85v216.2c0 33 26.8 59.8 59.8 59.8h370.4c33 0 59.8-26.8 59.8-59.8v-216.2c0-31.4-25.5-56.9-56.9-56.9h-79.6l-1.9-8.3c-7.7-33.3-37-56.5-71.2-56.5h-70.9c-34.1 0-63.4 23.2-71.2 56.5l-1.9 8.3H56.9C25.5 110.95 0 136.55 0 167.85zM146.2 135.45c5.7 0 10.6-3.9 11.9-9.5l4.1-17.8c5.2-22.1 24.6-37.5 47.3-37.5h70.9c22.7 0 42.1 15.4 47.3 37.5l4.1 17.8c1.3 5.5 6.2 9.5 11.9 9.5H433c17.9 0 32.4 14.5 32.4 32.4v216.2c0 19.5-15.8 35.3-35.3 35.3H59.8c-19.5 0-35.3-15.8-35.3-35.3v-216.2c0-17.9 14.5-32.4 32.4-32.4H146.2z" class="a"/><circle cx="82.9" cy="187.75" r="16.4" class="a"/><path d="M245 380.95c56.7 0 102.9-46.2 102.9-102.9s-46.2-102.9-102.9-102.9 -102.9 46.1-102.9 102.9S188.3 380.95 245 380.95zM245 199.65c43.2 0 78.4 35.2 78.4 78.4s-35.2 78.4-78.4 78.4 -78.4-35.2-78.4-78.4S201.8 199.65 245 199.65z" class="a"/></svg></div>fotografar</button> <button type="button" class="btn" ng-click="closeModal()"><i class="fa fa-check" aria-hidden="true"></i> confirmar</button></div></div><canvas id="snapshot" width="300" height="240"></canvas></div></div></div></div></div><script src="{{ url('assets/js/scripts.min.js') }}"></script><script src="{{ url('assets/angular/app.min.js') }}"></script><script src="{{ url('assets/angular/config/configModule.min.js') }}"></script><script src="{{ url('assets/angular/views/viewsModule.min.js') }}"></script><script src="{{ url('assets/angular/service/serviceModule.min.js') }}"></script><script src="{{ url('assets/angular/directive/directiveModule.min.js') }}"></script><script src="{{ url('assets/angular/factory/factoryModule.min.js') }}"></script></body></html>