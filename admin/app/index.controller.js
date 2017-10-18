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
    .directive('hcChart', function () {
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
  });

  /** @ngInject */
  function MainController($translate,$scope,$state,$location, rootServices, empresaNombre) {
    var vm = this;
    $scope.dirImages = angular.patchURL+'uploads/';
     // $scope.valores = [true,true,true,true,true,true];
    // console.log('$translate',$translate);
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
      vm.changeLanguage($scope.fSessionCI.ididioma);
    };

    $scope.btnLogoutToSystem = function () {
      rootServices.sLogoutSessionCI().then(function () {
        $scope.fSessionCI = {};
        // $scope.listaUnidadesNegocio = {};
        // $scope.listaModulos = {};
        $scope.logOut();
        $scope.goToUrl('/app/pages/login');
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
      if($scope.fSessionCI.idgrupo == 1){
        $scope.valores = [true,true,true,true,true,true,true,true,false,false,false];
      }
      else if($scope.fSessionCI.idgrupo == 2){
        $scope.valores = [true,true,true,true,true,false,true,false,false,false,false];
      }
      else if($scope.fSessionCI.idgrupo == 3){
        $scope.valores = [true,false,false,false,false,false,false,false,true,true,true];
      }
      else{
        console.log('No tiene grupo');
        $scope.valores = [false,false,false,false,false,false,false,false,false,false];
      }
    }
    $scope.getValidateSession = function () {
      rootServices.sGetSessionCI().then(function (response) {
        if(response.flag == 1){
          $scope.fSessionCI = response.datos;
          $scope.logIn();
          console.log('logIn ->',response);
          if( $location.path() == '/app/pages/login' ){
            $scope.goToUrl('/');
          }
          $scope.CargaMenu();
        }else{
          $scope.fSessionCI = {};
          $scope.logOut();
          console.log('logOut ->',response);
          //alert('Saliendo del admin');
          $scope.goToUrl('/app/pages/login');
        }
      });

    }
    $scope.getValidateSession();


  }
  function rootServices($http, $q) {
    return({
        sLogoutSessionCI: sLogoutSessionCI,
        sGetSessionCI: sGetSessionCI,
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
  }
})();
