(function() {
  'use strict';
  angular
    .module('minotaur')
    .controller('MedidaController', MedidaController)
    .service('MedidaServices', MedidaServices);

  /** @ngInject */
  function MedidaController($scope,$uibModal,MedidaServices, ProductoServices, toastr,alertify, pageLoading, uiGridConstants) {
    var vm = this;
    var openedToasts = [];
    vm.fData = {}

    // GRILLA PRINCIPAL
      var paginationOptions = {
        pageNumber: 1,
        firstRow: 0,
        pageSize: 10,
        sort: uiGridConstants.DESC,
        sortName: null,
        search: null
      };
      // vm.dirImagesProducto = $scope.dirImages + "producto/";
      vm.mySelectionGrid = [];
      vm.gridOptions = {
        paginationPageSizes: [10, 50, 100, 500, 1000],
        paginationPageSize: 10,
        enableFiltering: true,
        enableSorting: true,
        useExternalPagination: true,
        useExternalSorting: true,
        useExternalFiltering : true,
        enableRowSelection: true,
        enableRowHeaderSelection: true,
        enableFullRowSelection: false,
        multiSelect: false,
        appScopeProvider: vm
      }
      vm.gridOptions.columnDefs = [
        { field: 'idmedida', name:'idmedida', displayName: 'ID', minWidth: 50, width:80, visible:true, sort: { direction: uiGridConstants.DESC} },
        { field: 'descripcion_tm', name:'descripcion_tm', displayName: 'TIPO MEDIDA', minWidth: 100,},
        { field: 'denominacion', name:'denominacion', displayName: 'MEDIDA', minWidth: 100},
        // { field: 'estado', type: 'object', name: 'estado', displayName: 'ESTADO', maxWidth: 100,width:80, enableFiltering: false,
        //   cellTemplate:'<div class=" ml-md mt-xs onoffswitch green inline-block medium">'+
        //           '<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="switch{{ COL_FIELD.id }}" ng-checked="{{ COL_FIELD.bool }}" ng-click="grid.appScope.btnHabilitarDeshabilitar(row)">'+
        //           '<label class="onoffswitch-label" for="switch{{ COL_FIELD.id }}">'+
        //             '<span class="onoffswitch-inner"></span><span class="onoffswitch-switch"></span>'+
        //           '</label></div>' },
       { field: 'accion', name:'accion', displayName: 'ACCION', width: 140, enableFiltering: false,
          cellTemplate: '<div class="text-center">' +

          '<button class="btn btn-default btn-sm text-green btn-action" ng-click="grid.appScope.btnEditar(row)" tooltip-placement="left" uib-tooltip="EDITAR" > <i class="fa fa-edit"></i> </button>'+
          '<button class="btn btn-default btn-sm text-red btn-action" ng-click="grid.appScope.btnAnular(row)" tooltip-placement="left" uib-tooltip="ELIMINAR"> <i class="fa fa-trash"></i> </button>' +
          '</div>'
        }



      ];
      vm.gridOptions.onRegisterApi = function(gridApi) {
        vm.gridApi = gridApi;
        gridApi.selection.on.rowSelectionChanged($scope,function(row){
          vm.mySelectionGrid = gridApi.selection.getSelectedRows();
        });
        gridApi.selection.on.rowSelectionChangedBatch($scope,function(rows){
          vm.mySelectionGrid = gridApi.selection.getSelectedRows();
        });
        gridApi.pagination.on.paginationChanged($scope, function (newPage, pageSize) {
          paginationOptions.pageNumber = newPage;
          paginationOptions.pageSize = pageSize;
          paginationOptions.firstRow = (paginationOptions.pageNumber - 1) * paginationOptions.pageSize;
          vm.getPaginationServerSide();
        });
        vm.gridApi.core.on.filterChanged( $scope, function(grid, searchColumns) {
          var grid = this.grid;
          paginationOptions.search = true;
          paginationOptions.searchColumn = {
            'idmedida' : grid.columns[1].filters[0].term,
            'denominacion' : grid.columns[2].filters[0].term,
          }
          vm.getPaginationServerSide();
        });
      }

      paginationOptions.sortName = vm.gridOptions.columnDefs[0].name;
      vm.getPaginationServerSide = function() {
        vm.datosGrid = {
          paginate : paginationOptions
        };
        MedidaServices.sListarMedida(vm.datosGrid).then(function (rpta) {
          vm.gridOptions.data = rpta.datos;
          vm.gridOptions.totalItems = rpta.paginate.totalRows;
          vm.mySelectionGrid = [];
        });
      }
      vm.getPaginationServerSide();
      // vm.fBusqueda = {}

    // TIPO MEDIDA
      ProductoServices.sListarTipoMedidaCbo().then(function (rpta) {
        vm.listaTipoMedida = angular.copy(rpta.datos);
        vm.listaTipoMedida.splice(0,0,{ id : '', descripcion:'Seleccione una opción'});
        // vm.temporal.tipo_medida = vm.listaTipoMedida[0];

      });
    // MANTENIMIENTO
      vm.btnNuevo = function(){
        var modalInstance = $uibModal.open({
          templateUrl: 'app/pages/medida/medida_formview.php',
          controllerAs: 'mp',
          size: '',
          backdropClass: 'splash splash-2 splash-ef-16',
          windowClass: 'splash splash-2 splash-ef-16',
          backdrop: 'static',
          keyboard:false,
          controller: function($scope, $uibModalInstance, arrToModal ){
            var vm = this;
            vm.fData = {};
            vm.modoEdicion = false;
            vm.getPaginationServerSide = arrToModal.getPaginationServerSide;
            vm.modalTitle = 'Registro de medidas';

            vm.listaTipoMedida = arrToModal.scope.listaTipoMedida;
            vm.fData.tipo_medida = vm.listaTipoMedida[0];

            vm.aceptar = function () {
              if(vm.fData.tipo_medida.id ==''){
                // alert('Debe seleccionar una imagen');
                toastr.warning('Seleccione tipo de medida', 'Advertencia');
                return false;
              }
              pageLoading.start('Procesando...');
              MedidaServices.sRegistrarMedida(vm.fData).then(function (rpta) {
                pageLoading.stop();
                if(rpta.flag == 1){
                  $uibModalInstance.dismiss('cancel');
                  vm.getPaginationServerSide();
                  var title = 'OK';
                  var type = 'success';
                }else if( rpta.flag == 0 ){
                  var title = 'Advertencia';
                  var type = 'warning';
                }else{
                  alert('En proceso');
                }
                openedToasts.push(toastr[type](rpta.message, title));
              });
            };
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
      vm.btnEditar = function(row){
        var modalInstance = $uibModal.open({
          templateUrl: 'app/pages/medida/medida_formview.php',
          controllerAs: 'mp',
          size: '',
          backdropClass: 'splash splash-2 splash-ef-16',
          windowClass: 'splash splash-2 splash-ef-16',
          backdrop: 'static',
          keyboard:false,
          controller: function($scope, $uibModalInstance, arrToModal ){
            var vm = this;
            vm.fData = {};
            vm.fData = angular.copy(arrToModal.seleccion);
            vm.modoEdicion = true;
            vm.getPaginationServerSide = arrToModal.getPaginationServerSide;
            vm.listaTipoMedida = arrToModal.scope.listaTipoMedida;

            vm.fData.tipo_medida = vm.listaTipoMedida.filter(function(obj) {
              return obj.id == vm.fData.idtipomedida;
            }).shift();
            vm.modalTitle = 'Edición de Medida';
            vm.aceptar = function () {
               if(vm.fData.tipo_medida.id ==''){
                toastr.warning('Seleccione tipo de medida', 'Advertencia');
                return false;
              }
              pageLoading.start('Procesando...');
              MedidaServices.sEditarMedida(vm.fData).then(function (rpta) {
                pageLoading.stop();
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
      vm.btnAnular = function(row){
        alertify.confirm("¿Realmente desea realizar la acción?",function(ev){
            ev.preventDefault();
            MedidaServices.sAnularMedida(row.entity).then(function (rpta) {
              if(rpta.flag == 1){
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
          },
          function(ev){
            ev.preventDefault();
            // alertify.error('Cancel');
        });
      }
      // vm.btnHabilitarDeshabilitar = function (row) {
      //   MedidaServices.sHabilitarDeshabilitarMedida(row.entity).then(function (rpta) {
      //     if(rpta.flag == 1){
      //       vm.getPaginationServerSide();
      //       var title = 'OK';
      //       var type = 'success';
      //       toastr.success(rpta.message, title);
      //     }else if( rpta.flag == 0 ){
      //       var title = 'Advertencia';
      //       var type = 'warning';
      //       toastr.warning(rpta.message, title);
      //     }else{
      //       alert('Ocurrió un error');
      //     }
      //   });
      // }
  }
  function MedidaServices($http, $q) {
    return({
      sListarMedida: sListarMedida,
      sRegistrarMedida: sRegistrarMedida,
      sEditarMedida: sEditarMedida,
      sAnularMedida: sAnularMedida,
      // sHabilitarDeshabilitarMedida: sHabilitarDeshabilitarMedida,

    });
    function sListarMedida(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Medida/listar_medidas",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sRegistrarMedida(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Medida/registrar_medida",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sEditarMedida(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Medida/editar_medida",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sAnularMedida(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Medida/anular_medida",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    // function sHabilitarDeshabilitarMedida(pDatos) {
    //   var datos = pDatos || {};
    //   var request = $http({
    //         method : "post",
    //         url :  angular.patchURLCI + "Medida/habilitar_deshabilitar_medida",
    //         data : datos
    //   });
    //   return (request.then( handleSuccess,handleError ));
    // }

  }
})();