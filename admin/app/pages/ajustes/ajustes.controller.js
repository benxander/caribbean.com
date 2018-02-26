(function() {
  'use strict';
  angular
    .module('minotaur')
    .controller('AjustesController', AjustesController)
    .service('AjustesServices', AjustesServices);

  /** @ngInject */
  function AjustesController($scope, $uibModal, uiGridConstants, toastr, alertify,
    AjustesServices) {
    var vm = this;
    var openedToasts = [];

    // GRILLA PRINCIPAL
      var paginationOptions = {
        pageNumber: 1,
        firstRow: 0,
        pageSize: 10,
        sort: uiGridConstants.ASC,
        sortName: null,
        search: null
      };

      vm.mySelectionGrid = [];
      vm.gridOptions = {
        paginationPageSizes: [10, 50, 100, 500, 1000],
        paginationPageSize: 10,
        enableFiltering: false,
        enableSorting: true,
        useExternalPagination: true,
        useExternalSorting: true,
        useExternalFiltering : true,
        enableRowSelection: true,
        enableRowHeaderSelection: true,
        enableFullRowSelection: false,
        multiSelect: false,
        enableCellEditOnFocus: true,
        appScopeProvider: vm
      }
      vm.gridOptions.columnDefs = [
        { field: 'idajuste', name:'idajuste', displayName: 'ID', enableCellEdit: false, width:90, sort: { direction: uiGridConstants.ASC} },
        { field: 'dias', name:'dias', displayName: 'DIAS ANTES DE ELIMINAR',cellClass:'ui-editCell',
          editableCellTemplate: '<div><form name="inputForm"><input type="number" ng-class="\'colt\' + col.uid" ui-grid-editor ng-model="MODEL_COL_FIELD"></form></div>' },



      ];
      vm.gridOptions.onRegisterApi = function(gridApi) {
        vm.gridApi = gridApi;
        gridApi.edit.on.afterCellEdit($scope,function (rowEntity, colDef, newValue, oldValue){
          rowEntity.column = colDef.field;
          if(rowEntity.column == 'dias'){
            if( !(rowEntity.dias > 0) ){
              var title = 'Advertencia!';
              var pType = 'warning';
              rowEntity.dias = oldValue;
              toastr.warning('Los días deben ser mayor a 0', title);
              return false;
            }
          }
          AjustesServices.sEditarAjuste(rowEntity).then(function (rpta) {
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
          $scope.$apply();
        });
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

      }

      paginationOptions.sortName = vm.gridOptions.columnDefs[0].name;
      vm.getPaginationServerSide = function() {
        vm.datosGrid = {
          paginate : paginationOptions
        };
        AjustesServices.sListarAjustes(vm.datosGrid).then(function (rpta) {
          vm.gridOptions.data = rpta.datos;
          vm.gridOptions.totalItems = rpta.paginate.totalRows;
          vm.mySelectionGrid = [];
        });
      }
      vm.getPaginationServerSide();


      // MANTENIMIENTO





  }

  function AjustesServices($http, $q) {
    return({
        sListarAjustes: sListarAjustes,
        sEditarAjuste: sEditarAjuste,
    });
    function sListarAjustes(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Ajustes/listar_ajustes",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sEditarAjuste(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Ajustes/editar_ajuste",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }

  }

})();