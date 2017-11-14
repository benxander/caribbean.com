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
        { field: 'idactividad', name:'idactividad', displayName: 'ID', minWidth: 50, width:80, visible:false, sort: { direction: uiGridConstants.DESC} },

        { field: 'fecha_f', name:'fecha_actividad', displayName: 'FECHA', enableFiltering: false, minWidth: 80, width: 100 },
        { field: 'descripcion', name:'descripcion', displayName: 'DESCRIPCION', minWidth: 100 },
        { field: 'cantidad_fotos', name:'cantidad_fotos', displayName: 'CANT. FOTOS', minWidth: 100 },
        { field: 'monto_total', name:'monto_total', displayName: 'MONTO ($)', minWidth: 100 },
        { field: 'estado', type: 'object', name: 'estado', displayName: 'ESTADO', maxWidth: 100, enableFiltering: false,
          cellTemplate:'<div class=" ml-md mt-xs onoffswitch green inline-block medium">'+
                  '<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="switch{{ COL_FIELD.id }}" ng-checked="{{ COL_FIELD.bool }}" ng-click="grid.appScope.btnHabilitarDeshabilitar(row)">'+
                  '<label class="onoffswitch-label" for="switch{{ COL_FIELD.id }}">'+
                    '<span class="onoffswitch-inner"></span><span class="onoffswitch-switch"></span>'+
                  '</label></div>' },
        { field: 'accion', name:'accion', displayName: 'ACCION', width: 140, enableFiltering: false,
          cellTemplate: '<div class="text-center">' +
          '<button class="btn btn-default btn-sm text-blue btn-action" ng-click="grid.appScope.verPaquetes(row)" tooltip-placement="left" uib-tooltip="PAQUETES" > <i class="icon-grid"></i> </button>' +

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
            'idactividad' : grid.columns[1].filters[0].term,
            'descripcion' : grid.columns[2].filters[0].term,
            'cantidad' : grid.columns[5].filters[0].term,
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
            vm.modalTitle = 'Registro de excursion';
            // vm.fData.cImagen = false;


            // vm.rutaImagen = arrToModal.scope.dirImagesBanner + vm.fData.tipo_banner +'/';
            // DATEPICKER
              vm.today = function() {
                var y = moment().format('YYYY');
                var m = moment().format('M');
                var d = moment().format('DD');
                vm.fData.fecha = new Date(y, (m-1), d);
              };
              vm.today();

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

              // Disable weekend selection
              // function disabled(data) {
              //   var date = data.date,
              //     mode = data.mode;
              //   return mode === 'day' && (date.getDay() === 0 || date.getDay() === 6);
              // }

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

              // vm.setDate = function(year, month, day) {
              //   vm.fData.fecha = new Date(year, month, day);
              // };

              vm.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
              vm.format = vm.formats[0];
              vm.altInputFormats = ['M!/d!/yyyy'];

              vm.popup1 = {
                opened: false
              };

              vm.popup2 = {
                opened: false
              };

              // var tomorrow = new Date();
              // tomorrow.setDate(tomorrow.getDate() + 1);
              // var afterTomorrow = new Date();
              // afterTomorrow.setDate(tomorrow.getDate() + 1);
              // vm.events = [
              //   {
              //     date: tomorrow,
              //     status: 'full'
              //   },
              //   {
              //     date: afterTomorrow,
              //     status: 'partially'
              //   }
              // ];

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
              // if(vm.fData.cImagen){
              //   if(angular.isUndefined($scope.image)){
              //     alert('Debe seleccionar una imagen');
              //     return false;
              //   }
              // }
              // vm.fData.imagen = $scope.image;
              // vm.fData.size = $scope.file.size;
              // vm.fData.nombre_imagen = $scope.file.name;
              // vm.fData.tipo_imagen = $scope.file.type;

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
      vm.verPaquetes = function(row){
        var modalInstance = $uibModal.open({
          templateUrl: 'app/pages/excursion/paquetes_formview.php',
          controllerAs: 'mb',
          size: 'lg',
          backdropClass: 'splash splash-2 splash-ef-16',
          windowClass: 'splash splash-2 splash-ef-16',
          controller: function($scope, $uibModalInstance, arrToModal ){
            var vm = this;
            vm.fData = {};
            vm.fData = angular.copy(arrToModal.seleccion);
            vm.fData.temporal = {};
            vm.modoEdicion = true;
            vm.getPaginationServerSide = arrToModal.getPaginationServerSide;
            vm.modalTitle = 'Paquetes de Excursión';
            // vm.fData.canvas = false;
            // vm.rutaImagen = arrToModal.scope.dirImagesBlog;
            // GRILLA PAQUETES
              vm.gridOptions = {
                enableFullRowSelection: false,
                multiSelect: false,
                appScopeProvider: vm
              }
              vm.gridOptions.columnDefs = [
                { field: 'titulo_pq',displayName: 'TITULO', minWidth: 80,},
                { field: 'porc_cantidad',displayName: 'CANT %', minWidth: 60,width:90,cellClass:'ui-editCell'},
                { field: 'cantidad',displayName: 'CANT.', minWidth: 60,width:90,enableCellEdit: false},
                { field: 'porc_monto',displayName: 'MONTO %', minWidth: 60,width:90,cellClass:'ui-editCell'},
                { field: 'monto',displayName: 'MONTO $', minWidth: 60,width:90,enableCellEdit: false },

              ];
              vm.gridOptions.onRegisterApi = function(gridApi) {
                vm.gridApi = gridApi;
                gridApi.edit.on.afterCellEdit($scope,function (rowEntity, colDef, newValue, oldValue){
                  rowEntity.column = colDef.field;
                  if(rowEntity.column == 'porc_cantidad'){
                    if( !(rowEntity.porc_cantidad > 0 && rowEntity.porc_cantidad < 100) ){
                      var title = 'Advertencia!';
                      var pType = 'warning';
                      rowEntity.porc_cantidad = oldValue;
                      toastr.warning('El porcentaje debe ser numero mayor a cero', title);
                      return false;
                    }
                    rowEntity.cantidad = Math.ceil(rowEntity.porc_cantidad*vm.fData.cantidad_fotos/100);
                  }
                  else if(rowEntity.column == 'porc_monto'){
                    if( !(rowEntity.porc_monto > 0 && rowEntity.porc_monto < 100) ){
                      var title = 'Advertencia!';
                      var pType = 'warning';
                      rowEntity.porc_monto = oldValue;
                      toastr.warning('El porcentaje debe ser numero mayor a cero', title);
                      return false;
                    }
                    rowEntity.monto = Math.ceil(rowEntity.porc_monto*vm.fData.monto_total/100);
                  }
                  if(!rowEntity.es_nuevo){
                    ExcursionServices.sEditarPaquete(rowEntity).then(function (rpta) {
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
                  $scope.$apply();
                });
              }
                // paginationOptions.sortName = vm.gridOptions.columnDefs[0].name;
              vm.getPaginationServerSide = function() {
                ExcursionServices.sListarPaquetes(vm.fData).then(function (rpta) {
                  vm.gridOptions.data = rpta.datos;
                  // vm.gridOptions.totalItems = rpta.paginate.totalRows;
                  // vm.mySelectionGrid = [];
                });
              }
              vm.getPaginationServerSide();

            vm.calcularCantidad = function(){
              if( vm.fData.cantidad_fotos > 0 ){
                vm.fData.temporal.cantidad = Math.ceil(vm.fData.temporal.porc_cantidad*vm.fData.cantidad_fotos/100);
              }
            }
            vm.calcularMonto = function(){
              if( vm.fData.monto_total > 0 ){
                vm.fData.temporal.monto = Math.ceil(vm.fData.temporal.porc_monto*vm.fData.monto_total/100);
              }
            }
            vm.agregarItem = function(){
              if( !vm.fData.temporal.titulo_pq ){
                var title = 'Advertencia';
                openedToasts.push(toastr['warning']('Agregue un título', title));
                return false;
              }
              if( !vm.fData.temporal.cantidad ){
                var title = 'Advertencia';
                openedToasts.push(toastr['warning']('La cantidad no puede ser nula', title));
                return false;
              }
              if( !vm.fData.temporal.monto ){
                var title = 'Advertencia';
                openedToasts.push(toastr['warning']('El monto no puede ser nulo', title));
                return false;
              }
              vm.arrTemporal = {
                'idactividad' : vm.fData.idactividad,
                'titulo_pq' : vm.fData.temporal.titulo_pq,
                'porc_cantidad' : vm.fData.temporal.porc_cantidad,
                'cantidad' : vm.fData.temporal.cantidad,
                'porc_monto' : vm.fData.temporal.porc_monto,
                'monto' : vm.fData.temporal.monto,
                'es_nuevo' : true

              };
              vm.gridOptions.data.push(vm.arrTemporal);
              vm.fData.temporal = {}
              vm.fData.temporal.porc_cantidad = 0;
              vm.fData.temporal.porc_monto = 0;
              $("#titulo").focus();
            }
            vm.aceptar = function () {
              ExcursionServices.sRegistrarPaquetes(vm.gridOptions.data).then(function (rpta) {
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
  }
  function ExcursionServices($http, $q) {
    return({
      sListarExcursionCbo: sListarExcursionCbo,
      sListarExcursiones: sListarExcursiones,
      sRegistrarExcursion: sRegistrarExcursion,
      sEditarExcursion: sEditarExcursion,
      sListarPaquetes: sListarPaquetes,
      sListarExcursionesCliente: sListarExcursionesCliente,
      sListarExcursionPaquetesCliente: sListarExcursionPaquetesCliente,
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
    function sListarExcursionPaquetesCliente(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Excursion/listar_excursion_paquetes_cliente",
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