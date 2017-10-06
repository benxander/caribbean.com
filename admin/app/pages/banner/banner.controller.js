(function() {
  'use strict';
  angular
    .module('minotaur')
    .controller('BannerController', BannerController)
    .service('BannerServices', BannerServices);

  /** @ngInject */
  function BannerController($scope, $uibModal, uiGridConstants, toastr, alertify,tileLoading,
    BannerServices, TipobannerServices, SeccionServices) {
    var vm = this;
    var openedToasts = [];
    //$scope.image = "";
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
        // { field: 'seccion', name:'seccion', displayName: 'SECCION', minWidth: 100 },
        // { field: 'tipo_banner', name:'tipo_banner', displayName: 'TIPO BANNER', minWidth: 100 },
        { field: 'titulo', name:'titulo_ba', displayName: 'TITULO BANNER', minWidth: 180 },
        { field: 'imagen', name: 'imagen_ba', displayName: 'IMAGEN',width: 120, enableFiltering: false, enableSorting: false, cellTemplate:'<img style="height:inherit;" class="center-block" ng-src="{{ grid.appScope.dirImagesBanner + row.entity.tipo_banner + \'/\' + COL_FIELD }}" /> </div>' },
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
            'ba.idbanner' : grid.columns[1].filters[0].term,
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
          paginate : paginationOptions
        };
        BannerServices.sListarBanner(vm.datosGrid).then(function (rpta) {
          vm.gridOptions.data = rpta.datos;
          vm.gridOptions.totalItems = rpta.paginate.totalRows;
          vm.mySelectionGrid = [];
          if(loader){
            tileLoading.stop();
          }
        });
      }
      vm.getPaginationServerSide(true);
    // SECCION
      SeccionServices.sListarSeccionCbo().then(function (rpta) {
        vm.listaSeccion = rpta.datos;
        vm.listaSeccion.splice(0,0,{ id : '', descripcion:'--Seleccione una opción--'});
        // vm.fData.seccion = vm.listaSeccion[0];
      });
    // TIPO DE BANNER
      TipobannerServices.sListarTipobannerCbo().then(function (rpta) {
        vm.listaTipoBanner = angular.copy(rpta.datos);
        vm.listaTipoBanner.splice(0,0,{ id : '', descripcion:'--Seleccione una opción--'});
        // vm.fData.tipoBanner = vm.listaTipoBanner[0];
      });
    // MANTENIMIENTO
      vm.btnNuevo = function () {
        var modalInstance = $uibModal.open({
          templateUrl: 'app/pages/banner/banner_formview.php',
          controllerAs: 'mb',
          size: 'lg',
          backdropClass: 'splash splash-2 splash-ef-16',
          windowClass: 'splash splash-2 splash-ef-16',
          backdrop: 'static',
          keyboard:false,
          scope: $scope,
          controller: function($scope, $uibModalInstance, arrToModal ){
            var vm = this;
            vm.fData = {};
            vm.modoEdicion = false;
            vm.getPaginationServerSide = arrToModal.getPaginationServerSide;
            vm.modalTitle = 'Registro de banner';
            vm.fData.canvas = true;
            vm.fData.acepta_texto = '1';
            vm.fData.size_titulo = 70;
            vm.fData.size_subtitulo = 15;
            vm.fData.color_titulo = 'rgba(255,255,255,1)';
            vm.fData.color_subtitulo = 'rgba(255,255,255,1)';

            vm.listaSeccion = arrToModal.scope.listaSeccion;
            vm.listaTipoBanner = arrToModal.scope.listaTipoBanner;
            vm.fData.seccion = vm.listaSeccion[0];
            vm.fData.tipoBanner = vm.listaTipoBanner[0];
            vm.fData.capas = {}

            vm.listaVertical = [
              {'id':'top', 'descripcion': 'ARRIBA'},
              {'id':'middle', 'descripcion': 'MEDIO'},
              {'id':'bottom', 'descripcion': 'ABAJO'},
            ];
            vm.listaHorizontal = [
              {'id':'left', 'descripcion': 'IZQUIERDA'},
              {'id':'center', 'descripcion': 'CENTRO'},
              {'id':'right', 'descripcion': 'DERECHA'},
            ];
            vm.fData.capas = [
              {
                'color' : 'rgba(255,255,255,1)',
                'fontsize' : 70,
                'line_height' : 70,
                'data_width' : 300,
                'data_y' : vm.listaVertical[2].id,
                'data_x' : vm.listaHorizontal[0].id,
                'offset_vertical' : 140,
                'offset_horizontal' : 80,
              },
              {
                'color' : 'rgba(255,255,255,1)',
                'fontsize' : 35,
                'line_height' : 35,
                'data_width' : 200,
                'data_y' : vm.listaVertical[2].id,
                'data_x' : vm.listaHorizontal[0].id,
                'offset_vertical' : 100,
                'offset_horizontal' : 80,
              },
            ];


            // subida de imagen

            // botones
              vm.aceptar = function () {
                if(angular.isUndefined($scope.image)){
                  alert('Debe seleccionar una imagen');
                  return false;
                }
                vm.fData.imagen = $scope.image;
                vm.fData.size = $scope.file.size;
                vm.fData.nombre_imagen = $scope.file.name;
                vm.fData.tipo_imagen = $scope.file.type;

                BannerServices.sRegistrarBanner(vm.fData).then(function (rpta) {

                  if(rpta.flag == 1){
                    $uibModalInstance.close(vm.fData);
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
          templateUrl: 'app/pages/banner/banner_formview.php',
          controllerAs: 'mb',
          size: 'lg',
          backdropClass: 'splash splash-2 splash-ef-16',
          windowClass: 'splash splash-2 splash-ef-16',
          backdrop: 'static',
          keyboard:false,
          controller: function($scope, $uibModalInstance, arrToModal ){
            var vm = this;
            vm.fData = {};
            vm.fData = angular.copy(arrToModal.seleccion);
            vm.modoEdicion = true;
            vm.getPaginationServerSide = arrToModal.getPaginationServerSide;
            vm.modalTitle = 'Edición de Banner';
            vm.fData.canvas = false;
            vm.listaSeccion = arrToModal.scope.listaSeccion;
            vm.listaTipoBanner = arrToModal.scope.listaTipoBanner;
            var objIndex = vm.listaSeccion.filter(function(obj) {
              return obj.descripcion == vm.fData.seccion;
            }).shift();
            vm.fData.seccion = objIndex;
            vm.fData.tipoBanner = vm.listaTipoBanner.filter(function(obj) {
              return obj.descripcion == vm.fData.tipo_banner;
            }).shift();
            BannerServices.slistarCapasBanner(vm.fData).then(function (rpta) {
              vm.fData.capas = rpta.datos;

            });
            vm.listaVertical = [
              {'id':'top', 'descripcion': 'ARRIBA'},
              {'id':'middle', 'descripcion': 'MEDIO'},
              {'id':'bottom', 'descripcion': 'ABAJO'},
            ];
            vm.listaHorizontal = [
              {'id':'left', 'descripcion': 'IZQUIERDA'},
              {'id':'center', 'descripcion': 'CENTRO'},
              {'id':'right', 'descripcion': 'DERECHA'},
            ];

            vm.rutaImagen = arrToModal.scope.dirImagesBanner + vm.fData.tipo_banner +'/';
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

              BannerServices.sEditarBanner(vm.fData).then(function (rpta) {
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
            BannerServices.sAnularBanner(row.entity).then(function (rpta) {
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

  function BannerServices($http, $q) {
    return({
        sListarBanner: sListarBanner,
        slistarCapasBanner: slistarCapasBanner,
        sRegistrarBanner: sRegistrarBanner,
        sEditarBanner: sEditarBanner,
        sAnularBanner: sAnularBanner,
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
    function slistarCapasBanner(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Banner/cargar_capas_banner",
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
    function sEditarBanner(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Banner/editar_banner",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sAnularBanner(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Banner/anular_banner",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
  }

})();