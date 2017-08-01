(function() {
  'use strict';
  angular
    .module('minotaur')
    .controller('BannerController', BannerController)
    .service('BannerServices', BannerServices);

  /** @ngInject */
  function BannerController($scope, $uibModal, uiGridConstants, FileUploader,
    BannerServices, TipobannerServices, SeccionServices) {
    var vm = this;
    // GRILLA PRINCIPAL
      var paginationOptions = {
        pageNumber: 1,
        firstRow: 0,
        pageSize: 10,
        sort: uiGridConstants.DESC,
        sortName: null,
        search: null
      };
      vm.dirImagesBanner = $scope.dirImages + "banners/";
      console.log('vm.dirImagesBanner',vm.dirImagesBanner);
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
        { field: 'idbanner', name:'idbanner', displayName: 'ID', minWidth: 50, width:80, visble:false, sort: { direction: uiGridConstants.DESC} },
        { field: 'seccion', name:'seccion', displayName: 'SECCION', minWidth: 160 },
        { field: 'tipo_banner', name:'tipo_banner', displayName: 'TIPO BANNER', minWidth: 160 },
        { field: 'titulo_ba', name:'titulo_ba', displayName: 'TITULO BANNER', minWidth: 180 },
        { field: 'imagen_ba', name: 'imagen_ba', displayName: '',width: 180, enableFiltering: false, enableSorting: false, cellTemplate:'<img style="height:inherit;" class="center-block" ng-src="{{ grid.appScope.dirImagesBanner + row.entity.tipo_banner + \'/\' + COL_FIELD }}" /> </div>' },
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
            'ba.idbanner' : grid.columns[1].filters[0].term,
          }
          vm.getPaginationServerSide();
        });
      }

      paginationOptions.sortName = vm.gridOptions.columnDefs[0].name;
      vm.getPaginationServerSide = function() {
        vm.datosGrid = {
          paginate : paginationOptions
        };
        BannerServices.sListarBanner(vm.datosGrid).then(function (rpta) {
          vm.gridOptions.data = rpta.datos;
          vm.gridOptions.totalItems = rpta.paginate.totalRows;
          vm.mySelectionGrid = [];
        });
      }
      vm.getPaginationServerSide();
      // MANTENIMIENTO
      vm.btnNuevo = function () {
        var modalInstance = $uibModal.open({
          templateUrl: 'app/pages/banner/banner_formview.html',
          controllerAs: 'mb',
          size: 'md',
          backdropClass: 'splash splash-2 splash-ef-14',
          windowClass: 'splash splash-2 splash-ef-14',
          controller: function($scope, $uibModalInstance, arrToModal ){
            var vm = this;
            vm.fData = {};
            vm.modoEdicion = false;
            vm.getPaginationServerSide = arrToModal.getPaginationServerSide;
            vm.modalTitle = 'Registro de banners';
            vm.activeStep = 0;
            // SECCION
            SeccionServices.sListarSeccionCbo().then(function (rpta) {
              console.log('rpta',rpta);
              vm.listaSeccion = rpta.datos;
              vm.listaSeccion.splice(0,0,{ id : '', descripcion:'--Seleccione una opción--'});
              vm.fData.seccion = vm.listaSeccion[0];
            });
            // TIPO DE BANNER
            TipobannerServices.sListarTipobannerCbo().then(function (rpta) {
              vm.listaTipoBanner = angular.copy(rpta.datos);
              vm.listaTipoBanner.splice(0,0,{ id : '', descripcion:'--Seleccione una opción--'});
              vm.fData.tipoBanner = vm.listaTipoBanner[0];
            });
            // subida de imagen
              var uploader = vm.uploader = new FileUploader({
                //url: 'app/components/modules/fileupload/upload.php' //enable this option to get f
              });

              // FILTERS

              uploader.filters.push({
                name: 'customFilter',
                fn: function() {
                  var vm = this;
                  return vm.queue.length < 10;
                }
              });

              uploader.filters.push({
                name: 'imageFilter',
                fn: function(item /*{File|FileLikeObject}, options*/) {
                  var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
                  return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
                }
              });
            // botones
              vm.aceptar = function () {
                BannerServices.sRegistrarBanner(vm.fData).then(function (rpta) {
                  var openedToasts = [];
                  vm.options = {
                    timeout: '3000',
                    extendedTimeout: '1000',
                    preventDuplicates: false,
                    preventOpenDuplicates: false
                  };
                  if(rpta.flag == 1){
                    $uibModalInstance.close(vm.fData);
                    vm.getPaginationServerSide();
                    var title = 'OK';
                    var iconClass = 'success';
                  }else if( rpta.flag == 0 ){
                    var title = 'Advertencia';
                    var iconClass = 'warning';
                  }else{
                    alert('Ocurrió un error');
                  }
                  // var toast = toastr[iconClass](rpta.message, title, vm.options);
                  // openedToasts.push(toast);
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
              }
            }
          }
        });
      }
      vm.btnEditar = function(row){
        var modalInstance = $uibModal.open({
          templateUrl: 'app/pages/alimento/alimento_formview.html',
          controllerAs: 'modalAli',
          size: 'lg',
          backdropClass: 'splash splash-2 splash-ef-14',
          windowClass: 'splash splash-2 splash-ef-14',
          controller: function($scope, $uibModalInstance, arrToModal ){
            var vm = this;
            var openedToasts = [];
            vm.fData = {};
            vm.fData = angular.copy(arrToModal.seleccion);
            vm.modoEdicion = true;
            vm.getPaginationServerSide = arrToModal.getPaginationServerSide;
            vm.modalTitle = 'Edición de Alimentos';
            vm.activeStep = 0;

            TipobannerServices.sListarGrupoAlimento1().then(function (rpta) {
              vm.listaGrupo1 = {};
              vm.listaGrupo1 = angular.copy(rpta.datos);
              vm.listaGrupo1.splice(0,0,{ id : 0, descripcion:'--Seleccione una opción--'});
              angular.forEach(vm.listaGrupo1, function(value, key){
                if(value.id == vm.fData.idgrupo1){
                  vm.fData.idgrupo1 = vm.listaGrupo1[key];
                  TipobannerServices.sListarGrupoAlimento2(value.id).then(function (rpta) {
                    vm.listaGrupo2 = {};
                    vm.listaGrupo2 = angular.copy(rpta.datos);
                    vm.listaGrupo2.splice(0,0,{ id : 0, descripcion:'--Seleccione una opción--'});
                    angular.forEach(vm.listaGrupo2, function(value2, key2){
                      if(value2.id == vm.fData.idgrupo2){
                        vm.fData.idgrupo2 = vm.listaGrupo2[key2];
                      }
                    });
                  });
                }
              });
            });

            vm.cambiogrupo = function(){
              TipobannerServices.sListarGrupoAlimento2(vm.fData.idgrupo1.id).then(function (rpta) {
                vm.listaGrupo2 = angular.copy(rpta.datos);
                vm.listaGrupo2.splice(0,0,{ id : 0, descripcion:'--Seleccione una opción--'});
                vm.fData.idgrupo2 = vm.listaGrupo2[0];
              });
            }

            vm.aceptar = function () {
              $uibModalInstance.close(vm.fData);
              AlimentoServices.sEditarAlimento(vm.fData).then(function (rpta) {
                vm.options = {
                  timeout: '3000',
                  extendedTimeout: '1000',
                  progressBar: true,
                  preventDuplicates: false,
                  preventOpenDuplicates: false
                };
                if(rpta.flag == 1){
                  //$uibModalInstance.close(vm.fData);
                  $uibModalInstance.dismiss('cancel');
                  vm.getPaginationServerSide();
                  var title = 'OK';
                  var iconClass = 'success';
                }else if( rpta.flag == 0 ){
                  var title = 'Advertencia';
                  var iconClass = 'warning';
                }else{
                  alert('Ocurrió un error');
                }
                var toast = toastr[iconClass](rpta.message, title, vm.options);
                openedToasts.push(toast);
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
                seleccion : row.entity
              }
            }
          }
        });
      }
      vm.btnAnular = function(row){
        alertify.confirm("¿Realmente desea realizar la acción?", function (ev) {
          ev.preventDefault();
          AlimentoServices.sAnularAlimento(row.entity).then(function (rpta) {
            var openedToasts = [];
            vm.options = {
              timeout: '3000',
              extendedTimeout: '1000',
              preventDuplicates: false,
              preventOpenDuplicates: false
            };
            if(rpta.flag == 1){
              vm.getPaginationServerSide();
              var title = 'OK';
              var iconClass = 'success';
            }else if( rpta.flag == 0 ){
              var title = 'Advertencia';
              var iconClass = 'warning';
            }else{
              alert('Ocurrió un error');
            }
            var toast = toastr[iconClass](rpta.message, title, vm.options);
            openedToasts.push(toast);
          });
        }, function(ev) {
            ev.preventDefault();
        });
      }
  }

  function BannerServices($http, $q) {
    return({
        sListarBanner: sListarBanner,
        sRegistrarBanner: sRegistrarBanner
    });
    function sListarBanner(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Banner/listar_banners",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sRegistrarBanner(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Banner/registrar_banner",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
  }

})();