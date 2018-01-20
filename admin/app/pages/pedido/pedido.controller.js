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
        { field: 'accion', name:'accion', displayName: '', width: 140, enableFiltering: false,
          cellTemplate: '<div class="text-center">' +

          '<button class="btn btn-default btn-sm text-green btn-action" ng-click="grid.appScope.verDetalle(row)" tooltip-placement="left" uib-tooltip="Ver detalle" > <i class="fa fa-eye"></i> </button>'+

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
        PedidoServices.sListarPedido(vm.datosGrid).then(function (rpta) {
          vm.gridOptions.data = rpta.datos;
          vm.gridOptions.totalItems = rpta.paginate.totalRows;
          vm.mySelectionGrid = [];
        });
      }
      vm.getPaginationServerSide();
      // vm.fBusqueda = {}

    vm.verDetalle = function(row){
      console.log('det');
      var modalInstance = $uibModal.open({
        templateUrl: 'app/pages/pedido/detalle_pedido_view.php',
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
          vm.dirImagesProducto = $scope.dirImages + "producto/";
          vm.modoEdicion = false;
          vm.getPaginationServerSide = arrToModal.getPaginationServerSide;
          vm.modalTitle = 'Detalle de pedido';
          vm.fData = row.entity;
          console.log('vm.fData',vm.fData);
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