(function() {
  'use strict';
  angular
    .module('minotaur')
    .controller('EmailController', EmailController)
    .service('EmailServices', EmailServices);

  /** @ngInject */
  function EmailController($scope, $uibModal, uiGridConstants, toastr, alertify,
    EmailServices) {
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
        { field: 'idemail', name:'idemail', displayName: 'ID', enableCellEdit: false, width:90, sort: { direction: uiGridConstants.ASC} },
        { field: 'titulo', name:'titulo', displayName: 'TITULO ',cellClass:'ui-editCell' },
        { field: 'contenido', name: 'contenido', displayName: 'CONTENIDO'},


      ];
      vm.gridOptions.onRegisterApi = function(gridApi) {
        vm.gridApi = gridApi;
        gridApi.edit.on.afterCellEdit($scope,function (rowEntity, colDef, newValue, oldValue){
          rowEntity.column = colDef.field;
          if(rowEntity.column == 'titulo'){
            if( !(rowEntity.titulo > 0) ){
              var title = 'Advertencia!';
              var pType = 'warning';
              rowEntity.titulo = oldValue;
              toastr.warning('Ocurrió un error', title);
              return false;
            }
          }
          EmailServices.sEditarEmail(rowEntity).then(function (rpta) {
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
        EmailServices.sListarEmail(vm.datosGrid).then(function (rpta) {
          if(rpta.flag == 1){
            vm.gridOptions.data = rpta.datos;
            vm.gridOptions.totalItems = rpta.paginate.totalRows;

          }
          vm.mySelectionGrid = [];
        });
      }
      vm.getPaginationServerSide();


      // MANTENIMIENTO
      vm.btnNuevo = function(){
        var modalInstance = $uibModal.open({
          templateUrl: 'app/pages/email/email_formview.php',
          controllerAs: 'me',
          size: 'lg',
          backdropClass: 'splash splash-2 splash-ef-16',
          windowClass: 'splash splash-2 splash-ef-16',
          controller: function($scope, $uibModalInstance, arrToModal ){
            var vm = this;
            vm.fData = {};

            vm.getPaginationServerSide = arrToModal.getPaginationServerSide;
            vm.modalTitle = 'Nuevo Email';
            vm.listaIdiomas = arrToModal.scope.listaIdiomas;
            vm.listaGrupos = arrToModal.scope.listaGrupos;

            vm.aceptar = function () {
              EmailServices.sRegistrarEmail(vm.fData).then(function (rpta) {
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
                scope : vm,
              }
            }
          }
        });
      }
      vm.btnAnular = function(row){
        alertify.confirm("¿Realmente desea realizar la acción?",function(ev){
            ev.preventDefault();
            EmailServices.sAnularEmail(row.entity).then(function (rpta) {
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
        EmailServices.sHabilitarDesabilitarUsuario(row.entity).then(function (rpta) {
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

          EmailServices.sEnviarMailRegistro(vm.mySelectionGrid[0]).then(function(rpta){
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

  function EmailServices($http, $q) {
    return({
        sListarEmail: sListarEmail,
        sRegistrarEmail: sRegistrarEmail,
        sEditarEmail: sEditarEmail,
    });
    function sListarEmail(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Email/listar_emails",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sRegistrarEmail(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Email/registrar_email",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sEditarEmail(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Email/editar_email",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    // function sAnularEmail(pDatos) {
    //   var datos = pDatos || {};
    //   var request = $http({
    //         method : "post",
    //         url :  angular.patchURLCI + "Email/anular_Email",
    //         data : datos
    //   });
    //   return (request.then( handleSuccess,handleError ));
    // }
  }

})();