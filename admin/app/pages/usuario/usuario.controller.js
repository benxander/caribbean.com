(function() {
  'use strict';
  angular
    .module('minotaur')
    .controller('UsuarioController', UsuarioController)
    .service('UsuarioServices', UsuarioServices);

  /** @ngInject */
  function UsuarioController($scope, $uibModal, uiGridConstants, toastr, alertify,
    UsuarioServices) {
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
        { field: 'idusuario', name:'idusuario', displayName: 'ID USUARIO',  width:90, sort: { direction: uiGridConstants.ASC} },
        { field: 'username', name:'username', displayName: 'NOMBRE USUARIO', },
        { field: 'grupo', name: 'nombre_gr', displayName: 'GRUPO'},
        { field: 'idioma', name:'nombre_id', displayName: 'IDIOMA'},
        { field: 'estado', type: 'object', name: 'estado_us', displayName: 'Estado', maxWidth: 250, enableFiltering: false,
          cellTemplate:'<label style="box-shadow: 1px 1px 0 black; margin: 6px auto; display: block; width: 120px;" class="label {{ COL_FIELD.clase }} ">{{ COL_FIELD.string }}</label>' },
        { field: 'accion', name:'accion', displayName: 'ACCION', width: 130, enableFiltering: false,
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
            'u.idusuario' : grid.columns[1].filters[0].term,
            'u.username' : grid.columns[2].filters[0].term,
            'gr.nombre_gr' : grid.columns[3].filters[0].term,
            'id.nombre_id' : grid.columns[4].filters[0].term,
          }
          vm.getPaginationServerSide();
        });
      }

      paginationOptions.sortName = vm.gridOptions.columnDefs[0].name;
      vm.getPaginationServerSide = function() {
        vm.datosGrid = {
          paginate : paginationOptions
        };
        UsuarioServices.sListarUsuario(vm.datosGrid).then(function (rpta) {
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
      vm.btnEditar = function(row){
        var modalInstance = $uibModal.open({
          templateUrl: 'app/pages/usuario/usuario_formview.php',
          controllerAs: 'mu',
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
              UsuarioServices.sEditarUsuario(vm.fData).then(function (rpta) {
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
            UsuarioServices.sAnularUsuario(row.entity).then(function (rpta) {
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

  }

  function UsuarioServices($http, $q) {
    return({
        sListarUsuario: sListarUsuario,
        sListarIdioma: sListarIdioma,
        sListarGrupo: sListarGrupo,
        sRegistrarUsuario: sRegistrarUsuario,
        sEditarUsuario: sEditarUsuario,
        sAnularUsuario:sAnularUsuario,
        sHabilitarDesabilitarUsuario: sHabilitarDesabilitarUsuario
    });
    function sListarUsuario(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Usuario/listar_usuarios",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sListarIdioma(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Usuario/listar_idioma_cbo",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sListarGrupo(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Usuario/listar_grupo_cbo",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sRegistrarUsuario(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Usuario/registrar_usuario",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sEditarUsuario(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Usuario/editar_usuario",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sAnularUsuario(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Usuario/anular_usuario",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sHabilitarDesabilitarUsuario(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Usuario/habilitar_desabilitar_usuario",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
  }

})();