(function() {
  'use strict';
  angular
    .module('minotaur')
    .controller('ExcursionController', ExcursionController)
    .service('ExcursionServices', ExcursionServices);

  /** @ngInject */
  function ExcursionController($scope,$uibModal,ExcursionServices,toastr,alertify, uiGridConstants) {
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
      // vm.dirImagesBlog = $scope.dirImages + "blog/";
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
        { field: 'idexcursion', name:'idexcursion', displayName: 'ID', minWidth: 50, width:80, visible:true, sort: { direction: uiGridConstants.DESC} },
        { field: 'descripcion', name:'descripcion', displayName: 'TITULO', minWidth: 100 },
        { field: 'precio_all', name:'precio_all', displayName: 'ALL INCL. ($)', minWidth: 100, enableFiltering: false },
        { field: 'precio_pack', name:'precio_pack', displayName: 'DIG. FUN PASS ($)', minWidth: 100, enableFiltering: false },
        { field: 'precio_primera', name:'precio_primera', displayName: 'SINGLE 1ª ($)', minWidth: 100, enableFiltering: false },
        { field: 'precio_adicional', name:'precio_adicional', displayName: 'SINGLE ADIC. ($)', minWidth: 100, enableFiltering: false },
        { field: 'accion', name:'accion', displayName: 'ACCION', width: 100,
          enableFiltering: false, visible: false,
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
        vm.gridApi.core.on.sortChanged($scope, function(grid, sortColumns) {
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
            'idexcursion' : grid.columns[1].filters[0].term,
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
        ExcursionServices.sListarExcursiones(vm.datosGrid).then(function (rpta) {
          vm.gridOptions.data = rpta.datos;
          vm.gridOptions.totalItems = rpta.paginate.totalRows;
          vm.mySelectionGrid = [];
          if( $scope.fSessionCI.key_grupo == 'key_root' || $scope.fSessionCI.key_grupo == 'key_admin'){
            vm.gridOptions.columnDefs[6].visible = true;
          }
        });
      }
      vm.getPaginationServerSide();

    // MANTENIMIENTO
      vm.btnNuevo = function(){
        var modalInstance = $uibModal.open({
          templateUrl: 'app/pages/excursion/excursion_formview.php',
          controllerAs: 'mb',
          size: '',
          backdropClass: 'splash splash-2 splash-ef-16',
          windowClass: 'splash splash-2 splash-ef-16',
          controller: function($scope, $uibModalInstance, arrToModal ){
            var vm = this;
            vm.fData = {};
            vm.modoEdicion = false;
            vm.getPaginationServerSide = arrToModal.getPaginationServerSide;
            vm.modalTitle = 'Registro de excursión';

            vm.aceptar = function () {
              ExcursionServices.sRegistrarExcursion(vm.fData).then(function (rpta) {
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
          templateUrl: 'app/pages/excursion/excursion_formview.php',
          controllerAs: 'mb',
          size: '',
          backdropClass: 'splash splash-2 splash-ef-16',
          windowClass: 'splash splash-2 splash-ef-16',
          controller: function($scope, $uibModalInstance, arrToModal ){
            var vm = this;
            vm.fData = {};
            vm.fData = angular.copy(arrToModal.seleccion);
            vm.modoEdicion = true;
            vm.getPaginationServerSide = arrToModal.getPaginationServerSide;
            vm.modalTitle = 'Edición de Excursión';
            // vm.fData.canvas = false;

            console.log('vm.fData',vm.fData);

            // vm.rutaImagen = arrToModal.scope.dirImagesBlog;

            // DATEPICKER
              vm.fData.fecha = moment(vm.fData.fecha).toDate();
              vm.today = function() {
                vm.fData.fecha = new Date();
              };
              // vm.today();

              vm.clear = function() {
                vm.fData.fecha = null;
              };

              vm.inlineOptions = {
                customClass: getDayClass,
                minDate: new Date(),
                showWeeks: true
              };

              vm.dateOptions = {
                dateDisabled: false,
                formatYear: 'yy',
                maxDate: new Date(2020, 5, 22),
                minDate: new Date(),
                startingDay: 1,
                showWeeks: false,
                ngModelOptions: {
                  timezone: 'UTC'
                }
              };
              vm.toggleMin = function() {
                vm.inlineOptions.minDate = vm.inlineOptions.minDate ? null : new Date();
                vm.dateOptions.minDate = vm.inlineOptions.minDate;
              };

              vm.toggleMin();

              vm.open1 = function() {
                vm.popup1.opened = true;
              };

              vm.open2 = function() {
                vm.popup2.opened = true;
              };

              vm.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
              vm.format = vm.formats[0];
              vm.altInputFormats = ['M!/d!/yyyy'];

              vm.popup1 = {
                opened: false
              };

              vm.popup2 = {
                opened: false
              };

              function getDayClass(data) {
                var date = data.date,
                  mode = data.mode;
                if (mode === 'day') {
                  var dayToCheck = new Date(date).setHours(0,0,0,0);

                  for (var i = 0; i < vm.events.length; i++) {
                    var currentDay = new Date(vm.events[i].date).setHours(0,0,0,0);

                    if (dayToCheck === currentDay) {
                      return vm.events[i].status;
                    }
                  }
                }

                return '';
              }
            vm.aceptar = function () {
              // if(vm.fData.canvas){
              //   if(angular.isUndefined($scope.image)){
              //     alert('Debe seleccionar una imagen');
              //     return false;
              //   }
              //   vm.fData.imagen = $scope.image;
              //   console.log('imagen',vm.fData.imagen);
              //   vm.fData.size = $scope.file.size;
              //   vm.fData.nombre_imagen = $scope.file.name;
              //   vm.fData.tipo_imagen = $scope.file.type;
              // }

              ExcursionServices.sEditarExcursion(vm.fData).then(function (rpta) {
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
            ExcursionServices.sAnularExcursion(row.entity).then(function (rpta) {
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
      vm.btnHabilitarDeshabilitar = function (row) {
        ExcursionServices.sHabilitarDeshabilitarExcursion(row.entity).then(function (rpta) {
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
      vm.btnSubirVideo = function(){
        var modalInstance = $uibModal.open({
          templateUrl: 'app/pages/excursion/video_formview.php',
          controllerAs: 'mv',
          size: '',
          backdropClass: 'splash splash-2 splash-ef-12',
          windowClass: 'splash splash-2 splash-ef-12',
          controller: function($scope, $uibModalInstance, arrToModal ){
            var vm = this;
            vm.fData = {};
            vm.modalTitle = 'Subida de video demo';
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
  function ExcursionServices($http, $q) {
    return({
      sListarExcursionCbo: sListarExcursionCbo,
      sListarExcursiones: sListarExcursiones,
      sRegistrarExcursion: sRegistrarExcursion,
      sEditarExcursion: sEditarExcursion,
      sListarPaquetes: sListarPaquetes,
      sListarExcursionesCliente: sListarExcursionesCliente,
      sListarExcursionPaquetesSesion: sListarExcursionPaquetesSesion,
      sEditarPaquete: sEditarPaquete,
      sRegistrarPaquetes: sRegistrarPaquetes,
      sAnularExcursion: sAnularExcursion,
      sHabilitarDeshabilitarExcursion: sHabilitarDeshabilitarExcursion,
    });
    function sListarExcursionCbo(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Excursion/listar_excursion_cbo",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sListarExcursiones(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Excursion/listar_excursiones",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sRegistrarExcursion(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Excursion/registrar_excursion",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sEditarExcursion(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Excursion/editar_excursion",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sListarPaquetes(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Excursion/listar_paquetes",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sListarExcursionesCliente(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Excursion/listar_excursiones_cliente",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sListarExcursionPaquetesSesion(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Excursion/listar_excursion_paquetes_sesion",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sEditarPaquete(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Excursion/editar_paquete",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sRegistrarPaquetes(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Excursion/registrar_paquetes",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sAnularExcursion(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Excursion/anular_excursion",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sHabilitarDeshabilitarExcursion(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Excursion/habilitar_deshabilitar_excursion",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
  }
})();