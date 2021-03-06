(function() {
  'use strict';

  angular
    .module('minotaur')
    .controller('LoginController', LoginController)
    .service('loginServices', loginServices);

  /** @ngInject */
  function LoginController($scope,loginServices) {
  	$scope.getValidateSession();
    $scope.fLogin = {};
  	$scope.btnLoginToSystem = function () {
      //console.log('esta en el Login');
      if($scope.fLogin.usuario == null || $scope.fLogin.clave == null || $scope.fLogin.usuario == '' || $scope.fLogin.clave == ''){
        $scope.fAlert = {};
        $scope.fAlert.type= 'warning';
        $scope.fAlert.msg= 'Debe completar los campos usuario y contraseña.';
        $scope.fAlert.strStrong = 'Aviso.';
        $scope.fAlert.icono = 'fa fa-warning';
        return;
      }

      loginServices.sLoginToSystem($scope.fLogin).then(function (response) {
        $scope.fAlert = {};
        if( response.flag == 1 ){ // SE LOGEO CORRECTAMENTE
          $scope.fAlert.type= 'success';
          $scope.fAlert.msg= response.message;
          $scope.fAlert.strStrong = 'OK.';
          $scope.fAlert.icono = 'fa fa-check';
          $scope.getValidateSession();
          $scope.logIn();
          // $scope.getNotificaciones();
        }else if( response.flag == 0 ){ // NO PUDO INICIAR SESION
          $scope.fAlert.type= 'danger';
          $scope.fAlert.msg= response.message;
          $scope.fAlert.strStrong = 'Error.';
          $scope.fAlert.icono = 'fa fa-bullhorn';
        }else if( response.flag == 2 ){  // CUENTA INACTIVA
          $scope.fAlert.type= 'warning';
          $scope.fAlert.msg= response.message;
          $scope.fAlert.strStrong = 'Aviso.';
          $scope.fAlert.icono = 'fa fa-warning';
          $scope.listaSedes = response.datos;
        }
        $scope.fAlert.flag = response.flag;
        //$scope.fLogin = {};
      });
    }
  }

  function loginServices($http, $q) {
    return({
        sLoginToSystem: sLoginToSystem
    });
    function sLoginToSystem(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "acceso/",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
  }

})();
