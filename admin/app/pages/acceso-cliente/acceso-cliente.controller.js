(function() {
  'use strict';
  angular
    .module('minotaur')
    .controller('AccesoClienteController', AccesoClienteController)
    .service('AccesoClienteServices', AccesoClienteServices);

  /** @ngInject */
  function AccesoClienteController($scope, $window, $uibModal, $filter, uiGridConstants, toastr, alertify,tileLoading, pageLoading, ModalReporteFactory,
    AccesoClienteServices, ExcursionServices, UsuarioServices, FileUploader,i18nService) {
    var vm = this;
    vm.fBusqueda = {}
    var openedToasts = [];

    // GRILLA PRINCIPAL
      var paginationOptions = {
        pageNumber: 1,
        firstRow: 0,
        pageSize: 50,
        sort: uiGridConstants.DESC,
        sortName: null,
        search: null
      };

      vm.mySelectionGrid = [];
      vm.gridOptions = {
        paginationPageSizes: [10, 25, 50],
        paginationPageSize: 50,
        enableFiltering: true,
        enableSorting: true,
        useExternalPagination: true,
        useExternalSorting: true,
        useExternalFiltering : true,
        enableRowSelection: true,
        enableRowHeaderSelection: true,
        enableFullRowSelection: false,
        enableSelectAll: true,
        multiSelect: true,
        exporterMenuCsv: false,
        enableGridMenu: true,
        enableColumnMenus: false,
        enableColumnMenu: false,
        appScopeProvider: vm
      }
      vm.gridOptions.columnDefs = [
        { field: 'idcliente', name:'idcliente', displayName: 'ID CLIENTE',  width:90, sort: { direction: uiGridConstants.DESC}, visible:false },
        { field: 'codigo', name:'codigo', displayName: 'CODIGO',  width:90, visible:true },
        { field: 'idexcursion', name:'idexcursion', displayName: 'ID EXCUR.', minWidth: 90, enableFiltering: false, width:90, cellClass:'text-center'},
        { field: 'excursion', name:'excursion', displayName: 'EXCURSION', minWidth: 130, enableFiltering: false},
        { field: 'fecha_excursion', name:'fecha_excursion', displayName: 'FECHA EXCURSION',width:150, cellClass:'text-center'},
        { field: 'cantidad', name:'cantidad', displayName: 'CANTIDAD', width:100, cellClass:'text-center', enableFiltering: false},
        { field: 'fecha', name:'fecha', displayName: 'ULT. FEC. ACCESO',width:150, cellClass:'text-center', enableFiltering: false},
        { field: 'accion', name:'accion', displayName: 'ACCIONES', width: 130, pinnedRight:true, enableFiltering: false,
          enableColumnMenus: false, enableColumnMenu: false, enableSorting: false,
          cellTemplate: '<div>' +
          '<button class="btn btn-default btn-sm text-green btn-action"  ng-click="grid.appScope.btnVerAcceso(row)" tooltip-placement="left" uib-tooltip="VER ACCESOS" tooltip-append-to-body="true" > <i class="fa fa-eye"></i> </button>'+
          '<button class="btn btn-default btn-sm text-blue btn-action" ng-click="grid.appScope.btnVerDescarga(row)" tooltip-placement="left" uib-tooltip="VER DESCARGAS" tooltip-append-to-body="true"> <i class="fa fa-download"></i> </button>'+
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
        gridApi.core.on.sortChanged($scope, function(grid, sortColumns) {
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
        vm.gridApi.core.on.filterChanged( $scope, function(grid, searchColumns) {
          var grid = this.grid;
          paginationOptions.search = true;
          paginationOptions.searchColumn = {
            'idcliente' : grid.columns[1].filters[0].term,
            'codigo' : grid.columns[2].filters[0].term,
            'cli.idexcursion' : grid.columns[3].filters[0].term,
            'ex.descripcion' : grid.columns[4].filters[0].term,
            "DATE_FORMAT(fecha_excursion,'%d-%m-%Y')" : grid.columns[5].filters[0].term,

          }
          vm.getPaginationServerSide();
        });
      }

      paginationOptions.sortName = vm.gridOptions.columnDefs[0].name;
      vm.getPaginationServerSide = function(loader) {
        var loader = loader || false;
        if(loader){
          tileLoading.start();
        }
        vm.datosGrid = {
          paginate : paginationOptions,
          datos: vm.fBusqueda
        };
        AccesoClienteServices.sListarAccesoCliente(vm.datosGrid).then(function (rpta) {
          if(rpta.flag == 1){
            vm.gridOptions.data = rpta.datos;
            vm.gridOptions.totalItems = rpta.paginate.totalRows;
          }else if( rpta.flag == -1 ){
            $scope.goToUrl('/app/pages/login');
          }
          vm.mySelectionGrid = [];
          if(loader){
            tileLoading.stop();
          }
        });
      }
      vm.getTableHeight = function() {
        var rowHeight = 30; // your row height
        var headerHeight = 60; // your header height
        return {
           height: (vm.gridOptions.data.length * rowHeight + headerHeight + 60) + "px"
        };
      };
    // EXCURSIONES
      ExcursionServices.sListarExcursionCbo().then(function (rpta) {
        vm.listaExcursiones = angular.copy(rpta.datos);
        vm.listaExcursionesFiltro = angular.copy(rpta.datos);
        vm.listaExcursionesFiltro.splice(0,0,{ id : '0', descripcion:'--TODAS--'});
        vm.fBusqueda.filtroExcursiones = vm.listaExcursionesFiltro[0];
        vm.getPaginationServerSide(true);
      });


      vm.btnVerAcceso = function (row) {
        var modalInstance = $uibModal.open({
          templateUrl: 'app/pages/acceso-cliente/detalle_view.php',
          controllerAs: 'mc',
          size: 'lg',
          backdropClass: 'splash splash-2 splash-ef-16',
          windowClass: 'splash splash-2 splash-ef-16',
          scope: $scope,
          controller: function($scope, $uibModalInstance, arrToModal ){
            var vm = this;
            vm.fData = {};
            vm.fData = row.entity;
            vm.modalTitle = 'Detalle de acceso de ' + vm.fData.codigo;
            console.log(vm.fData);
            var paginationOptions = {
              sort: uiGridConstants.DESC,
              sortName: null,
            };
            // GRILLA DETALLE
            vm.gridOptionsDetalle = {
              enableSorting: true,
              useExternalSorting: true,

              enableColumnMenus: false,
              enableColumnMenu: false,
              appScopeProvider: vm
            }
            vm.gridOptionsDetalle.columnDefs = [
              { field: 'idclientesesion', name:'idclientesesion', displayName: 'ID',  width:90, sort: { direction: uiGridConstants.DESC}, visible:false },
              { field: 'fecha', name:'fecha', displayName: 'FECHA',  width:90, visible:true },
              { field: 'hora', name:'hora', displayName: 'HORA', minWidth: 90, width:90, cellClass:'text-center'},
              { field: 'ip', name:'ip', displayName: 'IP', minWidth: 130, enableFiltering: false}
            ];
            vm.gridOptionsDetalle.onRegisterApi = function(gridApi) {
              vm.gridApi = gridApi;

              gridApi.core.on.sortChanged($scope, function(grid, sortColumns) {
                //console.log(sortColumns);
                if (sortColumns.length == 0) {
                  paginationOptions.sort = null;
                  paginationOptions.sortName = null;
                } else {
                  paginationOptions.sort = sortColumns[0].sort.direction;
                  paginationOptions.sortName = sortColumns[0].name;
                }
                vm.getDetalleServerSide();
              });
            }
            paginationOptions.sortName = vm.gridOptionsDetalle.columnDefs[0].name;
            vm.getDetalleServerSide = function(loader) {
              var loader = loader || false;
              if(loader){
                pageLoading.start('Cargando detalle...');
              }
              vm.gridOptionsDetalle = {
                paginate : paginationOptions,
                datos: vm.fData
              };
              AccesoClienteServices.sListarDetalleAcceso(vm.gridOptionsDetalle).then(function (rpta) {
                if(rpta.flag == 1){
                  vm.gridOptionsDetalle.data = rpta.datos;
                }else if( rpta.flag == -1 ){
                  $scope.goToUrl('/app/pages/login');
                }

                if(loader){
                  pageLoading.stop();
                }
              });
            }
            vm.getDetalleServerSide(true);
            vm.getTableHeight = function() {
              var rowHeight = 30; // your row height
              var headerHeight = 60; // your header height
              return {
                 height: (vm.gridOptionsDetalle.data.length * rowHeight + headerHeight + 60) + "px"
              };
            };

            vm.btnExportarListaPdf = function () {
              pageLoading.start('Procesando...');
              var params = {
                paginate : paginationOptions,
                datos: vm.fData
              };
              AccesoClienteServices.sImprimirAccesosPorClientes(params).then(function(rpta){
                pageLoading.stop();
                if(rpta.flag == 1){
                  console.log('pdf...');
                  $window.open(rpta.urlTempPDF, '_blank');
                }
              });
            };
            vm.btnExportarListaExcel = function () {
              vm.arrData = {
                salida : 'excel',
                datos : vm.fData,
                paginate : paginationOptions
              }
              vm.fData.salida = 'excel';
              var arrParams = {
                titulo: 'Listado de sesiones Cliente',
                datos: vm.arrData,
                paginate : paginationOptions,
                metodo: 'js',
                url:  angular.patchURLCI+'Reportes/excel_accesos_por_clientes'
              }
              ModalReporteFactory.getPopupReporte(arrParams);

              // vm.fBusqueda.titulo = vm.selectedReport.titulo;
            };

            vm.cancel = function () {
              $uibModalInstance.dismiss('cancel');
            };
          },
          resolve: {
            arrToModal: function() {
              return {
                scope : vm,
              }
            }
          }
        });
      }
      vm.btnVerDescarga = function (row) {
        var modalInstance = $uibModal.open({
          templateUrl: 'app/pages/acceso-cliente/detalle_view.php',
          controllerAs: 'mc',
          size: 'lg',
          backdropClass: 'splash splash-2 splash-ef-16',
          windowClass: 'splash splash-2 splash-ef-16',
          scope: $scope,
          controller: function($scope, $uibModalInstance, arrToModal ){
            var vm = this;
            vm.fData = {};
            vm.fData = row.entity;
            vm.modalTitle = 'Detalle de descarga de ' + vm.fData.codigo;
            vm.mensaje = 'No hay descargas realizadas'
            console.log(vm.fData);

            var paginationOptions = {
              sort: uiGridConstants.DESC,
              sortName: null,
            };
            // GRILLA DETALLE
            vm.gridOptionsDetalle = {
              enableSorting: true,
              useExternalSorting: true,

              enableColumnMenus: false,
              enableColumnMenu: false,
              appScopeProvider: vm
            }
            vm.gridOptionsDetalle.columnDefs = [
              { field: 'idarchivo', name:'idarchivo', displayName: 'ID',  width:90, sort: { direction: uiGridConstants.DESC}, visible:false },
              { field: 'nombre_archivo', name:'nombre_archivo', displayName: 'ARCHIVO', minWidth: 130, enableFiltering: false},
              { field: 'fecha', name:'fecha', displayName: 'FECHA',  width:90, visible:true },
              { field: 'hora', name:'hora', displayName: 'HORA', minWidth: 90, width:90, cellClass:'text-center'}
            ];
            vm.gridOptionsDetalle.onRegisterApi = function(gridApi) {
              vm.gridApi = gridApi;

              gridApi.core.on.sortChanged($scope, function(grid, sortColumns) {
                //console.log(sortColumns);
                if (sortColumns.length == 0) {
                  paginationOptions.sort = null;
                  paginationOptions.sortName = null;
                } else {
                  paginationOptions.sort = sortColumns[0].sort.direction;
                  paginationOptions.sortName = sortColumns[0].name;
                }
                vm.getDetalleServerSide();
              });

            }
            paginationOptions.sortName = vm.gridOptionsDetalle.columnDefs[0].name;
            vm.getDetalleServerSide = function(loader) {
              var loader = loader || false;
              if(loader){
                pageLoading.start('Cargando detalle...');
              }
              vm.gridOptionsDetalle = {
                paginate : paginationOptions,
                datos: vm.fData
              };
              AccesoClienteServices.sListarDetalleDescarga(vm.gridOptionsDetalle).then(function (rpta) {
                if(loader){
                  pageLoading.stop();
                }
                if(rpta.flag == 1){
                  vm.gridOptionsDetalle.data = rpta.datos;
                }else if( rpta.flag == -1 ){
                  $scope.goToUrl('/app/pages/login');
                }

              });
            }
            vm.getDetalleServerSide(true);
            vm.getTableHeight = function() {
              var rowHeight = 30; // your row height
              var headerHeight = 60; // your header height
              return {
                 height: (vm.gridOptionsDetalle.data.length * rowHeight + headerHeight + 60) + "px"
              };
            };

            vm.btnExportarListaPdf = function () {
              pageLoading.start('Procesando...');
              var params = {
                paginate : paginationOptions,
                datos: vm.fData
              };
              AccesoClienteServices.sImprimirDescargasPorClientes(params).then(function(rpta){
                pageLoading.stop();
                if(rpta.flag == 1){
                  console.log('pdf...');
                  $window.open(rpta.urlTempPDF, '_blank');
                }
              });
            };
            vm.btnExportarListaExcel = function () {
              vm.arrData = {
                salida : 'excel',
                datos : vm.fData,
                paginate : paginationOptions
              }
              vm.fData.salida = 'excel'; // de momento solo tendremos excel
              var arrParams = {
                titulo: 'Listado de descargas por Cliente',
                datos: vm.arrData,
                paginate : paginationOptions,
                metodo: 'js',
                url:  angular.patchURLCI+'Reportes/excel_descargas_por_clientes'
              }
              ModalReporteFactory.getPopupReporte(arrParams);

              // vm.fBusqueda.titulo = vm.selectedReport.titulo;
            };

            vm.cancel = function () {
              $uibModalInstance.dismiss('cancel');
            };
          },
          resolve: {
            arrToModal: function() {
              return {
                scope : vm,
              }
            }
          }
        });
      }
  }

  function AccesoClienteServices($http, $q) {
    return({
        sListarAccesoCliente: sListarAccesoCliente,
        sListarDetalleAcceso: sListarDetalleAcceso,
        sListarDetalleDescarga: sListarDetalleDescarga,
        sImprimirDescargasPorClientes : sImprimirDescargasPorClientes,
        sImprimirAccesosPorClientes : sImprimirAccesosPorClientes,
    });
    function sListarAccesoCliente(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Cliente/listar_acceso_clientes",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sListarDetalleAcceso(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Cliente/listar_detalle_acceso",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sListarDetalleDescarga(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Cliente/listar_detalle_descarga",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sImprimirDescargasPorClientes (pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Cliente/imprimir_descargas_por_clientes",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sExcelDescargasPorClientes (pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Reportes/excel_descargas_por_clientes",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sImprimirAccesosPorClientes (pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Cliente/imprimir_accesos_por_clientes",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
  }

})();