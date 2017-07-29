(function() {
  'use strict';

  angular
    .module('caribbean')
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
    })
    .directive('fancybox', function ($compile, $http) {
      return {
        restrict: 'A',
        controller: function($scope) {
          $scope.openFancybox = function (url) {
            $http.get(url).then(function(response) {
                if (response.status == 200) {

                    var template = angular.element(response.data);
                    var compiledTemplate = $compile(template);
                    compiledTemplate($scope);

                    $.fancybox.open({
                      content: template,
                      type: 'html',
                      maxWidth: 450,
                      maxHeight: 350,
                      fitToView: false,
                      width: '90%',
                      height: '90%',
                      padding: 0,
                      autoSize: false,
                      closeClick: false,
                      openMethod: 'dropIn',
                      openSpeed: 150,
                      closeMethod: 'dropOut',
                      closeSpeed: 150,
                      beforeShow: function () {
                        $("#main-container").addClass("bluring");
                      },
                      afterClose: function () {
                        $("#main-container").removeClass("bluring");
                      }
                    });
                }
            });
          };
        }
      };
    });

  /** @ngInject */
  function MainController($scope, rootServices, $location) {
    var vm = this;
    // console.log('$translate',$translate);


    $scope.goToUrl = function ( path ) {
      $location.path( path );
    };
    $scope.getValidateSession = function () {
      rootServices.sGetSessionCI().then(function (response) {
        //console.log(response);
        if(response.flag == 1){
          $scope.fSessionCI = response.datos;
          // $scope.logIn();
          // if( $location.path() == '/app/pages/login' ){
          //   $scope.goToUrl('/admin/');
          // }
        }else{
          $scope.fSessionCI = {};
        }
      });

    }
    $scope.getValidateSession();
    $scope.login = function(){
      console.log('$scope.fLogin',$scope.fLogin);
      rootServices.sLoginToSystem($scope.fLogin).then(function (response) {
        $scope.fAlert = {};
        if( response.flag == 1 ){ // SE LOGEO CORRECTAMENTE
          $scope.fAlert.type= 'success';
          $scope.fAlert.msg= response.message;
          $scope.fAlert.strStrong = 'OK.';
          //$scope.getValidateSession();
          //$scope.logIn();
          // $scope.getNotificaciones();
        }else if( response.flag == 0 ){ // NO PUDO INICIAR SESION
          $scope.fAlert.type= 'danger';
          $scope.fAlert.msg= response.message;
          $scope.fAlert.strStrong = 'Error.';
        }else if( response.flag == 2 ){  // CUENTA INACTIVA
          $scope.fAlert.type= 'orange';
          $scope.fAlert.msg= response.message;
          $scope.fAlert.strStrong = 'Aviso.';
          //$scope.listaSedes = response.datos;
        }else{
          alert('Error inesperaado');
        }
        $scope.fAlert.flag = response.flag;
        //$scope.fLogin = {};
        console.log('scope.fAlert',$scope.fAlert);

      });
    }
  }
  function rootServices($http, $q) {
    return({
        sLoginToSystem: sLoginToSystem,
        sLogoutSessionCI: sLogoutSessionCI,
        sGetSessionCI: sGetSessionCI,
    });
    function sLoginToSystem(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Acceso/",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
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
