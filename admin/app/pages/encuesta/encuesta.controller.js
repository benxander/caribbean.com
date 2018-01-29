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
    // GRILLA PRINCIPAL
      vm.gridOptions = {

        appScopeProvider: vm
      }
      vm.gridOptions.columnDefs = [
        { field: 'puntos', name:'puntos', displayName: 'PUNTOS', minWidth: 50, width:80, visible:true},
        { field: 'puntaje', name:'puntaje', displayName: 'PUNTAJE', minWidth: 100 ,enableFiltering:false},
        { field: 'porcentaje', name:'porcentaje', displayName: '%', minWidth: 100, width:80 }
      ];
      vm.gridOptions.onRegisterApi = function(gridApi) {
        vm.gridApi = gridApi;

      }

      // paginationOptions.sortName = vm.gridOptions.columnDefs[0].name;
      vm.getPaginationServerSide = function() {
        EncuestaServices.sListarPuntuacion().then(function (rpta) {
          vm.gridOptions.data = rpta.datos;
          vm.promedio = rpta.promedio;
          vm.total = rpta.total;
          vm.porcentaje = rpta.porcentaje;
          vm.style = "{'width: "+ vm.porcentaje +"%'}";
          console.log('vm.porcentaje',vm.porcentaje);
          console.log('vm.style',vm.style);
           // vm.mySelectionGrid = [];
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
        keyboard:false,
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


  }
  function EncuestaServices($http, $q) {
    return({
      sListarPuntuacion: sListarPuntuacion

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
  }
})();