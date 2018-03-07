(function() {
  'use strict';
  angular
    .module('minotaur')
    .controller('ClienteController', ClienteController)
    .service('ClienteServices', ClienteServices);

  /** @ngInject */
  function ClienteController($scope, $window, $uibModal,$filter, uiGridConstants, toastr, alertify,tileLoading, pageLoading,
    ClienteServices, ExcursionServices, UsuarioServices, FileUploader,i18nService) {
    var vm = this;
    vm.fBusqueda = {}
    var openedToasts = [];
    vm.gritdClientes = true;
    var uploader = $scope.uploader = new FileUploader ({
      url: angular.patchURLCI + 'cliente/upload_cliente'
      // url: '../application/controllers/upload.php'
    });
    // vm.langs = i18nService.getAllLangs();
    // vm.lang = 'es';
    // vm.description = 'Hola mundo';
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
        { field: 'idexcursion', name:'idexcursion', displayName: 'ID EXCUR.', minWidth: 90, width:90, cellClass:'text-center'},
        { field: 'excursion', name:'descripcion', displayName: 'EXCURSION', minWidth: 130, enableFiltering: false,},
        { field: 'fecha_excursion', name:'fecha_excursion', displayName: 'FECHA',width:100, cellClass:'text-center'},
        { field: 'monedero', name: 'monedero', displayName: 'DEPOSITO',width: 90, enableFiltering: false, enableSorting: false, enableColumnMenus: false, enableColumnMenu: false, cellClass:'text-right' },
        { field: 'monto', name: 'monto', displayName: 'MONTO ($)',width: 100, enableFiltering: false, enableColumnMenu: false, enableSorting: false, cellClass:'text-right' },
        { field: 'estado_obj', type: 'object', name: 'estado_obj', displayName: 'PROCESADO', width: 120, enableFiltering: false, enableSorting: false, enableColumnMenus: false, enableColumnMenu: false, minWidth: 120,
          cellTemplate:'<label style="box-shadow: 1px 1px 0 black; margin: 6px auto; display: block; width: 100px;" class="label {{ COL_FIELD.clase }} ">{{ COL_FIELD.string }}</label>'
        },
        { field: 'video', name: 'video', displayName: 'VIDEO',width: 70, enableFiltering: false, enableSorting: false, enableColumnMenus: false, enableColumnMenu: false,
          cellTemplate: '<div class="text-center text-red" ng-if="row.entity.bool_video">' +
            '<i class="fa fa-video-camera"></i>' +
          '</div>'
         },
        { field: 'accion', name:'accion', displayName: 'ACCIONES', width: 120, enableFiltering: false,
          enableColumnMenus: false, enableColumnMenu: false, enableSorting: false,
          cellTemplate: '<div>' +
          '<button class="btn btn-default btn-sm text-green btn-action" ng-click="grid.appScope.btnEditar(row)" tooltip-placement="left" uib-tooltip="EDITAR" > <i class="fa fa-edit"></i> </button>'+
          '<button class="btn btn-default btn-sm text-blue btn-action" ng-click="grid.appScope.btnUpload(row)" tooltip-placement="left" uib-tooltip="FOTOGRAFIAS" ng-if="row.entity.idcliente"> <i class="halcyon-icon-photo-camera"></i> </button>'+
          '<button class="btn btn-default btn-sm text-red  btn-action" ng-click="grid.appScope.btnDelete(row)" tooltip-placement="left" uib-tooltip="ELIMINAR FOTOS" ng-if="row.entity.archivo"> <i class="fa fa-file-image-o"></i> </button>'+
          // '<button class="btn btn-default btn-sm text-blue  btn-action" ng-click="grid.appScope.btnEnviarEmail(row)" tooltip-placement="left" uib-tooltip="ENVIAR CORREO"> <i class="fa fa-envelope-o"></i> </button>'+

          // '<button class="btn btn-default btn-sm text-red btn-action" ng-click="grid.appScope.btnAnular(row)" tooltip-placement="left" uib-tooltip="ELIMINAR"> <i class="fa fa-trash"></i> </button>' +
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
            'idexcursion' : grid.columns[3].filters[0].term,
            'descripcion' : grid.columns[4].filters[0].term,
            'fecha_excursion' : grid.columns[5].filters[0].term,

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
        ClienteServices.sListarCliente(vm.datosGrid).then(function (rpta) {
          vm.gridOptions.data = rpta.datos;
          vm.gridOptions.totalItems = rpta.paginate.totalRows;
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

    // PROCESADOS
      vm.listaProcesadosFiltro = [
        { id : '0', descripcion : '--TODOS--' },
        { id : '1', descripcion : 'NO PROCESADO' },
        { id : '2', descripcion : 'NO PAGO' },
        { id : '3', descripcion : 'PENDIENTE' },
        { id : '4', descripcion : 'COMPLETO' },
      ];
      vm.fBusqueda.filtroProcesados = vm.listaProcesadosFiltro[0];
    // IDIOMA
      /* UsuarioServices.sListarIdioma().then(function (rpta) {
        vm.listaIdiomas = rpta.datos;
        vm.listaIdiomas.splice(0,0,{ id : '', descripcion:'--Seleccione una opción--'});
      });*/

    // MANTENIMIENTO
      vm.btnNuevo = function () {
        var modalInstance = $uibModal.open({
          templateUrl: 'app/pages/cliente/cliente_formview.php',
          controllerAs: 'mc',
          size: '',
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
            vm.modalTitle = 'Registro de cliente';
            vm.listaIdiomas = arrToModal.scope.listaIdiomas;
            // vm.fData.ididioma = vm.listaIdiomas[0].id;
            vm.listaExcursiones = arrToModal.scope.listaExcursiones;
            vm.listaExcursiones.splice(0,0,{ id : '', descripcion:'--Seleccione--'});
            vm.fData.excursion = vm.listaExcursiones[0];
            var hoy = new Date();
            vm.fData.fecha_excursion = $filter('date')(hoy,'dd-MM-yyyy');
            // botones
              vm.aceptar = function () {
                pageLoading.start('Procesando...');
                ClienteServices.sRegistrarCliente(vm.fData).then(function (rpta) {
                  pageLoading.stop();
                  if(rpta.flag == 1){
                    toastr.success(rpta.message, 'OK');
                    $uibModalInstance.close(vm.fData);
                    vm.getPaginationServerSide();
                  }else if( rpta.flag == 0 ){
                    var title = 'Advertencia';
                    var type = 'warning';
                    toastr.warning(rpta.message, title);
                  }else{
                    alert('Ocurrió un error');
                  }
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
          templateUrl: 'app/pages/cliente/cliente_formview.php',
          controllerAs: 'mc',
          size: '',
          backdropClass: 'splash splash-2 splash-ef-16',
          windowClass: 'splash splash-2 splash-ef-16',
          backdrop: 'static',
          keyboard:false,
          controller: function($scope, $uibModalInstance, arrToModal ){
            var vm = this;
            // vm.listaIdiomas = arrToModal.scope.listaIdiomas;
            vm.fData = {};
            vm.fData = angular.copy(arrToModal.seleccion);
            vm.listaExcursiones = arrToModal.scope.listaExcursiones;
            var objIndex = vm.listaExcursiones.filter(function(obj) {
              return obj.id == vm.fData.idexcursion;
            }).shift();
            vm.fData.excursion = objIndex;
            console.log('vm.fData',vm.fData);
            vm.modoEdicion = true;
            vm.getPaginationServerSide = arrToModal.getPaginationServerSide;
            vm.modalTitle = 'Edición de Cliente';

            // ExcursionServices.sListarExcursionesCliente(vm.fData).then(function(rpta){
            //   vm.fData.idexcursion = rpta.datos;
            // });
            // vm.fData.idexcursion = ["1","5"];

            vm.aceptar = function () {
              pageLoading.start('Procesando...');
              ClienteServices.sEditarCliente(vm.fData).then(function (rpta) {
                pageLoading.stop();
                if(rpta.flag == 1){
                  $uibModalInstance.dismiss('cancel');
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
      vm.btnAnular = function(){
        alertify.confirm("¿Realmente desea realizar la acción?",function(ev){
            ev.preventDefault();
            ClienteServices.sAnularCliente(vm.mySelectionGrid).then(function (rpta) {
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
          },
          function(ev){
            ev.preventDefault();
        });
      }
      vm.btnDelete = function(row){
        alertify.confirm("¿Realmente desea realizar la acción?",function(ev){
            ev.preventDefault();
            ClienteServices.sDelete(row.entity).then(function (rpta) {
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
          },
          function(ev){
            ev.preventDefault();
        });
      }
      /*vm.btnOrganizarImagenes = function(){
        alertify.confirm("¿Realmente desea realizar la acción?",function(ev){
            ev.preventDefault();
            pageLoading.start('Procesando...puede tardar unos minutos');

            ClienteServices.sOrganizarImagenes().then(function (rpta) {
              pageLoading.stop();
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
          },
          function(ev){
            ev.preventDefault();
        });
      }*/
      vm.btnUpload = function(row){
        vm.gritdClientes = false;
        vm.uploadBtn = false;
        vm.fData = {};
        vm.fDataUpload = {};
        vm.fDataUpload = angular.copy(row.entity);
        vm.imageVideos = '../uploads/player.jpg';
        vm.selectedAll = false;
        vm.isSelected = false;
        vm.images = [];
        vm.subirTodo = function(){
          console.log('subir todo');
          uploader.uploadAll();
        }

        vm.btnVolver = function() {
          vm.gritdClientes = true;
          vm.fDataUpload = {};
          vm.getPaginationServerSide();
        }

        vm.btnSubir = function() {
          vm.uploadBtn = true;
        }

        vm.btnAnularArchivo = function(row){
          alertify.confirm("¿Realmente desea realizar la acción?",function(ev){
              ev.preventDefault();
              ClienteServices.sAnularArchivo(row).then(function (rpta) {
                if(rpta.flag == 1){
                  vm.getPaginationServerSide();
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
              ClienteServices.sDeleteArchivoSelect(vm.images).then(function (rpta) {
                if(rpta.flag == 1){
                  vm.getPaginationServerSide();
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
          ClienteServices.sListarImagenes(vm.fDataUpload).then(function(rpta){
            vm.imgs = rpta.datos;
            var num = 10;
            // vm.images = rpta.datos;
            vm.length_images = vm.imgs.length;
            // vm.length_images = vm.images.length;
            if (vm.length_images == 0) { vm.uploadBtn = true; };

            if(vm.imgs.length>=num){
              for (var i = 0; i < num; i++) {
                vm.images.push(vm.imgs[i]);
              }
            }else{
              vm.images = rpta.datos;
            }
          });
        }
        vm.loadMore = function(){
          if(angular.isObject(vm.imgs) && (vm.imgs.length != vm.images.length)){
            console.log('cargando mas...');
            var last = vm.images.length;
            var dif = vm.imgs.length - vm.images.length;
            var num = 5;
            if( dif >= num ){
              for (var i = 0; i < num; i++) {
                vm.images.push(vm.imgs[last+i]);
              }
            }else{
              for (var i = 0; i < dif; i++) {
                vm.images.push(vm.imgs[last+i]);
              }
            }
          }
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

        vm.videosView = function (video) {
          var modalInstance = $uibModal.open({
            templateUrl: 'app/pages/cliente/videos_view.php',
            controllerAs: 'mcv',
            size: 'lg',
            backdropClass: 'splash splash-1 splash-ef-1',
            windowClass: 'splash splash-1 splash-ef-1',
            scope: $scope,
            controller: function($scope, $uibModalInstance, arrToModal ){
              var vm = this;
              vm.fData = {};
              vm.fData = video;
              vm.fData.type = 'video/' + vm.fData.nombre_archivo.split(".")[1];
              vm.modalTitle = '';
              console.log(vm.fData);
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
              idcliente: vm.fDataUpload.idcliente,
              idusuario: vm.fDataUpload.idusuario,
              nombres: vm.fDataUpload.nombres,
              apellidos: vm.fDataUpload.apellidos,
              codigo: vm.fDataUpload.codigo,
              idexcursioncliente: vm.fDataUpload.idexcursioncliente,
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
      vm.btnEnviarEmail = function(row){
        console.log('row.entity',row.entity);
        var paramDatos = {
            idtipoemail : 2,
            ididioma : row.entity.ididioma,
            codigo : row.entity.codigo,
            email : row.entity.email,
          }
        UsuarioServices.sEnviarMailUsuario(paramDatos).then(function(rpta){
          if(rpta.flag == 1){
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
      vm.btnImportarExcel = function () {
        var modalInstance = $uibModal.open({
          templateUrl: 'app/pages/cliente/subir_excel_modal.php',
          controllerAs: 'mc',
          size: 'md',
          backdropClass: 'splash splash-2 splash-ef-16',
          windowClass: 'splash splash-2 splash-ef-16',
          backdrop: 'static',
          keyboard:false,
          scope: $scope,
          controller: function($scope, $uibModalInstance, arrToModal ){
            var vm = this;
            vm.fData = {};
            var uploader = $scope.uploader = new FileUploader ({
              url: angular.patchURLCI + 'cliente/upload_excel'
              // url: '../application/controllers/upload.php'
            });
            vm.getPaginationServerSide = arrToModal.getPaginationServerSide;
            vm.modalTitle = 'Importación de clientes';

            // botones
              vm.aceptar = function () {
                console.log('uploader.queue',uploader.queue);
                uploader.queue[0].upload();
                pageLoading.start('Procesando...');
                uploader.onSuccessItem = function(fileItem, response, status, headers) {
                  console.info('onSuccessItem', fileItem, response, status, headers);
                  pageLoading.stop();
                  if(response.flag == 1){
                      var title = 'OK';
                      var type = 'success';
                      toastr.success(response.message, title);
                       $uibModalInstance.close();
                       vm.getPaginationServerSide();
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
                    pageLoading.stop();
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
      vm.btnProcesarZip = function () {
        var modalInstance = $uibModal.open({
          templateUrl: 'app/pages/cliente/upzip_modal.php',
          controllerAs: 'mz',
          size: 'md',
          backdropClass: 'splash splash-2 splash-ef-16',
          windowClass: 'splash splash-2 splash-ef-16',
          backdrop: 'static',
          keyboard:false,
          scope: $scope,
          controller: function($scope, $uibModalInstance, arrToModal ){
            var vm = this;
            vm.fData = {};
            var uploader = $scope.uploader = new FileUploader ({
              url: angular.patchURLCI + 'cliente/upload_zip_ftp'
              // url: '../application/controllers/upload.php'
            });
            vm.getPaginationServerSide = arrToModal.getPaginationServerSide;
            vm.modalTitle = 'Procesar fotografias y videos';

            // botones
              vm.aceptar = function () {
                // console.log('rutaArchivo',vm.rutaArchivo);
                // uploader.queue[0].upload();
                pageLoading.start('Procesando, puede tardar unos minutos...');
                var params = {
                  imagenes : angular.isString(vm.rutaArchivo)?vm.rutaArchivo:'',
                  videos : angular.isString(vm.rutaVideo)?vm.rutaVideo:'',
                }
                ClienteServices.sOrganizarImagenes(params).then(function(rpta){
                  pageLoading.stop();
                  if( rpta.flag != -1 ){
                    if(rpta.flag == 1){
                      var title = 'OK';
                      var type = 'success';
                      toastr.success(rpta.message, title);
                      $uibModalInstance.close();
                      // vm.nombreArchivoSubido = rpta.nombreArchivo;
                    }else if( rpta.flag == 0 ){
                      var title = 'Advertencia';
                      var type = 'warning';
                      toastr.warning(rpta.message, title);
                    }else{
                      alert('Ocurrió un error');
                    }
                  }
                  if( rpta.flag2 != -1 ){
                    if(rpta.flag2 == 1){
                      var title = 'OK';
                      var type = 'success';
                      toastr.success(rpta.message2, title);
                      $uibModalInstance.close();
                      // vm.nombreArchivoSubido = rpta.nombreArchivo;
                    }else if( rpta.flag2 == 0 ){
                      var title = 'Advertencia';
                      var type = 'warning';
                      toastr.warning(rpta.message2, title);
                    }else{
                      alert('Ocurrió un error');
                    }
                  }
                  vm.getPaginationServerSide();
                });
                /*uploader.onSuccessItem = function(fileItem, response, status, headers) {
                  console.info('onSuccessItem', fileItem, response, status, headers);
                  pageLoading.stop();
                  if(response.flag == 1){
                      var title = 'OK';
                      var type = 'success';
                      toastr.success(response.message, title);
                       $uibModalInstance.close();
                       vm.getPaginationServerSide();
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
                    pageLoading.stop();
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
                };*/
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
      vm.btnExportarListaPdf = function () {
        pageLoading.start('Procesando...');
        var params = {
          paginate : paginationOptions,
          datos: vm.fBusqueda
        };
        ClienteServices.sImprimirClientes(params).then(function(rpta){
          pageLoading.stop();
          if(rpta.flag == 1){
            console.log('pdf...');
            $window.open(rpta.urlTempPDF, '_blank');
          }
        });
      };
  }

  function ClienteServices($http, $q) {
    return({
        sListarCliente: sListarCliente,
        sListarClientePorIdusuario:sListarClientePorIdusuario,
        sRegistrarCliente: sRegistrarCliente,
        sEditarCliente: sEditarCliente,
        sEditarDatosAdicionalesCliente: sEditarDatosAdicionalesCliente,
        sEditarPerfilCliente: sEditarPerfilCliente,
        sAnularCliente: sAnularCliente,
        sAnularArchivo: sAnularArchivo,
        sDeleteArchivoSelect: sDeleteArchivoSelect,
        sUploadCliente: sUploadCliente,
        sListarImagenes: sListarImagenes,
        sDelete: sDelete,
        sRegistrarPuntuacion : sRegistrarPuntuacion,
        sActualizarMonedero : sActualizarMonedero,
        sOrganizarImagenes : sOrganizarImagenes,
        sImprimirClientes : sImprimirClientes,
        sUploadPrueba : sUploadPrueba,
    });
    function sListarCliente(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Cliente/listar_clientes",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sListarClientePorIdusuario(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Cliente/listar_cliente_por_idusuario",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sRegistrarCliente(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Cliente/registrar_cliente",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sRegistrarUsuario(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Cliente/registrar_usuario",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sEditarCliente(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Cliente/editar_cliente",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sEditarDatosAdicionalesCliente(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Cliente/editar_datos_adicionales_cliente",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sEditarPerfilCliente(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Cliente/editar_perfil_cliente",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sAnularCliente(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Cliente/anular_cliente",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sAnularArchivo(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Cliente/anular_archivo",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sDeleteArchivoSelect(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Cliente/delete_archivo_select",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sDelete(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Cliente/delete_archivo",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sUploadCliente(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Cliente/upload_cliente",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sListarImagenes (pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Cliente/lista_imagenes",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sRegistrarPuntuacion (pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Cliente/registrar_puntuacion",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sActualizarMonedero (pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Cliente/actualizar_monedero",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sOrganizarImagenes (pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Cliente/organizar_imagenes_temporales",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sImprimirClientes (pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Cliente/imprimir_clientes",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sUploadPrueba (pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Cliente/upload_zip_ftp",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
  }

})();