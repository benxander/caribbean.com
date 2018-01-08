(function() {
  'use strict';
  angular
    .module('minotaur')
    .controller('PedidoController', PedidoController)
    .service('PedidoServices', PedidoServices);

  /** @ngInject */
  function PedidoController($scope,$uibModal,PedidoServices,toastr,alertify, pageLoading, uiGridConstants) {
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
        { field: 'iddetalle', name:'iddetalle', displayName: 'ID', minWidth: 50, width:80, visible:true, sort: { direction: uiGridConstants.DESC} },
        { field: 'codigo', name:'codigo', displayName: 'CLIENTE', minWidth: 100, width:80 },
        { field: 'producto', name:'descripcion_pm', displayName: 'PRODUCTO', minWidth: 100 },
        { field: 'categoria', name:'categoria', displayName: 'CATEGORIA', minWidth: 100, width:100 },
        { field: 'color', name:'color', displayName: 'COLOR', minWidth: 100 },
        { field: 'cantidad', name:'cantidad', displayName: 'CANTIDAD', minWidth: 100, width:100 },
        { field: 'total_detalle', name:'total_detalle', displayName: 'TOTAL DETALLE', minWidth: 100, width:100 },
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
        PedidoServices.sListarPedido(vm.datosGrid).then(function (rpta) {
          vm.gridOptions.data = rpta.datos;
          vm.gridOptions.totalItems = rpta.paginate.totalRows;
          vm.mySelectionGrid = [];
        });
      }
      vm.getPaginationServerSide();
      // vm.fBusqueda = {}


  }
  function PedidoServices($http, $q) {
    return({
      sListarPedido: sListarPedido,

    });
    function sListarPedido(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Movimiento/listar_pedidos",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }

  }
})();