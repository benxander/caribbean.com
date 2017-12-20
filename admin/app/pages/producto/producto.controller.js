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
          '<button class="btn btn-default btn-sm text-blue btn-action" ng-click="grid.appScope.verPrecios(row)" tooltip-placement="left" uib-tooltip="PRECIOS" > <i class="icon-grid"></i> </button>' +

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
      vm.fBusqueda = {}
      // COLORES
      ProductoServices.sListarColoresCbo().then(function (rpta) {
        vm.listaColores = angular.copy(rpta.datos);
        vm.listaColores.splice(0,0,{ id : '', descripcion:''});
        vm.listaColoresFiltro = angular.copy(rpta.datos);
        vm.fBusqueda.filtroColores = vm.listaColoresFiltro[0];
        vm.getPaginationServerSide(true);
      });
      // TIPO MEDIDA
        ProductoServices.sListarTipoMedidaCbo().then(function (rpta) {
          vm.listaTipoMedida = angular.copy(rpta.datos);
          vm.listaTipoMedida.splice(0,0,{ id : '', descripcion:'Seleccione una opción'});


        });
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
            vm.listaTipoMedida = arrToModal.scope.listaTipoMedida;
            vm.fData.tipo_medida = vm.listaTipoMedida[0];
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
            vm.listaTipoMedida = arrToModal.scope.listaTipoMedida;

            vm.fData.tipo_medida = vm.listaTipoMedida.filter(function(obj) {
              return obj.id == vm.fData.idtipomedida;
            }).shift();
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
            vm.listaColores = arrToModal.scope.listaColores;
            vm.modalTitle = 'Precio por Tamaños';
            // vm.fData.canvas = false;
            // vm.rutaImagen = arrToModal.scope.dirImagesBlog;
            // GRILLA BASICO
              vm.gridOptions = {
                enableFullRowSelection: false,
                multiSelect: false,
                appScopeProvider: vm
              }
              vm.gridOptions.columnDefs = [
                { field: 'medida', displayName: 'TAMAÑO', minWidth: 80,},
                { field: 'precio_unitario',displayName: 'PRECIO', minWidth: 60,width:90,enableCellEdit: true,cellClass:'ui-editCell'},
                { field: 'precio_2_5',displayName: 'DE 2 A 5', minWidth: 60,width:90,cellClass:'ui-editCell'},
                { field: 'precio_mas_5',displayName: 'DE 6 A MAS', minWidth: 60,width:90,cellClass:'ui-editCell'},

              ];
              vm.gridOptions.onRegisterApi = function(gridApi) {
                vm.gridApi = gridApi;

              }
                // paginationOptions.sortName = vm.gridOptions.columnDefs[0].name;
              vm.getPaginationServerSide = function() {
                vm.fData.categoria = '1';
                ProductoServices.sListarProductoPrecios(vm.fData).then(function (rpta) {
                  vm.gridOptions.data = rpta.datos;
                  // vm.gridOptions.totalItems = rpta.paginate.totalRows;
                  // vm.mySelectionGrid = [];
                });
              }
              vm.getPaginationServerSide();
            // GRILLA PREMIUM
              vm.gridOptionsPremium = {
                enableFullRowSelection: false,
                multiSelect: false,
                appScopeProvider: vm
              }
              vm.gridOptionsPremium.columnDefs = [
                { field: 'medida', displayName: 'TAMAÑO', minWidth: 80,},
                { field: 'precio_unitario',displayName: 'PRECIO', minWidth: 60,width:90,enableCellEdit: true,cellClass:'ui-editCell'},
                { field: 'precio_2_5',displayName: 'DE 2 A 5', minWidth: 60,width:90,cellClass:'ui-editCell'},
                { field: 'precio_mas_5',displayName: 'DE 6 A MAS', minWidth: 60,width:90,cellClass:'ui-editCell'},

              ];
              vm.gridOptionsPremium.onRegisterApi = function(gridApi) {
                vm.gridApi = gridApi;

              }
                // paginationOptions.sortName = vm.gridOptionsPremium.columnDefs[0].name;
              vm.getPaginationServerSidePremium = function() {
                vm.fData.categoria = '1';
                ProductoServices.sListarProductoPrecios(vm.fData).then(function (rpta) {
                  vm.gridOptionsPremium.data = rpta.datos;
                  // vm.gridOptionsPremium.totalItems = rpta.paginate.totalRows;
                  // vm.mySelectionGrid = [];
                });
              }
              vm.getPaginationServerSidePremium();

            vm.aceptar = function () {
              ProductoServices.sRegistrarProductoPrecios(vm.gridOptions.data).then(function (rpta) {
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
      sListarTipoMedidaCbo: sListarTipoMedidaCbo,
      sListarProductos: sListarProductos,
      sRegistrarProducto: sRegistrarProducto,
      sEditarProducto: sEditarProducto,
      sListarProductoPrecios: sListarProductoPrecios,
      sEditarPaquete: sEditarPaquete,
      sRegistrarPaquetes: sRegistrarPaquetes,
      sAnularProducto: sAnularProducto,
      sHabilitarDeshabilitarProducto: sHabilitarDeshabilitarProducto,
      sListarColoresCbo: sListarColoresCbo,
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
    function sListarTipoMedidaCbo(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Producto/listar_tipo_medida_cbo",
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
    function sListarColoresCbo(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Producto/listar_colores_cbo",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
  }
})();