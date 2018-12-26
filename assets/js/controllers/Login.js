(function() {
  'use strict';

  angular
    .module('caribbean')
    .controller('LoginController', LoginController)
    .service('loginServices', loginServices);
  function LoginController($scope, $window, $uibModal, loginServices, empresaNombre, $routeParams,$timeout,$location) {
    var vm = this;
    vm.empresaNombre = empresaNombre;
    vm.fLogin = {};
    vm.error = false;
    if($routeParams.c){
      console.log('route',$routeParams.c);
      vm.fLogin.codigo = $routeParams.c;
      loginServices.sLoginToSystem(vm.fLogin).then(function(rpta){
        if(rpta.flag == 1){
          if( rpta.datos.procesado == 4 ){
            $window.location.href = $scope.dirWeb+'shop/#/app/my-gallery';
          }else{
            $window.location.href = $scope.dirWeb+'shop/#/app/shop';
          }
        }else if(rpta.flag == 0){
          vm.error = true;
          vm.fLogin.codigo = null;
        }
      });
    }
    vm.btnLoginToSystem = function () {
      loginServices.sLoginToSystem(vm.fLogin).then(function(rpta){
        if(rpta.flag == 1){
          if( rpta.datos.procesado == 4 ){
            $window.location.href = $scope.dirWeb+'shop/#/app/my-gallery';
          }else{
            $window.location.href = $scope.dirWeb+'shop/#/app/shop';
          }
          // $scope.goToUrl('/admin');
        }else if(rpta.flag == 0){
          vm.error = true;
          vm.fLogin.codigo = null;
        }
      });

    }
    vm.btnInfo = function(){
      var modalInstance = $uibModal.open({
        templateUrl: 'templates/popups/modal_info.php',
        controllerAs: 'mi',
        size: '',
        // backdropClass: 'splash splash-2 splash-ef-16',
        // windowClass: 'splash splash-2 splash-ef-16',
        // backdrop: 'static',
        // keyboard:false,
        scope: $scope,
        controller: function($scope, $uibModalInstance, arrToModal ){
          var vm = this;
          vm.modalTitle = 'Where\'s my code?';
          vm.cancel = function () {
            $uibModalInstance.dismiss('cancel');
          };
        },
        resolve: {
          arrToModal: function() {
            return {
              scope : vm,
            }
          }
        }
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
            url :  angular.patchURLCI + "acceso/acceder_cliente",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
  }

})();
