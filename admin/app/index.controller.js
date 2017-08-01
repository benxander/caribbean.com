(function() {
  'use strict';

  angular
    .module('minotaur')
    .controller('MainController', MainController)
    .service('rootServices', rootServices)
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
    // console.log('$translate',$translate);
    vm.changeLanguage = function (langKey) {
      // console.log('langKey',langKey);langKey
      $translate.use(langKey);
      vm.currentLanguage = langKey;
    };
    $scope.empresaNombre = empresaNombre;
    //vm.currentLanguage = $translate.proposedLanguage() || $translate.use();
    vm.changeLanguage('es');

    $scope.fSessionCI = {};

    $scope.isLoggedIn = false;
    $scope.logOut = function() {
      $scope.isLoggedIn = false;
      $scope.captchaValido = false;
    }

    $scope.logIn = function() {
      $scope.isLoggedIn = true;
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


    $scope.goToUrl = function ( path ) {
      $location.path( path );
    };

    $scope.getValidateSession = function () {
      rootServices.sGetSessionCI().then(function (response) {
        if(response.flag == 1){
          $scope.fSessionCI = response.datos;
          $scope.logIn();
          console.log('logIn ->',response);
          if( $location.path() == '/app/pages/login' ){
            $scope.goToUrl('/');
          }
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
    $scope.CargaMenu = function() {
      var opciones = ['opDashboard','opClientes','opBanners','opMantenimiento','opSeguridad'];
      if($scope.fSessionCI.idgrupo == 1){
        $scope.valores = [true,true,true,true,true];
      }
      else if($scope.fSessionCI.idgrupo == 2){
        $scope.valores = [true,true,true,true,true];
      }
      else if($scope.fSessionCI.idgrupo == 3){
        $scope.valores = [true,true,true,true,true];
      }
      else{
        $scope.valores = [true,true,true,true,true];
      }
    }
    $scope.CargaMenu();

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
