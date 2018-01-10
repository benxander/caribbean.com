(function() {
  'use strict';
  angular
    .module('minotaur')
    .controller('MedidaController', MedidaController)
    .service('MedidaServices', MedidaServices);

  /** @ngInject */
  function MedidaController($scope,$uibModal,MedidaServices,toastr,alertify, pageLoading, uiGridConstants) {
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
        { field: 'descripcion_tm', name:'descripcion_tm', displayName: 'TIPO MEDIDA', minWidth: 100,width:120},
        { field: 'denominacion', name:'denominacion', displayName: 'MEDIDA', minWidth: 100},
        { field: 'cantidad_fotos', name:'cantidad_fotos', displayName: 'FOTOS', minWidth: 100, width:60 },
        { field: 'estado', type: 'object', name: 'estado', displayName: 'ESTADO', maxWidth: 100,width:80, enableFiltering: false,
          cellTemplate:'<div class=" ml-md mt-xs onoffswitch green inline-block medium">'+
                  '<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="switch{{ COL_FIELD.id }}" ng-checked="{{ COL_FIELD.bool }}" ng-click="grid.appScope.btnHabilitarDeshabilitar(row)">'+
                  '<label class="onoffswitch-label" for="switch{{ COL_FIELD.id }}">'+
                    '<span class="onoffswitch-inner"></span><span class="onoffswitch-switch"></span>'+
                  '</label></div>' },
        // { field: 'imagen', name: 'imagen', displayName: 'IMAGEN',width: 120, enableFiltering: false, enableSorting: false, cellTemplate:'<img style="height:inherit;" class="center-block" ng-src="{{ grid.appScope.dirImagesProducto + COL_FIELD }}" /> </div>' },



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

    // MANTENIMIENTO
      vm.btnNuevo = function(){
        var modalInstance = $uibModal.open({
          templateUrl: 'app/pages/medida/medida_formview.php',
          controllerAs: 'mp',
          size: 'lg',
          backdropClass: 'splash splash-2 splash-ef-16',
          windowClass: 'splash splash-2 splash-ef-16',
          controller: function($scope, $uibModalInstance, arrToModal ){
            var vm = this;
            vm.fData = {};
            vm.modoEdicion = false;
            vm.getPaginationServerSide = arrToModal.getPaginationServerSide;
            vm.modalTitle = 'Registro de medidas';

            // vm.listaTipoMedida = arrToModal.scope.listaTipoMedida;
            // vm.fData.tipo_medida = vm.listaTipoMedida[0];

            vm.aceptar = function () {
              // if(angular.isUndefined($scope.image)){
              //   alert('Debe seleccionar una imagen');
              //   return false;
              // }
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
                  alert('Ocurrió un error');
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
          templateUrl: 'app/pages/producto/producto_formview.php',
          controllerAs: 'mp',
          size: 'lg',
          backdropClass: 'splash splash-2 splash-ef-16',
          windowClass: 'splash splash-2 splash-ef-16',
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
            vm.modalTitle = 'Edición de producto';
            vm.fData.canvas = false;
            vm.fData.canvas_bas = false;
            vm.fData.canvas_pre = false;

            console.log('vm.fData',vm.fData);

            vm.rutaImagen = arrToModal.scope.dirImagesProducto;


            vm.aceptar = function () {
              if(vm.fData.canvas){
                if(angular.isUndefined($scope.image)){
                  alert('Debe seleccionar una imagen');
                  return false;
                }
                vm.fData.imagen = $scope.image;
                vm.fData.nombre_imagen = $scope.file.name;
              }

              if(vm.fData.canvas_bas){
                if(angular.isUndefined(vm.image2)){
                  alert('Debe seleccionar una imagen para Básico');
                  return false;
                }
                vm.fData.imagen_bas = vm.image2;
                vm.fData.nombre_imagen_bas = vm.file2;
              }
              if(vm.fData.canvas_pre){
                if(angular.isUndefined(vm.image3)){
                  alert('Debe seleccionar una imagen para Premium');
                  return false;
                }
                vm.fData.imagen_pre = vm.image3;
                vm.fData.nombre_imagen_pre = vm.file3;
              }
              pageLoading.start('Procesando...');
              ProductoServices.sEditarProducto(vm.fData).then(function (rpta) {
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

  }
  function MedidaServices($http, $q) {
    return({
      sListarMedida: sListarMedida,
      sRegistrarMedida: sRegistrarMedida,

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

  }
})();