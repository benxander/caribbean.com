(function() {
  'use strict';

  angular
    .module('minotaur')
    .controller('MainController', MainController)
    .service('rootServices', rootServices)
    .factory("tileLoading", function(cfpLoadingBar){
      var tileLoading = {
        start: function(text){
            var tile = angular.element('.tile');
            // var pageText = angular.element('.page-loading-text');
            tile.addClass('loading');
            cfpLoadingBar.start();
        },
        stop: function(){
            var tile = angular.element('.tile');
            // var pageText = angular.element('.page-loading-text');
            tile.removeClass('loading');
            cfpLoadingBar.complete();
        }
      }
      return tileLoading;
    })
    .factory("pageLoading", function(){
      var pageLoading = {
        start: function(text){
            var page = angular.element('#page-loading');
            var pageText = angular.element('.page-loading-text');
            page.addClass('visible');
            pageText.text(text);
        },
        stop: function(){
            var page = angular.element('#page-loading');
            var pageText = angular.element('.page-loading-text');
            page.removeClass('visible');
            pageText.text('');
        }
      }
      return pageLoading;
    })
    .factory("handle", function(alertify){
      var handle = {
        error: function (error) {
          return function () {
            return {success: false, message: Notification.warning({message: error})};
          };
        },
        success: function (response) {
            //console.log('response.data',response.data);
            if(response.data.flag == 'session_expired'){
              alertify.okBtn("CLICK AQUI")
                      .cancelBtn("Cerrar")
                      .confirm(response.data.message,
                        function (ev) {
                          var dir = window.location.href.split('app')[0];
                          window.location.href = dir + 'app/pages/login';
                        }
                      );
            }
            return( response.data );
        }
      }
      return handle;
    })
    .factory("ModalReporteFactory", function($uibModal,$http,pageLoading,rootServices,toastr,handle){
      var interfazReporte = {
        getPopupReporte: function(arrParams){
         console.log('arrParams.datos.salida',arrParams.datos.salida);
          if( arrParams.datos.salida == 'excel' ){
            pageLoading.start('Preparando reporte');
            $http.post(arrParams.url, arrParams.datos).then(function(rpta){
              pageLoading.stop();
              var data = rpta.data;
              console.log('rpta : ',rpta);
              if(data.flag == 1){
                window.location = data.urlTempEXCEL;
              }else if(data.flag == 0){
                toastr.error('No se pudo generar el reporte', 'Error');
              }

            },handle.error);
          }
        }
      }
      return interfazReporte;
    })
    .directive('ngEnter', function() {
    return function(scope, element, attrs) {
      element.bind("keydown", function(event) {
          if(event.which === 13) {
            scope.$apply(function(){
              scope.$eval(attrs.ngEnter);
            });
          }
      });
    };
  });

  /** @ngInject */
  function MainController($translate,$scope,$state,$location, $window, rootServices, empresaNombre) {
    var vm = this;
    $scope.isSelected = false;
    $scope.seleccionadas = 0;
    $scope.monto_cesta = 0;
    $scope.dirBase = angular.patchURL;
    $scope.dirImages = angular.patchURL+'uploads/';
    rootServices.sCargarDatosWeb().then(function (response) {
      if(response.flag == 1){
        $scope.dataWeb = response.datos;
      }else{
        console.log('no data');
      }
    });
    $scope.$watch('seleccionadas',function(newValue, oldValue){
      if (newValue===oldValue) {
        return;
      }
    });
    $scope.$watch('monto_cesta',function(newValue, oldValue){
      if (newValue===oldValue) {
        return;
      }
    });
    $scope.actualizarSeleccion = function(sel, monto){
      $scope.seleccionadas = sel;
    }
    $scope.actualizarMonto = function(monto){
      $scope.monto_cesta = monto;
    }
    $scope.actualizarSaldo = function(isSel,monto){
      console.log('$scope.fSessionCI.monedero',$scope.fSessionCI.monedero);
      if(isSel){
          $scope.saldo = $scope.fSessionCI.monedero - parseInt(monto);
      }else{
        $scope.saldo = $scope.fSessionCI.monedero;
      }

    }
    vm.changeLanguage = function (langKey) {
      $translate.use(langKey);
      vm.currentLanguage = langKey;
    };
    $scope.empresaNombre = empresaNombre;
    $scope.fSessionCI = {};

    $scope.isLoggedIn = false;
    $scope.logOut = function() {
      $scope.isLoggedIn = false;
      $scope.captchaValido = false;
    }

    $scope.logIn = function() {
      $scope.isLoggedIn = true;
      vm.changeLanguage($scope.fSessionCI.ididioma);
    };

    $scope.btnLogoutToSystem = function () {
      var esCliente = ($scope.fSessionCI.idgrupo == 3)? true : false;
      rootServices.sLogoutSessionCI().then(function () {
        $scope.fSessionCI = {};
        $scope.seleccionadas = 0;
        $scope.logOut();
        $window.location.href = $scope.dirBase;
      });
    };
    $scope.gChangeLanguage = function(langKey){
      vm.changeLanguage(langKey);
    }

    $scope.goToUrl = function ( path ) {
      $location.path( path );
    };

    $scope.CargaMenu = function() {
        if( $scope.fSessionCI.procesado == 4 ){ // completo
          $scope.valores = [false,false,true];
        }else{
          $scope.valores = [false,true,true];
        }
    }
    $scope.getValidateSession = function () {
      rootServices.sGetSessionCI().then(function (response) {
        if(response.flag == 1){
          $scope.fSessionCI = response.datos;
          $scope.logIn();

          if( $scope.fSessionCI.procesado == 4 ){
            console.log('completo');
            $scope.goToUrl('/app/my-gallery');
          }
          /*else{
            $scope.goToUrl('/app/shop');
            console.log('incompleto');
          }*/

          $scope.CargaMenu();
          $scope.saldo = $scope.fSessionCI.monedero;
        }else{
          $scope.fSessionCI = {};
          $scope.logOut();
          $window.location.href = $scope.dirBase;
        }
      });

    }
    $scope.getValidateSession();


  }
  function rootServices($http, $q) {
    return({
        sLogoutSessionCI: sLogoutSessionCI,
        sGetSessionCI: sGetSessionCI,
        sCargarDatosWeb: sCargarDatosWeb
    });
    function sLogoutSessionCI(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Acceso/logoutSessionCI",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sGetSessionCI(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Acceso/getSessionCI",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sCargarDatosWeb(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Config/listar_configuracion",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
  }
})();
