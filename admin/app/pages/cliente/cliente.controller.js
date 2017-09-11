(function() {
  'use strict';
  angular
    .module('minotaur')
    .controller('ClienteController', ClienteController)
    .service('ClienteServices', ClienteServices);

  /** @ngInject */
  function ClienteController($scope, $uibModal, uiGridConstants, toastr, alertify,
    ClienteServices) {
    var vm = this;
    var openedToasts = [];

    // GRILLA PRINCIPAL
      var paginationOptions = {
        pageNumber: 1,
        firstRow: 0,
        pageSize: 10,
        sort: uiGridConstants.ASC,
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
        { field: 'idcliente', name:'idcliente', displayName: 'ID CLIENTE',  width:90, sort: { direction: uiGridConstants.ASC} },
        { field: 'idusuario', name:'idusuario', displayName: 'ID USUARIO',  width:90 },
        { field: 'nombres', name:'nombres', displayName: 'NOMBRES'},
        { field: 'apellidos', name: 'apellidos', displayName: 'APELLIDOS'},
        { field: 'email', name: 'email', displayName: 'EMAIL',width: 150, enableFiltering: false, enableSorting: false },
        { field: 'whatsapp', name: 'whatsapp', displayName: 'WHATSAPP',width: 120, enableFiltering: false, enableSorting: false },
        { field: 'accion', name:'accion', displayName: 'ACCION', width: 100, enableFiltering: false,
          cellTemplate: '<div class="text-center">' +
          '<button class="btn btn-default btn-sm text-green btn-action" ng-click="grid.appScope.btnEditar(row)" tooltip-placement="left" uib-tooltip="EDITAR" > <i class="fa fa-edit"></i> </button>'+
          '<button class="btn btn-default btn-sm text-red btn-action" ng-click="grid.appScope.btnAnular(row)" tooltip-placement="left" uib-tooltip="ELIMINAR"> <i class="fa fa-trash"></i> </button>' +
          '<button class="btn btn-default btn-sm text-blue btn-action" ng-click="grid.appScope.btnUpload(row)" tooltip-placement="left" uib-tooltip="SUBIR IMAGENES" > <i class="fa fa-upload"></i> </button>'+
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
      ClienteServices.sListarIdioma().then(function (rpta) {
        vm.listaIdiomas = rpta.datos;
        vm.listaIdiomas.splice(0,0,{ id : '', descripcion:'--Seleccione una opción--'});
      });
      // GRUPO
      ClienteServices.sListarGrupo().then(function (rpta) {
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
            vm.listaIdiomas = arrToModal.scope.listaIdiomas;
            vm.listaGrupos = arrToModal.scope.listaGrupos;
            vm.fData.idioma = vm.listaIdiomas[0].id;
            vm.fData.grupo = vm.listaGrupos[0].id;

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
                  //openedToasts.push(toastr.type(rpta.message, title));
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
            vm.modalTitle = 'Edición de Banner';
            vm.listaIdiomas = arrToModal.scope.listaIdiomas;
            vm.listaGrupos = arrToModal.scope.listaGrupos;
            
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
                //openedToasts.push(toastr[type](rpta.message, title));
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
              //openedToasts.push(toastr.type(rpta.message, title));
            });
          },
          function(ev){
            ev.preventDefault();
        });
      }
  }

  function ClienteServices($http, $q) {
    return({
        sListarCliente: sListarCliente,
        sListarIdioma: sListarIdioma,
        sListarGrupo: sListarGrupo,
        sRegistrarCliente: sRegistrarCliente,
        sEditarCliente: sEditarCliente,
        sAnularCliente:sAnularCliente
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
    function sListarIdioma(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Cliente/listar_idioma_cbo",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sListarGrupo(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Cliente/listar_grupo_cbo",
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
  }

})();