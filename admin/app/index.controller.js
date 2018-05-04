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
    .directive('ngEnter', function() {
    return function(scope, element, attrs) {
      element.bind("keydown", function(event) {

          if(event.which === 13) {
            //event.preventDefault();
            scope.$apply(function(){
              scope.$eval(attrs.ngEnter);
            });
            //event.stopPropagation();
          }
          //event.stopPropagation();
          //event.preventDefault();
      });
    };
  })
    /*.directive('hcChart', function () {
      return {
          restrict: 'E',
          template: '<div></div>',
          scope: {
              options: '='
          },
          link: function (scope, element) {
            // scope.$watch(function () {
            //   return attrs.chart;
            // }, function () {
            //     if (!attrs.chart) return;
            //     var charts = JSON.parse(attrs.chart);
            //     $(element[0]).highcharts(charts);
                Highcharts.chart(element[0], scope.options);
            // });

          }
      };
    })*/;

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
        // if (monto === false){
        //   console.log('cero');
        //   $scope.saldo = 0;
        // }else{
          $scope.saldo = $scope.fSessionCI.monedero - parseInt(monto);
        // }
      }else{
        $scope.saldo = $scope.fSessionCI.monedero;
      }

    }
    vm.changeLanguage = function (langKey) {
      // console.log('langKey',langKey);langKey
      $translate.use(langKey);
      vm.currentLanguage = langKey;
    };
    $scope.empresaNombre = empresaNombre;
    //vm.currentLanguage = $translate.proposedLanguage() || $translate.use();

    $scope.fSessionCI = {};

    $scope.isLoggedIn = false;
    $scope.logOut = function() {
      $scope.isLoggedIn = false;
      $scope.captchaValido = false;
    }

    $scope.logIn = function() {
      $scope.isLoggedIn = true;
      /* if($scope.fSessionCI.key_grupo == 'key_cliente'){
        vm.currentLanguage = 'en';
      }else{
        vm.currentLanguage = 'es';
      }*/
      vm.changeLanguage($scope.fSessionCI.ididioma);
    };

    $scope.btnLogoutToSystem = function () {
      var esCliente = ($scope.fSessionCI.idgrupo == 3)? true : false;
      rootServices.sLogoutSessionCI().then(function () {
        $scope.fSessionCI = {};
        $scope.seleccionadas = 0;
        $scope.logOut();
        // if(esCliente){
          $window.location.href = $scope.dirBase;
        // }else{
          // $scope.goToUrl('/app/pages/login');
        // }
      });
    };
    $scope.gChangeLanguage = function(langKey){
      vm.changeLanguage(langKey);
    }

    $scope.goToUrl = function ( path ) {
      $location.path( path );
    };

    $scope.CargaMenu = function() {
      var opciones = [
        'opDashboard',
        'opClientes',
        'opBanners',
        'opMantenimiento',
        'opConfig',
        'opSeguridad',
        'opPerfil',
        'opGaleria',
        'opMiGaleria'
      ];
      if($scope.fSessionCI.idgrupo == 1){ // SU
        $scope.valores = [true,true,true,true,true,true,true,true,true,true,false,false,false];
      }
      else if($scope.fSessionCI.idgrupo == 2){ // admin
        $scope.valores = [false,true,true,false,true,true,false,false,true,true,false,false,false];
      }
      else if($scope.fSessionCI.idgrupo == 5){ // supervisor
        $scope.valores = [false,true,true,false,false,false,false,false,false,false,false,false,false];
      }
      else if($scope.fSessionCI.idgrupo == 4){ // operador
        $scope.valores = [false,true,false,false,false,false,false,false,false,false,false,false,false];
      }
      else if($scope.fSessionCI.idgrupo == 3){ // cliente
        $scope.valores = [false,false,false,false,false,false,false,false,false,false,true,true,false];
      }
      else{
        console.log('No tiene grupo');
        $scope.valores = [false,false,false,false,false,false,false,false,false,false];
      }
    }
    $scope.getValidateSession = function () {
      var esCliente = false;
      if(angular.isObject($scope.fSessionCI)){
        esCliente = ($scope.fSessionCI.idgrupo == 3)? true : false;
      }
      rootServices.sGetSessionCI().then(function (response) {
        if(response.flag == 1){
          $scope.fSessionCI = response.datos;
          $scope.logIn();
          if( $location.path() == '/app/pages/login' && !esCliente ){
            $scope.goToUrl('/');
          }else if(($location.path() == '/app/pages/login' || $location.path() == '/app/dashboard') && esCliente){
            if($scope.fSessionCI.procesado == 4){
              console.log('completo');
              $scope.goToUrl('/app/mi-galeria');
            }else{
              $scope.goToUrl('/app/tienda');
              console.log('incompleto');
            }
          }
          $scope.CargaMenu();
          $scope.saldo = $scope.fSessionCI.monedero;
        }else{
          $scope.fSessionCI = {};
          $scope.logOut();
          if(esCliente){
            $window.location.href = $scope.dirBase;
          }else{
            $scope.goToUrl('/app/pages/login');
          }
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
