(function() {
  'use strict';
  angular
    .module('minotaur')
    .controller('SeccionController', SeccionController)
    .service('SeccionServices', SeccionServices);

  /** @ngInject */
  function SeccionController($scope,SeccionServices,$uibModal, uiGridConstants, toastr, alertify,) {
    var vm = this;
    var openedToasts = [];
    //$scope.image = "";
    vm.boolListado = true;
    vm.listaFichas = [];
    // GRILLA PRINCIPAL
      var paginationOptions = {
        pageNumber: 1,
        firstRow: 0,
        pageSize: 10,
        sort: uiGridConstants.ASC,
        sortName: null,
        search: null
      };
      // vm.dirImagesBanner = $scope.dirImages + "banners/";
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
        appScopeProvider: vm
      }
      vm.gridOptions.columnDefs = [
        { field: 'idseccioncontenido', name:'idseccioncontenido', displayName: 'ID', minWidth: 50, width:80, visible:false },
        { field: 'seccion', name:'seccion', displayName: 'SECCION', minWidth: 100, sort: { direction: uiGridConstants.ASC} },
        { field: 'titulo', name:'titulo', displayName: 'TITULO', minWidth: 100 },
        { field: 'subtitulo', name:'subtitulo', displayName: 'SUBTITULO', minWidth: 100 },

        { field: 'accion', name:'accion', displayName: 'ACCION', width: 80, enableFiltering: false,
          cellTemplate: '<div class="text-right">' +
          '<button ng-if="row.entity.acepta_ficha" class="btn btn-default btn-sm text-blue btn-action" ng-click="grid.appScope.verFichas(row)" tooltip-placement="left" uib-tooltip="FICHAS" > <i class="icon-grid"></i> </button>' +

          '<button class="btn btn-default btn-sm text-green btn-action" ng-click="grid.appScope.btnEditar(row)" tooltip-placement="left" uib-tooltip="EDITAR" > <i class="icon-pencil"></i> </button>' +
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
            'idseccioncontenido' : grid.columns[1].filters[0].term,
            'se.descripcion_se' : grid.columns[2].filters[0].term,
            'sc.titulo' : grid.columns[3].filters[0].term,
            'sc.subtitulo' : grid.columns[3].filters[0].term,
          }
          vm.getPaginationServerSide();
        });
      }

      paginationOptions.sortName = vm.gridOptions.columnDefs[1].name;
      vm.getPaginationServerSide = function() {
        vm.datosGrid = {
          paginate : paginationOptions
        };
        SeccionServices.sListarSecciones(vm.datosGrid).then(function (rpta) {
          vm.gridOptions.data = rpta.datos;
          vm.gridOptions.totalItems = rpta.paginate.totalRows;
          vm.mySelectionGrid = [];
        });
      }
      vm.getPaginationServerSide();
    // MANTENIMIENTO
      vm.btnEditar = function(row){
        var modalInstance = $uibModal.open({
          templateUrl: 'app/pages/seccion/seccion_formview.php',
          controllerAs: 'ms',
          size: 'lg',
          backdropClass: 'splash splash-2 splash-ef-16',
          windowClass: 'splash splash-2 splash-ef-16',
          controller: function($scope, $uibModalInstance, arrToModal ){
            var vm = this;
            vm.fData = {};
            vm.fData = angular.copy(arrToModal.seleccion);
            vm.modoEdicion = true;
            vm.getPaginationServerSide = arrToModal.getPaginationServerSide;
            vm.modalTitle = 'Edición de Sección';
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

              SeccionServices.sEditarContenido(vm.fData).then(function (rpta) {
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

      vm.verFichas = function(row){
        vm.boolListado = false;
        vm.seccion = row.entity;

        SeccionServices.sListarFichas(vm.seccion).then(function (rpta) {
          vm.listaFichas = rpta.datos;
          // vm.mySelectionGrid = [];
        });
      }
      vm.btnNuevaFicha = function(seccion){

       /* if(vm.listaFichas.length > 0){
          vm.listaFichas.push({
           titulo : 'Titulo',
           descripcion:'Escriba una descripcion',
           clase: 'halcyon-icon-paper-plane-1'
          });
        }else{
          vm.listaFichas = [{
           titulo : 'Titulo',
           descripcion:'Escriba una descripcion',
           clase: 'halcyon-icon-paper-plane-1'
          }];
        }*/
        var modalInstance = $uibModal.open({
          templateUrl: 'app/pages/seccion/seccion_ficha_formview.php',
          controllerAs: 'mf',
          size: 'lg',
          backdropClass: 'splash splash-2 splash-ef-16',
          windowClass: 'splash splash-2 splash-ef-16',
          controller: function($scope, $uibModalInstance, arrToModal ){
            var vm = this;
            vm.fData = {};
            // vm.fData = angular.copy(arrToModal.seleccion);
            // vm.modoEdicion = true;
            // vm.getPaginationServerSide = arrToModal.getPaginationServerSide;
            vm.modalTitle = 'Registro de Ficha';

            vm.fData.idseccioncontenido = seccion.idseccioncontenido;
            // vm.rutaImagen = arrToModal.scope.dirImagesBanner + vm.fData.tipo_banner +'/';
            console.log('seccion',seccion);
            console.log('data',vm.fData);
            vm.aceptar = function () {
              SeccionServices.sRegistrarFicha(vm.fData).then(function (rpta) {
                if(rpta.flag == 1){
                  $uibModalInstance.dismiss('cancel');
                  // vm.getPaginationServerSide();
                  var title = 'OK';
                  var type = 'success';
                  $uibModalInstance.close(vm.fData);
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
                // getPaginationServerSide : vm.getPaginationServerSide,
                seleccion : seccion,
                scope : vm,
              }
            }
          }
        });
      }
      vm.btnVolver = function(){
        vm.boolListado = true;
      }

  }
  function SeccionServices($http, $q) {
    return({
        sListarSeccionCbo: sListarSeccionCbo,
        sListarSecciones: sListarSecciones,
        sEditarContenido: sEditarContenido,
        sListarFichas: sListarFichas,
        sRegistrarFicha: sRegistrarFicha,
    });
    function sListarSeccionCbo(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Seccion/listar_seccion_cbo",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sListarSecciones(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Seccion/listar_secciones",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sEditarContenido(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Seccion/editar_contenido",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sListarFichas(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Seccion/listar_fichas",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sRegistrarFicha(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Seccion/registrar_ficha",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
  }
})();