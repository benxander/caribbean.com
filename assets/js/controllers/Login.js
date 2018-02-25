(function() {
  'use strict';

  angular
    .module('caribbean')
    .controller('LoginController', LoginController)
    .service('loginServices', loginServices);
  function LoginController($scope, $window, loginServices, empresaNombre) {
    var vm = this;
    vm.empresaNombre = empresaNombre;
    console.log(empresaNombre);
    vm.fLogin = {};
    vm.error = false;
    // $scope.getValidateSession();
    vm.btnLoginToSystem = function () {
      loginServices.sLoginToSystem(vm.fLogin).then(function(rpta){
        if(rpta.flag == 1){
          $window.location.href = $scope.dirWeb+'admin/#/app/tienda';
          // $scope.goToUrl('/admin');
        }else if(rpta.flag == 0){
          vm.error = true;
          vm.fLogin.codigo = null;
        }
      });

    }
    // vm.getValidateSession = function () {
    //   loginServices.sGetSessionCI().then(function (response) {
    //     if(response.flag == 1){
    //       $scope.fSessionCI = response.datos;
    //       $scope.logIn();
    //       console.log('logIn ->',response);
    //       if( $location.path() == '/app/pages/login' && $scope.fSessionCI.idgrupo != 3 ){
    //         $scope.goToUrl('/');
    //       }else if($location.path() == '/app/pages/login' && $scope.fSessionCI.idgrupo == 3){
    //         $scope.goToUrl('/app/tienda');
    //       }
    //       $scope.CargaMenu();
    //       $scope.saldo = $scope.fSessionCI.monedero;
    //     }else{
    //       $scope.fSessionCI = {};
    //       $scope.logOut();
    //       console.log('logOut ->',response);
    //       //alert('Saliendo del admin');
    //       $scope.goToUrl('/app/pages/login');
    //     }
    //   });

    // }
    // vm.getValidateSession();
  }

  function loginServices($http, $q) {
    return({
        sLoginToSystem: sLoginToSystem
    });
    function sLoginToSystem(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "acceso/acceder_cliente",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
  }

})();
