(function() {
  'use strict';
  angular
    .module('minotaur')
    .controller('DescuentoController', DescuentoController)
    .service('DescuentoServices', DescuentoServices);

  /** @ngInject */
  function DescuentoController($scope, $uibModal, uiGridConstants, toastr, alertify,
    DescuentoServices) {
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
        { field: 'iddescuento', name:'iddescuento', displayName: 'ID', enableCellEdit: false, width:90, sort: { direction: uiGridConstants.ASC} },
        { field: 'dias', name:'dias', displayName: 'DIAS DESDE SALIDA',cellClass:'ui-editCell' },
        { field: 'descuento', name: 'descuento', displayName: 'DESCUENTO (%)',cellClass:'ui-editCell'},


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
          DescuentoServices.sEditarDescuento(rowEntity).then(function (rpta) {
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
        DescuentoServices.sListarDescuento(vm.datosGrid).then(function (rpta) {
          vm.gridOptions.data = rpta.datos;
          vm.gridOptions.totalItems = rpta.paginate.totalRows;
          vm.mySelectionGrid = [];
        });
      }
      vm.getPaginationServerSide();


      // MANTENIMIENTO
      vm.btnNuevo = function(){
        var modalInstance = $uibModal.open({
          templateUrl: 'app/pages/descuento/descuento_formview.php',
          controllerAs: 'md',
          size: '',
          backdropClass: 'splash splash-2 splash-ef-16',
          windowClass: 'splash splash-2 splash-ef-16',
          controller: function($scope, $uibModalInstance, arrToModal ){
            var vm = this;
            vm.fData = {};
            vm.fData = angular.copy(arrToModal.seleccion);
            vm.modoEdicion = true;
            vm.getPaginationServerSide = arrToModal.getPaginationServerSide;
            vm.modalTitle = 'Nuevo descuento';
            vm.listaIdiomas = arrToModal.scope.listaIdiomas;
            vm.listaGrupos = arrToModal.scope.listaGrupos;

            vm.generarPassword = function (longitud) {
              console.log("entro2");
              var caracteres = "abcdefghijkmnpqrtuvwxyzABCDEFGHIJKLMNPQRTUVWXYZ0123456789";
              var pass = "";
              for (i=0; i<longitud; i++){
                pass += caracteres.charAt(Math.floor(Math.random()*caracteres.length));
              }
              vm.fData.password = pass;
              console.log(vm.fData.password);
            }

            vm.generar = function () {

              if(vm.fData.newpassword){
                console.log("entro1");
                vm.generarPassword(5);
              }else{
                vm.fData.password = null;
              }

              console.log(vm.fData);
            }

            vm.aceptar = function () {
              DescuentoServices.sEditarUsuario(vm.fData).then(function (rpta) {
                if(rpta.flag == 1){
                  $uibModalInstance.dismiss('cancel');
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
            DescuentoServices.sAnularUsuario(row.entity).then(function (rpta) {
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
          },
          function(ev){
            ev.preventDefault();
        });
      }

      vm.btnHabilitarDeshabilitar = function (row) {
        DescuentoServices.sHabilitarDesabilitarUsuario(row.entity).then(function (rpta) {
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

      vm.enviarCorreo = function () {

          if(vm.mySelectionGrid.length == 0){
            toastr.warning('Seleccione un usuario', 'warning');
            return null;
          }

          DescuentoServices.sEnviarMailRegistro(vm.mySelectionGrid[0]).then(function(rpta){
            if(rpta.flag == 1){
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

  function DescuentoServices($http, $q) {
    return({
        sListarDescuento: sListarDescuento,
        // sRegistrarDescuento: sRegistrarDescuento,
        sEditarDescuento: sEditarDescuento,
    });
    function sListarDescuento(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Descuento/listar_descuentos",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    // function sRegistrarDescuento(pDatos) {
    //   var datos = pDatos || {};
    //   var request = $http({
    //         method : "post",
    //         url :  angular.patchURLCI + "Descuento/registrar_Descuento",
    //         data : datos
    //   });
    //   return (request.then( handleSuccess,handleError ));
    // }
    function sEditarDescuento(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Descuento/editar_descuento",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    // function sAnularDescuento(pDatos) {
    //   var datos = pDatos || {};
    //   var request = $http({
    //         method : "post",
    //         url :  angular.patchURLCI + "Descuento/anular_Descuento",
    //         data : datos
    //   });
    //   return (request.then( handleSuccess,handleError ));
    // }
  }

})();