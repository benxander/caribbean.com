(function() {
  'use strict';
  angular
    .module('minotaur')
    .controller('BlogController', BlogController)
    .service('BlogServices', BlogServices);

  /** @ngInject */
  function BlogController($scope,$uibModal,BlogServices,toastr,alertify, uiGridConstants) {
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
      vm.dirImagesBlog = $scope.dirImages + "blog/";
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
        { field: 'idblog', name:'idblog', displayName: 'ID', minWidth: 50, width:80, visible:false, sort: { direction: uiGridConstants.DESC} },
        { field: 'titulo', name:'titulo', displayName: 'TITULO', minWidth: 100 },
        { field: 'descripcion', name:'descripcion', displayName: 'DESCRIPCION', minWidth: 100 },

        { field: 'accion', name:'accion', displayName: 'ACCION', width: 80, enableFiltering: false,
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
            'idblog' : grid.columns[1].filters[0].term,
            'bl.titulo' : grid.columns[2].filters[0].term,
            'bl.descripcion' : grid.columns[3].filters[0].term,
            'bl.autor' : grid.columns[3].filters[0].term,
          }
          vm.getPaginationServerSide();
        });
      }

      paginationOptions.sortName = vm.gridOptions.columnDefs[0].name;
      vm.getPaginationServerSide = function() {
        vm.datosGrid = {
          paginate : paginationOptions
        };
        BlogServices.sListarNoticias(vm.datosGrid).then(function (rpta) {
          vm.gridOptions.data = rpta.datos;
          vm.gridOptions.totalItems = rpta.paginate.totalRows;
          vm.mySelectionGrid = [];
        });
      }
      vm.getPaginationServerSide();
    // MANTENIMIENTO
      vm.btnNuevo = function(){
        var modalInstance = $uibModal.open({
          templateUrl: 'app/pages/blog/blog_formview.php',
          controllerAs: 'mb',
          size: 'lg',
          backdropClass: 'splash splash-2 splash-ef-16',
          windowClass: 'splash splash-2 splash-ef-16',
          controller: function($scope, $uibModalInstance, arrToModal ){
            var vm = this;
            vm.fData = {};
            vm.fData.canvas = true;
            vm.modoEdicion = false;
            vm.getPaginationServerSide = arrToModal.getPaginationServerSide;
            vm.modalTitle = 'Registro de blog';
            vm.fData.cImagen = false;


            // vm.rutaImagen = arrToModal.scope.dirImagesBanner + vm.fData.tipo_banner +'/';
            console.log('sel',arrToModal.seleccion);
            console.log('data',vm.fData);
            vm.aceptar = function () {
              // if(vm.fData.cImagen){
              //   if(angular.isUndefined($scope.image)){
              //     alert('Debe seleccionar una imagen');
              //     return false;
              //   }
              // }
              vm.fData.imagen = $scope.image;
              vm.fData.size = $scope.file.size;
              vm.fData.nombre_imagen = $scope.file.name;
              vm.fData.tipo_imagen = $scope.file.type;

              BlogServices.sRegistrarNoticia(vm.fData).then(function (rpta) {
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
          templateUrl: 'app/pages/blog/blog_formview.php',
          controllerAs: 'mb',
          size: 'lg',
          backdropClass: 'splash splash-2 splash-ef-16',
          windowClass: 'splash splash-2 splash-ef-16',
          controller: function($scope, $uibModalInstance, arrToModal ){
            var vm = this;
            vm.fData = {};
            vm.fData = angular.copy(arrToModal.seleccion);
            vm.modoEdicion = true;
            vm.getPaginationServerSide = arrToModal.getPaginationServerSide;
            vm.modalTitle = 'Edición de Blog';
            vm.fData.canvas = false;



            vm.rutaImagen = arrToModal.scope.dirImagesBlog;
            console.log('sel',arrToModal.seleccion);
            console.log('data',vm.fData);
            vm.aceptar = function () {
              if(vm.fData.canvas){
                if(angular.isUndefined($scope.image)){
                  alert('Debe seleccionar una imagen');
                  return false;
                }
                vm.fData.imagen = $scope.image;
                console.log('imagen',vm.fData.imagen);
                vm.fData.size = $scope.file.size;
                vm.fData.nombre_imagen = $scope.file.name;
                vm.fData.tipo_imagen = $scope.file.type;
              }

              BlogServices.sEditarNoticia(vm.fData).then(function (rpta) {
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
            BlogServices.sAnularNoticia(row.entity).then(function (rpta) {
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
  }
  function BlogServices($http, $q) {
    return({
        sListarNoticias: sListarNoticias,
        sRegistrarNoticia: sRegistrarNoticia,
        sEditarNoticia: sEditarNoticia,
        sAnularNoticia: sAnularNoticia,
    });
    function sListarNoticias(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Blog/listar_noticias",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sRegistrarNoticia(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Blog/registrar_noticia",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sEditarNoticia(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Blog/editar_noticia",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sAnularNoticia(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Blog/anular_noticia",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
  }
})();