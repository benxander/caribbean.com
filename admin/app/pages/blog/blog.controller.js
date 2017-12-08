(function() {
  'use strict';
  angular
    .module('minotaur')
    .controller('BlogController', BlogController)
    .service('BlogServices', BlogServices);

  /** @ngInject */
  function BlogController($scope,$uibModal,BlogServices,toastr,alertify, uiGridConstants, FileUploader) {
    var vm = this;
    var openedToasts = [];
    vm.fData = {}
    vm.gridBlog = true;
    var uploader = $scope.uploader = new FileUploader ({
      url: angular.patchURLCI + 'blog/upload_galeria'
      // url: '../application/controllers/upload.php'
    });
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

        { field: 'fecha_f', name:'fecha', displayName: 'FECHA', enableFiltering: false, minWidth: 80, width: 100 },
        { field: 'titulo', name:'titulo', displayName: 'TITULO', minWidth: 100 },
        { field: 'descripcion_f', name:'descripcion', displayName: 'DESCRIPCION', minWidth: 100 },

        { field: 'accion', name:'accion', displayName: 'ACCION', width: 120, enableFiltering: false,
          cellTemplate: '<div class="text-center">' +
          '<button class="btn btn-default btn-sm text-green btn-action" ng-click="grid.appScope.btnEditar(row)" tooltip-placement="left" uib-tooltip="EDITAR" > <i class="fa fa-edit"></i> </button>'+
          '<button class="btn btn-default btn-sm text-blue btn-action" ng-click="grid.appScope.btnUpload(row)" tooltip-placement="left" uib-tooltip="GALERIA"> <i class="halcyon-icon-photo-camera"></i> </button>'+
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
            'bl.titulo' : grid.columns[3].filters[0].term,
            'bl.descripcion' : grid.columns[4].filters[0].term,
            'bl.autor' : grid.columns[5].filters[0].term,
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

    vm.btnUpload = function(row){
      vm.gridBlog = false;
      vm.uploadBtn = false;
      vm.fData = {};
      vm.fDataUpload = {};
      vm.fDataUpload = angular.copy(row.entity);
      vm.selectedAll = false;
      vm.isSelected = false;

      vm.subirTodo = function(){
        console.log('subir todo');
        uploader.uploadAll();
      }

      vm.btnVolver = function() {
        vm.gridBlog = true;
        vm.fDataUpload = {};
        vm.getPaginationServerSide();
      }

      vm.btnSubir = function() {
        vm.uploadBtn = true;
      }

      vm.btnAnularArchivo = function(row){
                alertify.confirm("¿Realmente desea realizar la acción?",function(ev){
                    ev.preventDefault();
                    BlogServices.sEliminarImagenBlog(row).then(function (rpta) {
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
                    BlogServices.sEliminarImagenesBlog(vm.images).then(function (rpta) {
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
        BlogServices.sListarImagenesBlog(vm.fDataUpload).then(function(rpta){
          vm.images = rpta.datos;
          vm.length_images = vm.images.length;
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
              idblog: vm.fDataUpload.idblog,
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
    }

  }
  function BlogServices($http, $q) {
    return({
        sListarNoticias: sListarNoticias,
        sRegistrarNoticia: sRegistrarNoticia,
        sEditarNoticia: sEditarNoticia,
        sAnularNoticia: sAnularNoticia,
        sListarImagenesBlog: sListarImagenesBlog,
        sEliminarImagenBlog: sEliminarImagenBlog,
        sEliminarImagenesBlog: sEliminarImagenesBlog,
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
    function sListarImagenesBlog(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Blog/cargar_imagenes_blog",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sEliminarImagenBlog(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Blog/eliminar_imagen_blog",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sEliminarImagenesBlog(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Blog/eliminar_imagenes_blog",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
  }
})();