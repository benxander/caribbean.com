(function() {
  'use strict';
  angular
    .module('minotaur')
    .controller('EncuestaController', EncuestaController)
    .service('EncuestaServices', EncuestaServices);

  /** @ngInject */
  function EncuestaController($scope,$uibModal,$filter, EncuestaServices,toastr,alertify, pageLoading, uiGridConstants) {
    var vm = this;
    var openedToasts = [];
    vm.fData = {}
    vm.fData.v1 = 0;
    vm.fData.v2 = 0;
    vm.fData.v3 = 0;
    vm.fData.v4 = 0;
    vm.fData.v5 = 0;
    // GRILLA PRINCIPAL
      vm.gridOptions = {

        appScopeProvider: vm
      }
      vm.gridOptions.columnDefs = [
        { field: 'puntos', name:'puntos', displayName: 'PUNTOS', minWidth: 50, width:80, visible:true},
        { field: 'puntaje', name:'puntaje', displayName: 'PUNTAJE', minWidth: 100 ,enableFiltering:false},
        { field: 'porcentaje', name:'porcentaje', displayName: '%', minWidth: 100, width:80 },
        { field: 'accion', name: 'accion', displayName: 'ACCIONES', width: 90, pinnedRight: true,
          enableFiltering: false,
          enableColumnMenus: false, enableColumnMenu: false, enableSorting: false,
          cellTemplate: '<div class="text-center">' +
            '<button class="btn btn-default btn-sm text-green btn-action"  ng-click="grid.appScope.verDetalle(row)" tooltip-placement="left" uib-tooltip="VER DETALLE" > <i class="fa fa-eye"></i> </button>' +
            '</div>'
        }
      ];
      vm.gridOptions.onRegisterApi = function(gridApi) {
        vm.gridApi = gridApi;

      }

      // paginationOptions.sortName = vm.gridOptions.columnDefs[0].name;
      vm.getPaginationServerSide = function() {
        EncuestaServices.sListarPuntuacion().then(function (rpta) {
          if(rpta.flag == 1){
            vm.gridOptions.data = rpta.datos;
            vm.promedio = rpta.promedio;
            vm.total = rpta.total;
            vm.porcentaje = rpta.porcentaje;
            vm.style = "{'width: "+ vm.porcentaje +"%'}";
            vm.fData.v5 = vm.gridOptions.data[0].porcentaje;
            vm.fData.v4 = vm.gridOptions.data[1].porcentaje;
            vm.fData.v3 = vm.gridOptions.data[2].porcentaje;
            vm.fData.v2 = vm.gridOptions.data[3].porcentaje;
            vm.fData.v1 = vm.gridOptions.data[4].porcentaje;
          }else if( rpta.flag == -1 ){
            $scope.goToUrl('/app/pages/login');
          }
        });
      }
      vm.getPaginationServerSide();
      // vm.fBusqueda = {}
    vm.verDetalle = function(row){
      console.log(row);
      var modalInstance = $uibModal.open({
        templateUrl: 'app/pages/encuesta/detalle_enc_view.php',
        controllerAs: 'dm',
        size: '',
        backdropClass: 'splash splash-2 splash-ef-16',
        windowClass: 'splash splash-2 splash-ef-16',
        scope: $scope,
        controller: function ($scope,$uibModalInstance) {
          var vm = this;
          vm.modalTitle = "Detalle de Puntuación de " + row.entity.puntos + '★';

          var paginationOptions = {
            pageNumber: 1,
            firstRow: 0,
            pageSize: 50,
            sort: uiGridConstants.DESC,
            sortName: null,
            search: null
          };
          vm.gridOptionsDetalle = {
            paginationPageSizes: [10, 25, 50],
            paginationPageSize: 50,
            enableSorting: true,
            useExternalPagination: true,
            useExternalSorting: true,
            appScopeProvider: vm
          }
          vm.gridOptionsDetalle.columnDefs = [
            { field: 'idpuntuacion', name: 'idpuntuacion', displayName: 'ID', minWidth: 50, width: 80, visible: true, sort: { direction: uiGridConstants.DESC } },
            { field: 'codigo', name: 'codigo', displayName: 'CODIGO', minWidth: 50, visible: true },
            { field: 'fecha_registro', name: 'fecha_registro', displayName: 'FECHA', minWidth: 120, width: 150, visible: true },


          ];
          vm.gridOptionsDetalle.onRegisterApi = function (gridApi) {
            vm.gridApi = gridApi;

            gridApi.core.on.sortChanged($scope, function (grid, sortColumns) {
              //console.log(sortColumns);
              if (sortColumns.length == 0) {
                paginationOptions.sort = null;
                paginationOptions.sortName = null;
              } else {
                paginationOptions.sort = sortColumns[0].sort.direction;
                paginationOptions.sortName = sortColumns[0].name;
              }
              vm.getPaginationServerSide();
            });
            gridApi.pagination.on.paginationChanged($scope, function (newPage, pageSize) {
              paginationOptions.pageNumber = newPage;
              paginationOptions.pageSize = pageSize;
              paginationOptions.firstRow = (paginationOptions.pageNumber - 1) * paginationOptions.pageSize;
              vm.getPaginationServerSide();
            });
          }
          paginationOptions.sortName = vm.gridOptionsDetalle.columnDefs[0].name;
          vm.getPaginationServerSide = function () {
            vm.datosGrid = {
              paginate: paginationOptions,
              datos: row.entity
            };
            EncuestaServices.sListarDetalle(vm.datosGrid).then(function (rpta) {
              if (rpta.flag == 1) {
                vm.gridOptionsDetalle.data = rpta.datos;
                vm.gridOptionsDetalle.totalItems = rpta.paginate.totalRows;
              }

            });
          }

          vm.getPaginationServerSide();

          vm.cancel = function () {
            $uibModalInstance.dismiss('cancel');
          }
        }

      });
    }

    vm.btnComentarios = function(){
      pageLoading.start('Cargando..');
      var modalInstance = $uibModal.open({
        templateUrl: 'app/pages/encuesta/comentarios_view.php',
        controllerAs: 'mp',
        size: 'lg',
        backdropClass: 'splash splash-2 splash-ef-16',
        windowClass: 'splash splash-2 splash-ef-16',
        backdrop: 'static',
        keyboard: false,
        scope: $scope,
        controller: function($scope, $uibModalInstance, arrToModal ){
          var vm = this;
          vm.listadoComentarios = [];
          // vm.getPaginationServerSide = arrToModal.getPaginationServerSide;
          vm.modalTitle = 'Comentarios';

          EncuestaServices.sListarComentarios().then(function (rpta) {
            pageLoading.stop();
            vm.message = rpta.message;
            if(rpta.flag == 1){
              vm.listadoComentarios = rpta.datos;

            }
          });

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
  function EncuestaServices($http, $q) {
    return({
      sListarPuntuacion: sListarPuntuacion,
      sListarComentarios: sListarComentarios,
      sListarDetalle: sListarDetalle,
    });
    function sListarPuntuacion(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Movimiento/listar_puntuacion",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sListarComentarios(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Movimiento/listar_comentarios",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sListarDetalle(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Movimiento/listar_detalle_puntuacion",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
  }
})();