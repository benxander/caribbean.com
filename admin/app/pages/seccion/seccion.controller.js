(function() {
  'use strict';
  angular
    .module('minotaur')
    .controller('SeccionController', SeccionController)
    .service('SeccionServices', SeccionServices);

  /** @ngInject */
  function SeccionController($scope,tileLoading,SeccionServices,$uibModal, uiGridConstants, toastr, alertify, FileUploader) {
    var vm = this;
    var openedToasts = [];
    //$scope.image = "";
    vm.boolListado = true;
    vm.listaFichas = [];
    // LISTA TIPO DE ICONOS
      SeccionServices.sListarTipoIconosCbo().then(function(rpta){
        vm.listaTiposIconos = rpta.datos;
      });
    // LISTA DE ICONOS
      vm.listarIconosAuto = function (value,tipo) {
        var params = {};
        params.search= value;
        params.tipoIcono= tipo;
        return SeccionServices.sListarIconosAutocomplete(params).then(function(rpta) {
          vm.noResultsLI = false;
          if( rpta.flag === 0 ){
            vm.noResultsLI = true;
          }
          return rpta.datos;
        });
      }
      // vm.listarIconos = function(tipo){
      //   SeccionServices.sListarIconos(tipo).then(function(rpta) {
      //     return rpta.datos;
      //   });
      // }
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
      vm.getPaginationServerSide = function(loader) {
        var loader = loader || false;
        if(loader){
          tileLoading.start();
        }
        vm.datosGrid = {
          paginate : paginationOptions
        };
        SeccionServices.sListarSecciones(vm.datosGrid).then(function (rpta) {
          vm.gridOptions.data = rpta.datos;
          vm.gridOptions.totalItems = rpta.paginate.totalRows;
          vm.mySelectionGrid = [];
          if(loader){
            tileLoading.stop();
          }
        });
      }
      vm.getPaginationServerSide(true);
    // MANTENIMIENTO
      vm.btnEditar = function(row){
        var modalInstance = $uibModal.open({
          templateUrl: 'app/pages/seccion/seccion_formview.php',
          controllerAs: 'ms',
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
                  vm.getPaginationServerSide(true);
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
      vm.listarFichas = function(seccion){
        tileLoading.start();
        SeccionServices.sListarFichas(seccion).then(function (rpta) {
          vm.listaFichas = rpta.datos;
          tileLoading.stop();
          // vm.mySelectionGrid = [];
        });
      }
      vm.verFichas = function(row){
        vm.listaFichas = {};
        vm.boolListado = false;
        vm.seccion = row.entity;
        vm.tituloFichas = 'FICHAS DE ' + vm.seccion.titulo;
        vm.listarFichas(vm.seccion);
      }
      vm.btnNuevaFicha = function(seccion){
        var modalInstance = $uibModal.open({
          templateUrl: 'app/pages/seccion/seccion_ficha_formview.php',
          controllerAs: 'mf',
          size: 'lg',
          backdropClass: 'splash splash-2 splash-ef-16',
          windowClass: 'splash splash-2 splash-ef-16',
          backdrop: 'static',
          keyboard:false,
          controller: function($scope, $uibModalInstance, arrToModal ){
            var vm = this;
            vm.fData = {};
            // vm.fData = angular.copy(arrToModal.seleccion);
            // vm.modoEdicion = true;
            vm.listarFichas = arrToModal.listarFichas;
            vm.listaTiposIconos = arrToModal.scope.listaTiposIconos;
            vm.fData.tipoIcono = vm.listaTiposIconos[0];

            // vm.listarIconos = function(value){
            //   var params = {
            //     search: value,
            //     tipoIcono: vm.fData.tipoIcono
            //   }
            //   return SeccionServices.sListarIconosAutocomplete(params).then(function(rpta) {
            //     $scope.noResultsLPSC = false;
            //     if( rpta.flag === 0 ){
            //       $scope.noResultsLPSC = true;
            //     }
            //     return rpta.datos;
            //   });
            // }
            //vm.listarIconos(vm.fData);

            // vm.listarIconos =  arrToModal.scope.listarIconos;
            // vm.lista = vm.listarIconos(vm.fData);
            // console.log('iconos', vm.listaIconos);

            vm.modalTitle = 'Registro de Ficha';

            vm.fData.idseccioncontenido = seccion.idseccioncontenido;
            vm.ficha_galeria = seccion.ficha_galeria;
            // vm.rutaImagen = arrToModal.scope.dirImagesBanner + vm.fData.tipo_banner +'/';
            console.log('seccion',seccion);
            // console.log('data',vm.fData);
            vm.aceptar = function () {
              SeccionServices.sRegistrarFicha(vm.fData).then(function (rpta) {
                if(rpta.flag == 1){
                  $uibModalInstance.dismiss('cancel');
                  // vm.getPaginationServerSide();
                  var title = 'OK';
                  var type = 'success';
                  $uibModalInstance.close(vm.fData);
                  vm.listarFichas(seccion);
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
                listarFichas : vm.listarFichas,
                seleccion : seccion,
                scope : vm,
              }
            }
          }
        });
      }
      vm.btnEditarFicha = function(item){
        var modalInstance = $uibModal.open({
          templateUrl: 'app/pages/seccion/seccion_ficha_formview.php',
          controllerAs: 'mf',
          size: 'lg',
          backdropClass: 'splash splash-2 splash-ef-16',
          windowClass: 'splash splash-2 splash-ef-16',
          backdrop: 'static',
          keyboard:false,
          controller: function($scope, $uibModalInstance, arrToModal ){
            var vm = this;
            vm.fData = {};
            vm.fData = angular.copy(arrToModal.seleccion);
            // vm.modoEdicion = true;
            vm.listarFichas = arrToModal.listarFichas;
            vm.modalTitle = 'Editar Ficha';
            vm.seccion = arrToModal.scope.seccion;
            vm.ficha_galeria = item.ficha_galeria;
            console.log('item',item);
            vm.aceptar = function () {
              SeccionServices.sEditarFicha(vm.fData).then(function (rpta) {
                if(rpta.flag == 1){
                  $uibModalInstance.dismiss('cancel');
                  var title = 'OK';
                  var type = 'success';
                  $uibModalInstance.close(vm.fData);
                  vm.listarFichas(vm.seccion);
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
                listarFichas : vm.listarFichas,
                seleccion : item,
                scope : vm,
              }
            }
          }
        });
      }
      vm.btnEliminarFicha = function (item) {
        alertify.confirm("¿Realmente desea realizar la acción?",function(ev){
            ev.preventDefault();
            SeccionServices.sEliminarFicha(item).then(function (rpta) {
              if(rpta.flag == 1){
                vm.listarFichas(vm.seccion);
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
      vm.btnGaleria = function(item){
        var modalInstance = $uibModal.open({
          templateUrl: 'app/pages/seccion/seccion_ficha_galeria.php',
          controllerAs: 'mf',
          size: 'lg',
          backdropClass: 'splash splash-2 splash-ef-16',
          windowClass: 'splash splash-2 splash-ef-16',
          controller: function($scope, $uibModalInstance, arrToModal ){
            var vm = this;
            var uploader = $scope.uploader = new FileUploader ({
              url: angular.patchURLCI + 'seccion/upload_galeria'
            });
            vm.fData = {};
            // vm.btnUpload = function(seleccion){
            //   vm.fData = {};
              vm.fDataUpload = {};
              vm.modalTitle = 'Galeria de imagenes';
              vm.fDataUpload = angular.copy(arrToModal.seleccion);
              vm.uploadBtn = false;
              vm.selectedAll = false;
              vm.isSelected = false;
              console.log('arrToModal.seleccion',arrToModal.seleccion);
              vm.subirTodo = function(){
                console.log('subir todo');
                uploader.uploadAll();
              }

              vm.btnVolver = function() {
                vm.fDataUpload = {};
                $uibModalInstance.dismiss('cancel');
                // vm.getPaginationServerSide();
              }

              vm.btnSubir = function() {
                vm.uploadBtn = true;
              }

              vm.btnAnularArchivo = function(row){
                alertify.confirm("¿Realmente desea realizar la acción?",function(ev){
                    ev.preventDefault();
                    SeccionServices.sEliminarImagenFicha(row).then(function (rpta) {
                      if(rpta.flag == 1){
                        var title = 'OK';
                        var type = 'success';
                        toastr.success(rpta.message, title);
                        vm.cargarImagenes();
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

              vm.btnDeleteArchivoSelect = function(){
                alertify.confirm("¿Realmente desea realizar la acción?",function(ev){
                    ev.preventDefault();
                    SeccionServices.sEliminarImagenesFicha(vm.images).then(function (rpta) {
                      if(rpta.flag == 1){
                        var title = 'OK';
                        var type = 'success';
                        toastr.success(rpta.message, title);
                        vm.cargarImagenes();
                        vm.isSelected = false;
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

              vm.cargarImagenes = function(datos){
                SeccionServices.sListarImagenesFicha(vm.fDataUpload).then(function(rpta){
                  vm.images = rpta.datos;
                  vm.length_images = vm.images.length;
                  console.log('vm.length_images',vm.length_images);
                  if (vm.length_images == 0) { vm.uploadBtn = true; };
                });
              }
              vm.cargarImagenes();


              vm.selectAll = function () {
                if (vm.selectedAll) {
                  vm.selectedAll = false;
                  vm.isSelected = false;
                } else {
                  vm.selectedAll = true;
                  vm.isSelected = true;
                }

                angular.forEach(vm.images, function(image) {
                  image.selected = vm.selectedAll;
                });
              }

              vm.selectImage = function(index) {
                var i = 0;

                if (vm.images[index].selected) {
                  vm.images[index].selected = false;
                } else {
                  vm.images[index].selected = true;
                  vm.isSelected = true;
                }

                angular.forEach(vm.images, function(image) {
                  if (image.selected) {
                    i++;
                  }
                });

                if (i === 0) {
                  vm.isSelected = false;
                }
              }
              // CALLBACKS

                uploader.onWhenAddingFileFailed = function(item /*{File|FileLikeObject}*/, filter, options) {
                    console.info('onWhenAddingFileFailed', item, filter, options);
                };
                /*uploader.onAfterAddingFile = function(fileItem) {
                    console.info('onAfterAddingFile', fileItem);
                };*/
                uploader.onAfterAddingAll = function(addedFileItems) {
                    console.info('onAfterAddingAll', addedFileItems);
                };
                uploader.onBeforeUploadItem = function(item) {
                    item.formData.push({
                      idficha: vm.fDataUpload.idficha,
                    });
                    //console.info('onBeforeUploadItem', item);
                };
                /*uploader.onProgressItem = function(fileItem, progress) {
                    console.info('onProgressItem', fileItem, progress);
                };*/
                uploader.onProgressAll = function(progress) {
                    console.info('onProgressAll', progress);
                };
                uploader.onResumen = function(progress) {
                    console.info('onProgressAll', progress);
                };
                uploader.onSuccessItem = function(fileItem, response, status, headers) {
                    console.info('onSuccessItem', fileItem, response, status, headers);

                    if(response.flag == 1){
                        var title = 'OK';
                        var type = 'success';
                        toastr.success(response.message, title);
                      }else if( response.flag == 0 ){
                        var title = 'Advertencia';
                        var type = 'warning';
                        toastr.warning(response.message, title);
                      }else{
                        alert('Ocurrió un error');
                      }
                };
                uploader.onErrorItem = function(fileItem, response, status, headers) {
                    console.info('onErrorItem', fileItem, response, status, headers);
                    if(response.flag == 1){
                      var title = 'OK';
                      var type = 'success';
                      toastr.success(response.message, title);
                    }else if( response.flag == 0 ){
                      var title = 'Advertencia';
                      var type = 'warning';
                      toastr.warning(response.message, title);
                    }else{
                      alert('Ocurrió un error');
                    }
                };
                /*uploader.onCancelItem = function(fileItem, response, status, headers) {
                    console.info('onCancelItem', fileItem, response, status, headers);
                };
                uploader.onCompleteItem = function(fileItem, response, status, headers) {
                    console.info('onCompleteItem', fileItem, response, status, headers);
                };*/
                uploader.onCompleteAll = function() {
                    console.info('onCompleteAll');
                    vm.uploadBtn = false;
                    uploader.clearQueue();
                    vm.cargarImagenes();
                };
            // }
          },
          resolve: {
            arrToModal: function() {
              return {
                seleccion : item,
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
        sListarTipoIconosCbo: sListarTipoIconosCbo,
        sEditarContenido: sEditarContenido,
        sListarFichas: sListarFichas,
        sRegistrarFicha: sRegistrarFicha,
        sEditarFicha: sEditarFicha,
        sEliminarFicha: sEliminarFicha,
        sListarIconos: sListarIconos,
        sListarIconosAutocomplete: sListarIconosAutocomplete,
        sListarImagenesFicha: sListarImagenesFicha,
        sEliminarImagenFicha: sEliminarImagenFicha,
        sEliminarImagenesFicha: sEliminarImagenesFicha,
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
    function sListarTipoIconosCbo(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Seccion/listar_tipo_iconos_cbo",
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
    function sEditarFicha(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Seccion/editar_ficha",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sEliminarFicha(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Seccion/eliminar_ficha",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sListarIconosAutocomplete(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Seccion/listar_iconos_autocomplete",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sListarIconos(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Seccion/listar_iconos",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sListarImagenesFicha(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Seccion/listar_galeria_ficha",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sEliminarImagenFicha(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Seccion/eliminar_imagen_ficha",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sEliminarImagenesFicha(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Seccion/eliminar_imagenes_ficha",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
  }
})();