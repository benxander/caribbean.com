(function() {
  'use strict';
  angular
    .module('minotaur')
    .controller('EmailController', EmailController)
    .service('EmailServices', EmailServices);

  /** @ngInject */
  function EmailController($scope, $uibModal, uiGridConstants, toastr, alertify,
    EmailServices,IdiomaServices) {
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
        { field: 'idemail', name:'idemail', displayName: 'ID', width:90,visble:false },
        { field: 'titulo', name:'titulo', displayName: 'TIPO EMAIL ', sort: { direction: uiGridConstants.ASC} },
        { field: 'idioma', name: 'idioma', displayName: 'IDIOMA', width:80},
        { field: 'asunto', name: 'asunto', displayName: 'ASUNTO'},
        { field: 'contenido', name: 'contenido', displayName: 'CONTENIDO'},
        { field: 'accion', name:'accion', displayName: 'ACCION', width: 80, enableFiltering: false,
          cellTemplate: '<div class="text-right">' +
          '<button class="btn btn-default btn-sm text-green btn-action" ng-click="grid.appScope.btnEditar(row)" tooltip-placement="left" uib-tooltip="EDITAR" > <i class="icon-pencil"></i> </button>' +
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

      // IDIOMA
      IdiomaServices.sListarIdiomaCbo().then(function (rpta) {
        vm.listaIdiomas = rpta.datos;
        vm.listaIdiomas.splice(0,0,{ id : '', nombre:'--Seleccione una opción--'});
      });
      // TIPOS EMAIL
      EmailServices.sListarTipoEmailCbo().then(function (rpta) {
        vm.listaTiposEmail = rpta.datos;
        vm.listaTiposEmail.splice(0,0,{ id : '', descripcion:'--Seleccione una opción--'});
      });

      // MANTENIMIENTO
      vm.btnNuevo = function(){
        var modalInstance = $uibModal.open({
          templateUrl: 'app/pages/email/email_formview.php',
          controllerAs: 'me',
          size: 'lg',
          backdropClass: 'splash splash-2 splash-ef-16',
          windowClass: 'splash splash-2 splash-ef-16',
          backdrop: 'static',
          keyboard:false,
          controller: function($scope, $uibModalInstance, arrToModal ){
            var vm = this;
            vm.fData = {};

            vm.getPaginationServerSide = arrToModal.getPaginationServerSide;
            vm.modalTitle = 'Nuevo Email';
            vm.listaIdiomas = arrToModal.scope.listaIdiomas;
            vm.listaTiposEmail = arrToModal.scope.listaTiposEmail;

            vm.fData.idioma = vm.listaIdiomas[0];
            vm.fData.tipoEmail = vm.listaTiposEmail[0];

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
      vm.btnEditar = function(row){
        var modalInstance = $uibModal.open({
          templateUrl: 'app/pages/email/email_formview.php',
          controllerAs: 'me',
          size: 'lg',
          backdropClass: 'splash splash-2 splash-ef-16',
          windowClass: 'splash splash-2 splash-ef-16',
          backdrop: 'static',
          keyboard:false,
          controller: function($scope, $uibModalInstance, arrToModal ){
            var vm = this;
            vm.fData = {};
            vm.fData = angular.copy(arrToModal.seleccion);
            vm.getPaginationServerSide = arrToModal.getPaginationServerSide;
            vm.modalTitle = 'Editar Email';
            vm.listaIdiomas = arrToModal.scope.listaIdiomas;
            vm.listaTiposEmail = arrToModal.scope.listaTiposEmail;
            vm.fData.idioma = vm.listaIdiomas.filter(function(obj) {
              return obj.ididioma == vm.fData.ididioma;
            }).shift();
            // vm.fData.idioma = objIndex;

            vm.fData.tipoEmail = vm.listaTiposEmail.filter(function(obj) {
              return obj.id == vm.fData.idemail;
            }).shift();


            vm.aceptar = function () {
              EmailServices.sEditarEmail(vm.fData).then(function (rpta) {
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




  }

  function EmailServices($http, $q) {
    return({
        sListarEmail: sListarEmail,
        sRegistrarEmail: sRegistrarEmail,
        sEditarEmail: sEditarEmail,
        sListarTipoEmailCbo:sListarTipoEmailCbo,
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
    function sListarTipoEmailCbo(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Email/listar_tipo_email_cbo",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
  }

})();