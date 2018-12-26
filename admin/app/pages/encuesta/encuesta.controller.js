(function() {
  'use strict';
  angular
    .module('minotaur')
    .controller('EncuestaController', EncuestaController)
    .service('EncuestaServices', EncuestaServices);

  /** @ngInject */
  function EncuestaController($scope,$uibModal,$filter, EncuestaServices,toastr,alertify, pageLoading, uiGridConstants) {
    var vm = this;
    var openedToasts = [];
    vm.fData = {}
    vm.fData.v1 = 0;
    vm.fData.v2 = 0;
    vm.fData.v3 = 0;
    vm.fData.v4 = 0;
    vm.fData.v5 = 0;
    // GRILLA PRINCIPAL
      vm.gridOptions = {

        appScopeProvider: vm
      }
      vm.gridOptions.columnDefs = [
        { field: 'puntos', name:'puntos', displayName: 'PUNTOS', minWidth: 50, width:80, visible:true},
        { field: 'puntaje', name:'puntaje', displayName: 'PUNTAJE', minWidth: 100 ,enableFiltering:false},
        { field: 'porcentaje', name:'porcentaje', displayName: '%', minWidth: 100, width:80 },

      ];
      vm.gridOptions.onRegisterApi = function(gridApi) {
        vm.gridApi = gridApi;

      }

      // paginationOptions.sortName = vm.gridOptions.columnDefs[0].name;
      vm.getPaginationServerSide = function() {
        EncuestaServices.sListarPuntuacion().then(function (rpta) {
          if(rpta.flag == 1){
            vm.gridOptions.data = rpta.datos;
            vm.promedio = rpta.promedio;
            vm.total = rpta.total;
            vm.porcentaje = rpta.porcentaje;
            vm.style = "{'width: "+ vm.porcentaje +"%'}";
            vm.fData.v5 = vm.gridOptions.data[0].porcentaje;
            vm.fData.v4 = vm.gridOptions.data[1].porcentaje;
            vm.fData.v3 = vm.gridOptions.data[2].porcentaje;
            vm.fData.v2 = vm.gridOptions.data[3].porcentaje;
            vm.fData.v1 = vm.gridOptions.data[4].porcentaje;
          }else if( rpta.flag == -1 ){
            $scope.goToUrl('/app/pages/login');
          }
        });
      }
      vm.getPaginationServerSide();
      // vm.fBusqueda = {}
    vm.verDetalle = function(row){
      var modalInstance = $uibModal.open({
        templateUrl: 'app/pages/encuesta/detalle_encuesta_view.php',
        controllerAs: 'mp',
        size: 'lg',
        backdropClass: 'splash splash-2 splash-ef-16',
        windowClass: 'splash splash-2 splash-ef-16',
        backdrop: 'static',
        keyboard: false,
        scope: $scope,
        controller: function($scope, $uibModalInstance, arrToModal ){
          var vm = this;
          vm.fData = {};
          vm.getPaginationServerSide = arrToModal.getPaginationServerSide;
          vm.modalTitle = 'Detalle de encuesta';
          vm.fData = row.entity;
          // cargar imagenes del pedido
          vm.cancel = function () {
            $uibModalInstance.dismiss('cancel');
          };
        },
        resolve: {
          arrToModal: function() {
            return {
              getPaginationServerSide : vm.getPaginationServerSide,
              scope : vm,
            }
          }
        }
      });
    }

    vm.btnComentarios = function(){
      pageLoading.start('Cargando..');
      var modalInstance = $uibModal.open({
        templateUrl: 'app/pages/encuesta/comentarios_view.php',
        controllerAs: 'mp',
        size: 'lg',
        backdropClass: 'splash splash-2 splash-ef-16',
        windowClass: 'splash splash-2 splash-ef-16',
        backdrop: 'static',
        keyboard: false,
        scope: $scope,
        controller: function($scope, $uibModalInstance, arrToModal ){
          var vm = this;
          vm.listadoComentarios = [];
          // vm.getPaginationServerSide = arrToModal.getPaginationServerSide;
          vm.modalTitle = 'Comentarios';

          EncuestaServices.sListarComentarios().then(function (rpta) {
            pageLoading.stop();
            vm.message = rpta.message;
            if(rpta.flag == 1){
              vm.listadoComentarios = rpta.datos;

            }
          });

          vm.cancel = function () {
            $uibModalInstance.dismiss('cancel');
          };
        },
        resolve: {
          arrToModal: function() {
            return {
              getPaginationServerSide : vm.getPaginationServerSide,
              scope : vm,
            }
          }
        }
      });
    }


  }
  function EncuestaServices($http, $q) {
    return({
      sListarPuntuacion: sListarPuntuacion,
      sListarComentarios: sListarComentarios,
    });
    function sListarPuntuacion(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Movimiento/listar_puntuacion",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sListarComentarios(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Movimiento/listar_comentarios",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
  }
})();