(function() {
  'use strict';
  angular
    .module('minotaur')
    .controller('ClienteController', ClienteController)
    .service('ClienteServices', ClienteServices);

  /** @ngInject */
  function ClienteController($scope, $uibModal, uiGridConstants, toastr, alertify,
    ClienteServices, UsuarioServices, FileUploader) {
    var vm = this;
    var openedToasts = [];
    vm.gritdClientes = true;
    var uploader = $scope.uploader = new FileUploader ({
      url: angular.patchURLCI + 'cliente/upload_cliente'
      // url: '../application/controllers/upload.php'
    });
    // GRILLA PRINCIPAL
      var paginationOptions = {
        pageNumber: 1,
        firstRow: 0,
        pageSize: 10,
        sort: uiGridConstants.ASC,
        sortName: null,
        search: null
      };

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
        { field: 'idcliente', name:'idcliente', displayName: 'ID CLIENTE',  width:90, sort: { direction: uiGridConstants.ASC}, visible:false },
        { field: 'codigo', name:'codigo', displayName: 'CODIGO',  width:80, visible:true },
        { field: 'nombres', name:'nombres', displayName: 'NOMBRES'},
        { field: 'apellidos', name: 'apellidos', displayName: 'APELLIDOS'},
        { field: 'email', name: 'email', displayName: 'EMAIL', enableFiltering: false, enableSorting: false },
        { field: 'monedero', name: 'monedero', displayName: 'MONEDERO',width: 110, enableFiltering: false, enableSorting: false },
        { field: 'accion', name:'accion', displayName: 'ACCIONES', width: 190, enableFiltering: false,
          cellTemplate: '<div>' +
          '<button class="btn btn-default btn-sm text-green btn-action" ng-click="grid.appScope.btnEditar(row)" tooltip-placement="left" uib-tooltip="EDITAR" > <i class="fa fa-edit"></i> </button>'+
          '<button class="btn btn-default btn-sm text-blue btn-action" ng-click="grid.appScope.btnUpload(row)" tooltip-placement="left" uib-tooltip="FOTOGRAFIAS" ng-if="row.entity.idusuario"> <i class="halcyon-icon-photo-camera"></i> </button>'+
          '<button class="btn btn-default btn-sm text-red  btn-action" ng-click="grid.appScope.btnDelete(row)" tooltip-placement="left" uib-tooltip="ELIMINAR FOTOS" ng-if="row.entity.archivo"> <i class="fa fa-file-image-o"></i> </button>'+
          '<button class="btn btn-default btn-sm text-blue  btn-action" ng-click="grid.appScope.btnEnviarEmail(row)" tooltip-placement="left" uib-tooltip="ENVIAR CORREO"> <i class="fa fa-envelope-o"></i> </button>'+
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
            'c.idcliente' : grid.columns[1].filters[0].term,
            'c.idusuario' : grid.columns[2].filters[0].term,
            'c.nombres' : grid.columns[3].filters[0].term,
            'c.apellidos' : grid.columns[4].filters[0].term,
          }
          vm.getPaginationServerSide();
        });
      }

      paginationOptions.sortName = vm.gridOptions.columnDefs[0].name;
      vm.getPaginationServerSide = function() {
        vm.datosGrid = {
          paginate : paginationOptions
        };
        ClienteServices.sListarCliente(vm.datosGrid).then(function (rpta) {
          vm.gridOptions.data = rpta.datos;
          vm.gridOptions.totalItems = rpta.paginate.totalRows;
          vm.mySelectionGrid = [];
        });
      }
      vm.getPaginationServerSide();

      // IDIOMA
      UsuarioServices.sListarIdioma().then(function (rpta) {
        vm.listaIdiomas = rpta.datos;
        vm.listaIdiomas.splice(0,0,{ id : '', descripcion:'--Seleccione una opción--'});
      });

      // MANTENIMIENTO
      vm.btnNuevo = function () {
        var modalInstance = $uibModal.open({
          templateUrl: 'app/pages/cliente/cliente_formview.php',
          controllerAs: 'mc',
          size: 'lg',
          backdropClass: 'splash splash-2 splash-ef-16',
          windowClass: 'splash splash-2 splash-ef-16',
          scope: $scope,
          controller: function($scope, $uibModalInstance, arrToModal ){
            var vm = this;
            vm.fData = {};
            vm.modoEdicion = false;
            vm.getPaginationServerSide = arrToModal.getPaginationServerSide;
            vm.modalTitle = 'Registro de cliente';
            vm.listaIdiomas = arrToModal.scope.listaIdiomas;
            vm.fData.ididioma = vm.listaIdiomas[0].id;

            // botones
              vm.aceptar = function () {
                ClienteServices.sRegistrarCliente(vm.fData).then(function (rpta) {
                  if(rpta.flag == 1){
                    $uibModalInstance.close(vm.fData);
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
          size: 'lg',
          backdropClass: 'splash splash-2 splash-ef-16',
          windowClass: 'splash splash-2 splash-ef-16',
          controller: function($scope, $uibModalInstance, arrToModal ){
            var vm = this;
            vm.fData = {};
            vm.fData = angular.copy(arrToModal.seleccion);
            vm.modoEdicion = true;
            vm.getPaginationServerSide = arrToModal.getPaginationServerSide;
            vm.modalTitle = 'Edición de Cliente';
            vm.listaIdiomas = arrToModal.scope.listaIdiomas;

            vm.aceptar = function () {
              ClienteServices.sEditarCliente(vm.fData).then(function (rpta) {
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
      vm.btnAnular = function(row){
        alertify.confirm("¿Realmente desea realizar la acción?",function(ev){
            ev.preventDefault();
            ClienteServices.sAnularCliente(row.entity).then(function (rpta) {
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
      vm.btnUpload = function(row){
        vm.gritdClientes = false;
        vm.uploadBtn = false;
        vm.fData = {};
        vm.fDataUpload = {};
        vm.fDataUpload = angular.copy(row.entity);
        vm.imageVideos = '../uploads/player.jpg';
        vm.selectedAll = false;
        vm.isSelected = false;

        vm.subirTodo = function(){
          console.log('aqui estoy');
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
            vm.images = rpta.datos;
            vm.length_images = vm.images.length;
            if (vm.length_images == 0) { vm.uploadBtn = true; };
          });
        }
        vm.cargarImagenes();

        vm.btnSubirImagenesCarpeta = function(datos){
          ClienteServices.sSubirImagenesCarpeta(vm.fDataUpload).then(function(rpta){
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
        }

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
        UsuarioServices.sEnviarMailRegistro(row.entity).then(function(rpta){
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
  }

  function ClienteServices($http, $q) {
    return({
        sListarCliente: sListarCliente,
        sListarClientePorIdusuario:sListarClientePorIdusuario,
        sRegistrarCliente: sRegistrarCliente,
        sEditarCliente: sEditarCliente,
        sEditarPerfilCliente: sEditarPerfilCliente,
        sAnularCliente: sAnularCliente,
        sAnularArchivo: sAnularArchivo,
        sDeleteArchivoSelect: sDeleteArchivoSelect,
        sUploadCliente: sUploadCliente,
        sListarImagenes: sListarImagenes,
        sSubirImagenesCarpeta: sSubirImagenesCarpeta,
        sDelete: sDelete,
        sRegistrarPuntuacion:sRegistrarPuntuacion,
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
    function sSubirImagenesCarpeta (pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Cliente/subir_imagenes_carpeta",
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
  }

})();