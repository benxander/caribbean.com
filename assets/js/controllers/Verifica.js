(function() {
  'use strict';

  angular
    .module('caribbean')
    .controller('VerificaController', VerificaController)
    .service('verificaServices', verificaServices);
  function VerificaController($scope, $window, empresaNombre, verificaServices, $routeParams,$timeout,$location,) {
    var vm = this;
    vm.empresaNombre = empresaNombre;
    vm.fData = {};
    vm.error = false;
    vm.uri = 'tienda';
    vm.counter = 10;
    // console.log('loc',$location);
    if($routeParams.c && $routeParams.f ){
      vm.fData.idcliente_enc = $routeParams.c;
      vm.fData.idarchivo_enc = $routeParams.f;
      verificaServices.sVerificaEmail(vm.fData).then(function(rpta){
        if(rpta.flag == 1){
          vm.fData.mensaje = rpta.message;
          vm.uri = 'mi-galeria';
          vm.class = 'success';
          // $window.location.href = $scope.dirWeb+'admin/#/app/tienda';
          // $scope.goToUrl('/admin');
        }else if(rpta.flag == 0){
          vm.error = true;
          vm.fData.mensaje = rpta.message;
          vm.uri = 'tienda';
          vm.class = 'danger';
        }else{
          alert('Sistema detenido');
        }
        $scope.onTimeout = function(){
            vm.counter--;
            mytimeout = $timeout($scope.onTimeout,1000);
            if( vm.counter <= 0 ){
              $timeout.cancel(mytimeout);
              $window.location.href = $scope.dirWeb + 'admin/#/app/' + vm.uri;
            }
        }
        var mytimeout = $timeout($scope.onTimeout,1000);

        vm.redirige = function(){
            $timeout.cancel(mytimeout);
            $window.location.href = $scope.dirWeb + 'admin/#/app/' + vm.uri;
        }
      });
    }

  }

  function verificaServices($http, $q) {
    return({
        sVerificaEmail: sVerificaEmail
    });
    function sVerificaEmail(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Compra/verificar_email",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
  }

})();
