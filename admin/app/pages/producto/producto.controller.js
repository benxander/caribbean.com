(function() {
  'use strict';
  angular
    .module('minotaur')
    .controller('ProductoController', ProductoController)
    .service('ProductoServices', ProductoServices);

  /** @ngInject */
  function ProductoController($scope,$uibModal,ProductoServices,toastr,alertify, uiGridConstants) {
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
      vm.dirImagesProducto = $scope.dirImages + "producto/";
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
        { field: 'idproductomaster', name:'idproductomaster', displayName: 'ID', minWidth: 50, width:80, visible:true, sort: { direction: uiGridConstants.DESC} },
        { field: 'descripcion_pm', name:'descripcion_pm', displayName: 'PRODUCTO', minWidth: 100 },
        { field: 'imagen', name: 'imagen', displayName: 'IMAGEN',width: 120, enableFiltering: false, enableSorting: false, cellTemplate:'<img style="height:inherit;" class="center-block" ng-src="{{ grid.appScope.dirImagesProducto + COL_FIELD }}" /> </div>' },
        { field: 'estado', type: 'object', name: 'estado', displayName: 'ESTADO', maxWidth: 100, enableFiltering: false,
          cellTemplate:'<div class=" ml-md mt-xs onoffswitch green inline-block medium">'+
                  '<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="switch{{ COL_FIELD.id }}" ng-checked="{{ COL_FIELD.bool }}" ng-click="grid.appScope.btnHabilitarDeshabilitar(row)">'+
                  '<label class="onoffswitch-label" for="switch{{ COL_FIELD.id }}">'+
                    '<span class="onoffswitch-inner"></span><span class="onoffswitch-switch"></span>'+
                  '</label></div>' },
        { field: 'accion', name:'accion', displayName: 'ACCION', width: 140, enableFiltering: false,
          cellTemplate: '<div class="text-center">' +
          // '<button class="btn btn-default btn-sm text-blue btn-action" ng-click="grid.appScope.verPrecios(row)" tooltip-placement="left" uib-tooltip="PRECIOS" > <i class="icon-grid"></i> </button>' +

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
            'idproducto' : grid.columns[1].filters[0].term,
            'descripcion' : grid.columns[2].filters[0].term,
          }
          vm.getPaginationServerSide();
        });
      }

      paginationOptions.sortName = vm.gridOptions.columnDefs[0].name;
      vm.getPaginationServerSide = function() {
        vm.datosGrid = {
          paginate : paginationOptions
        };
        ProductoServices.sListarProductos(vm.datosGrid).then(function (rpta) {
          vm.gridOptions.data = rpta.datos;
          vm.gridOptions.totalItems = rpta.paginate.totalRows;
          vm.mySelectionGrid = [];
        });
      }
      vm.getPaginationServerSide();

    // MANTENIMIENTO
      vm.btnNuevo = function(){
        var modalInstance = $uibModal.open({
          templateUrl: 'app/pages/producto/producto_formview.php',
          controllerAs: 'mp',
          size: '',
          backdropClass: 'splash splash-2 splash-ef-16',
          windowClass: 'splash splash-2 splash-ef-16',
          controller: function($scope, $uibModalInstance, arrToModal ){
            var vm = this;
            vm.fData = {};
            vm.modoEdicion = false;
            vm.getPaginationServerSide = arrToModal.getPaginationServerSide;
            vm.modalTitle = 'Registro de producto';
            vm.fData.canvas = true;
            vm.fData.si_genero = '2';
            vm.fData.si_color = '2';

            // vm.rutaImagen = arrToModal.scope.dirImagesProducto + vm.fData.tipo_banner +'/';

            vm.aceptar = function () {
              if(angular.isUndefined($scope.image)){
                alert('Debe seleccionar una imagen');
                return false;
              }
              vm.fData.imagen = $scope.image;
              vm.fData.nombre_imagen = $scope.file.name;

              ProductoServices.sRegistrarProducto(vm.fData).then(function (rpta) {
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
          size: '',
          backdropClass: 'splash splash-2 splash-ef-16',
          windowClass: 'splash splash-2 splash-ef-16',
          controller: function($scope, $uibModalInstance, arrToModal ){
            var vm = this;
            vm.fData = {};
            vm.fData = angular.copy(arrToModal.seleccion);
            vm.modoEdicion = true;
            vm.getPaginationServerSide = arrToModal.getPaginationServerSide;
            vm.modalTitle = 'Edición de producto';
            vm.fData.canvas = false;

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

              ProductoServices.sEditarProducto(vm.fData).then(function (rpta) {
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
      vm.verPrecios = function(row){
        var modalInstance = $uibModal.open({
          templateUrl: 'app/pages/producto/precios_formview.php',
          controllerAs: 'mp',
          size: 'lg',
          backdropClass: 'splash splash-2 splash-ef-16',
          windowClass: 'splash splash-2 splash-ef-16',
          controller: function($scope, $uibModalInstance, arrToModal ){
            var vm = this;
            vm.fData = {};
            vm.fData = angular.copy(arrToModal.seleccion);
            vm.fData.temporal = {};
            vm.modoEdicion = true;
            vm.getPaginationServerSide = arrToModal.getPaginationServerSide;
            vm.modalTitle = 'Precio por Tamaños';
            // vm.fData.canvas = false;
            // vm.rutaImagen = arrToModal.scope.dirImagesBlog;
            // GRILLA PAQUETES
              vm.gridOptions = {
                enableFullRowSelection: false,
                multiSelect: false,
                appScopeProvider: vm
              }
              vm.gridOptions.columnDefs = [
                { field: 'titulo_pq',displayName: 'TITULO', minWidth: 80,},
                { field: 'porc_cantidad',displayName: 'CANT %', minWidth: 60,width:90,cellClass:'ui-editCell'},
                { field: 'cantidad',displayName: 'CANT.', minWidth: 60,width:90,enableCellEdit: false},
                { field: 'porc_monto',displayName: 'MONTO %', minWidth: 60,width:90,cellClass:'ui-editCell'},
                { field: 'monto',displayName: 'MONTO $', minWidth: 60,width:90,enableCellEdit: false },

              ];
              vm.gridOptions.onRegisterApi = function(gridApi) {
                vm.gridApi = gridApi;
                gridApi.edit.on.afterCellEdit($scope,function (rowEntity, colDef, newValue, oldValue){
                  rowEntity.column = colDef.field;
                  if(rowEntity.column == 'porc_cantidad'){
                    if( !(rowEntity.porc_cantidad > 0 && rowEntity.porc_cantidad < 100) ){
                      var title = 'Advertencia!';
                      var pType = 'warning';
                      rowEntity.porc_cantidad = oldValue;
                      toastr.warning('El porcentaje debe ser numero mayor a cero', title);
                      return false;
                    }
                    rowEntity.cantidad = Math.ceil(rowEntity.porc_cantidad*vm.fData.cantidad_fotos/100);
                  }
                  else if(rowEntity.column == 'porc_monto'){
                    if( !(rowEntity.porc_monto > 0 && rowEntity.porc_monto < 100) ){
                      var title = 'Advertencia!';
                      var pType = 'warning';
                      rowEntity.porc_monto = oldValue;
                      toastr.warning('El porcentaje debe ser numero mayor a cero', title);
                      return false;
                    }
                    rowEntity.monto = Math.ceil(rowEntity.porc_monto*vm.fData.monto_total/100);
                  }
                  if(!rowEntity.es_nuevo){
                    ProductoServices.sEditarPaquete(rowEntity).then(function (rpta) {
                      if(rpta.flag == 1){
                        vm.getPaginationServerSide();
                        var title = 'OK';
                        var type = 'success';
                        toastr.success(rpta.message, title);
                      }else if( rpta.flag == 0 ){
                        var title = 'Advertencia';
                        var type = 'warning';
                        toastr.warning(rpta.message, title);
                      }else{
                        alert('Ocurrió un error');
                      }
                    });
                  }
                  $scope.$apply();
                });
              }
                // paginationOptions.sortName = vm.gridOptions.columnDefs[0].name;
              vm.getPaginationServerSide = function() {
                ProductoServices.sListarProductoPrecios(vm.fData).then(function (rpta) {
                  vm.gridOptions.data = rpta.datos;
                  // vm.gridOptions.totalItems = rpta.paginate.totalRows;
                  // vm.mySelectionGrid = [];
                });
              }
              vm.getPaginationServerSide();

            vm.calcularCantidad = function(){
              if( vm.fData.cantidad_fotos > 0 ){
                vm.fData.temporal.cantidad = Math.ceil(vm.fData.temporal.porc_cantidad*vm.fData.cantidad_fotos/100);
              }
            }
            vm.calcularMonto = function(){
              if( vm.fData.monto_total > 0 ){
                vm.fData.temporal.monto = Math.ceil(vm.fData.temporal.porc_monto*vm.fData.monto_total/100);
              }
            }
            vm.agregarItem = function(){
              if( !vm.fData.temporal.titulo_pq ){
                var title = 'Advertencia';
                openedToasts.push(toastr['warning']('Agregue un título', title));
                return false;
              }
              if( !vm.fData.temporal.cantidad ){
                var title = 'Advertencia';
                openedToasts.push(toastr['warning']('La cantidad no puede ser nula', title));
                return false;
              }
              if( !vm.fData.temporal.monto ){
                var title = 'Advertencia';
                openedToasts.push(toastr['warning']('El monto no puede ser nulo', title));
                return false;
              }
              vm.arrTemporal = {
                'idactividad' : vm.fData.idactividad,
                'titulo_pq' : vm.fData.temporal.titulo_pq,
                'porc_cantidad' : vm.fData.temporal.porc_cantidad,
                'cantidad' : vm.fData.temporal.cantidad,
                'porc_monto' : vm.fData.temporal.porc_monto,
                'monto' : vm.fData.temporal.monto,
                'es_nuevo' : true

              };
              vm.gridOptions.data.push(vm.arrTemporal);
              vm.fData.temporal = {}
              vm.fData.temporal.porc_cantidad = 0;
              vm.fData.temporal.porc_monto = 0;
              $("#titulo").focus();
            }
            vm.aceptar = function () {
              ProductoServices.sRegistrarPaquetes(vm.gridOptions.data).then(function (rpta) {
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
            ProductoServices.sAnularProducto(row.entity).then(function (rpta) {
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
      vm.btnHabilitarDeshabilitar = function (row) {
        ProductoServices.sHabilitarDeshabilitarProducto(row.entity).then(function (rpta) {
          if(rpta.flag == 1){
            vm.getPaginationServerSide();
            var title = 'OK';
            var type = 'success';
            toastr.success(rpta.message, title);
          }else if( rpta.flag == 0 ){
            var title = 'Advertencia';
            var type = 'warning';
            toastr.warning(rpta.message, title);
          }else{
            alert('Ocurrió un error');
          }
        });
      }
  }
  function ProductoServices($http, $q) {
    return({
      sListarProductoCbo: sListarProductoCbo,
      sListarProductos: sListarProductos,
      sRegistrarProducto: sRegistrarProducto,
      sEditarProducto: sEditarProducto,
      sListarProductoPrecios: sListarProductoPrecios,
      sEditarPaquete: sEditarPaquete,
      sRegistrarPaquetes: sRegistrarPaquetes,
      sAnularProducto: sAnularProducto,
      sHabilitarDeshabilitarProducto: sHabilitarDeshabilitarProducto,
    });
    function sListarProductoCbo(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Producto/listar_producto_cbo",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sListarProductos(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Producto/listar_productos",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sRegistrarProducto(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Producto/registrar_producto",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sEditarProducto(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Producto/editar_producto",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sListarProductoPrecios(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Producto/listar_producto_precios",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sEditarPaquete(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Producto/editar_paquete",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sRegistrarPaquetes(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Producto/registrar_paquetes",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sAnularProducto(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Producto/anular_producto",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sHabilitarDeshabilitarProducto(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Producto/habilitar_deshabilitar_producto",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
  }
})();