(function() {
  'use strict';
  angular
    .module('minotaur')
    .controller('MensajeController', MensajeController)
    .service('MensajeServices', MensajeServices);

  /** @ngInject */
  function MensajeController($scope,$uibModal, uiGridConstants, toastr, tileLoading, MensajeServices) {
    var vm = this;
    var openedToasts = [];
    vm.fData = {}
    // GRILLA PRINCIPAL
      vm.gridOptions = {
        appScopeProvider: vm
      }
      vm.gridOptions.columnDefs = [
        { field: 'idmensaje', name:'idmensaje', displayName: 'ID', minWidth: 50, width:80, visible:true},
        { field: 'seccion', name:'seccion', displayName: 'SECCION', minWidth: 100, width: 140},
        { field: 'contenido_f', name:'contenido', displayName: 'CONTENIDO', minWidth: 100, },
        { field: 'accion', name:'accion', displayName: 'ACCION', width: 80, enableFiltering: false,
          cellTemplate: '<div class="text-center">' +
          '<button class="btn btn-default btn-sm text-green btn-action" ng-click="grid.appScope.btnEditar(row)" tooltip-placement="left" uib-tooltip="EDITAR" > <i class="fa fa-edit"></i> </button>'+
          '</div>'
        }
      ];
      vm.gridOptions.onRegisterApi = function(gridApi) {
        vm.gridApi = gridApi;
      }
      // paginationOptions.sortName = vm.gridOptions.columnDefs[0].name;
      vm.getPaginationServerSide = function() {
        tileLoading.start();
        MensajeServices.sListarMensajes().then(function (rpta) {
          tileLoading.stop();
          vm.gridOptions.data = rpta.datos;
        });
      }
      vm.getPaginationServerSide();
    // MANTENIMIENTO
      vm.btnEditar = function(row){
        var modalInstance = $uibModal.open({
          templateUrl: 'app/pages/mensaje/mensaje_formview.php',
          controllerAs: 'me',
          size: 'lg',
          backdropClass: 'splash splash-2 splash-ef-16',
          windowClass: 'splash splash-2 splash-ef-16',
          controller: function($scope, $uibModalInstance, arrToModal ){
            var vm = this;
            vm.fData = {};
            vm.fData = angular.copy(arrToModal.seleccion);
            vm.modoEdicion = true;
            vm.getPaginationServerSide = arrToModal.getPaginationServerSide;
            vm.modalTitle = 'Edición de Mensaje';

            vm.aceptar = function () {

              MensajeServices.sEditarMensaje(vm.fData).then(function (rpta) {
                if(rpta.flag == 1){
                  $uibModalInstance.dismiss('cancel');
                  vm.getPaginationServerSide();
                  var title = 'OK';
                  var type = 'success';
                }else if( rpta.flag == 0 ){
                  var title = 'Advertencia';
                  var type = 'warning';
                }else{
                  alert('Ocurrió un error');
                }
                openedToasts.push(toastr[type](rpta.message, title));
              });
              $uibModalInstance.close(vm.fData);
            };
            vm.cancel = function () {
              $uibModalInstance.dismiss('cancel');
            };
          },
          resolve: {
            arrToModal: function() {
              return {
                getPaginationServerSide : vm.getPaginationServerSide,
                seleccion : row.entity,
                scope : vm,
              }
            }
          }
        });
      }
  }
  function MensajeServices($http, $q) {
    return({
        sListarMensajes: sListarMensajes,
        sEditarMensaje: sEditarMensaje,
    });
    function sListarMensajes(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Mensaje/listar_mensajes",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sEditarMensaje(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Mensaje/editar_mensaje",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
  }
})();