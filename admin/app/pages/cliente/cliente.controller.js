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
        { field: 'idcliente', name:'idcliente', displayName: 'ID CLIENTE',  width:90, sort: { direction: uiGridConstants.ASC} },
        { field: 'idusuario', name:'idusuario', displayName: 'ID USUARIO',  width:90, visible:false },
        { field: 'nombres', name:'nombres', displayName: 'NOMBRES'},
        { field: 'apellidos', name: 'apellidos', displayName: 'APELLIDOS'},
        { field: 'email', name: 'email', displayName: 'EMAIL',width: 150, enableFiltering: false, enableSorting: false },
        { field: 'whatsapp', name: 'whatsapp', displayName: 'WHATSAPP',width: 120, enableFiltering: false, enableSorting: false },
        { field: 'accion', name:'accion', displayName: 'ACCION', width: 130, enableFiltering: false,
          cellTemplate: '<div class="text-center">' +
          '<button class="btn btn-default btn-sm text-green btn-action" ng-click="grid.appScope.btnEditar(row)" tooltip-placement="left" uib-tooltip="EDITAR" > <i class="fa fa-edit"></i> </button>'+
          '<button class="btn btn-default btn-sm text-red btn-action" ng-click="grid.appScope.btnAnular(row)" tooltip-placement="left" uib-tooltip="ELIMINAR"> <i class="fa fa-trash"></i> </button>' +
          '<button class="btn btn-default btn-sm text-blue btn-action" ng-click="grid.appScope.btnNuevoUsuario(row)" tooltip-placement="left" uib-tooltip="CREAR USUARIO" ng-if="!row.entity.idusuario"> <i class="fa fa-user-o"></i> </button>' +
          '<button class="btn btn-default btn-sm text-blue btn-action" ng-click="grid.appScope.btnUpload(row)" tooltip-placement="left" uib-tooltip="SUBIR IMAGENES" ng-if="row.entity.idusuario"> <i class="fa fa-upload"></i> </button>'+
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
      // GRUPO
      UsuarioServices.sListarGrupo().then(function (rpta) {
        vm.listaGrupos = rpta.datos;
        vm.listaGrupos.splice(0,0,{ id : '', descripcion:'--Seleccione una opción--'});       
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
      vm.btnNuevoUsuario = function (row) {
        var modalInstance = $uibModal.open({
          templateUrl: 'app/pages/usuario/usuario_formview.php',
          controllerAs: 'mu',
          size: 'lg',
          backdropClass: 'splash splash-2 splash-ef-16',
          windowClass: 'splash splash-2 splash-ef-16',
          scope: $scope,
          controller: function($scope, $uibModalInstance, arrToModal ){
            var vm = this;
            vm.fData = {};
            vm.modoEdicion = false;
            vm.getPaginationServerSide = arrToModal.getPaginationServerSide;
            vm.modalTitle = 'Registro de usuario';
            vm.listaIdiomas = arrToModal.scope.listaIdiomas;
            vm.listaGrupos = arrToModal.scope.listaGrupos;
            vm.fData.ididioma = vm.listaIdiomas[0].id;
            vm.fData.idgrupo = vm.listaGrupos[0].id;
            vm.fData.idcliente = row.entity.idcliente;
            vm.fData.username = row.entity.email;

            vm.generarPassword = function (longitud) {
              var caracteres = "abcdefghijkmnpqrtuvwxyzABCDEFGHIJKLMNPQRTUVWXYZ2346789";
              var pass = "";
              for (i=0; i<longitud; i++){
                pass += caracteres.charAt(Math.floor(Math.random()*caracteres.length));
              }
              vm.fData.password = pass;
              console.log(vm.fData.password);
            }
            vm.generarPassword(5);
            // botones
              vm.aceptar = function () {
                UsuarioServices.sRegistrarUsuario(vm.fData).then(function (rpta) {
                  if(rpta.flag == 1){
    
                    var title = 'OK';
                    var type = 'success';
                    toastr.success(rpta.message, title);

                    UsuarioServices.sEnviarMailRegistro(vm.fData).then(function(rpta){
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

      vm.btnUpload = function(row){
        vm.gritdClientes = false;
        vm.fData = {};
        vm.fDataUpload = {};
        vm.fDataUpload = angular.copy(row.entity);
        console.log(vm.fDataUpload);

        // a sync filter
       /* uploader.filters.push({
            name: 'syncFilter',
            fn: function(item , options) {
                console.log('syncFilter');
                return this.queue.length < 10;
            }
        });
      
        // an async filter
        uploader.filters.push({
            name: 'asyncFilter',
            fn: function(item , options, deferred) {
                console.log('asyncFilter');
                setTimeout(deferred.resolve, 1e3);
            }
        });*/
        vm.subirTodo = function(){
          console.log('aqui estoy');
          uploader.uploadAll();
        }
        vm.btnSubirVideo = function(){
          UsuarioServices.sUploadCliente(vm.fData).then(function(rpta){
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
     
        vm.volver = function() {
          vm.gritdClientes = true; 
          vm.fDataUpload = {};
        }

        // CALLBACKS

        uploader.onWhenAddingFileFailed = function(item /*{File|FileLikeObject}*/, filter, options) {
            console.info('onWhenAddingFileFailed', item, filter, options);
        };
        uploader.onAfterAddingFile = function(fileItem) {
            console.info('onAfterAddingFile', fileItem);
        };
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
            console.info('onBeforeUploadItem', item);
        };
        uploader.onProgressItem = function(fileItem, progress) {
            console.info('onProgressItem', fileItem, progress);
        };
        uploader.onProgressAll = function(progress) {
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
        uploader.onCancelItem = function(fileItem, response, status, headers) {
            console.info('onCancelItem', fileItem, response, status, headers);
        };
        uploader.onCompleteItem = function(fileItem, response, status, headers) {
            console.info('onCompleteItem', fileItem, response, status, headers);
        };
        uploader.onCompleteAll = function() {
            console.info('onCompleteAll');
        };

        console.info('uploader', uploader);

      }



  }

  function ClienteServices($http, $q) {
    return({
        sListarCliente: sListarCliente,
        sRegistrarCliente: sRegistrarCliente,
        sEditarCliente: sEditarCliente,
        sAnularCliente: sAnularCliente,
        sUploadCliente: sUploadCliente
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
    function sAnularCliente(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Cliente/anular_cliente",
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
  }

})();