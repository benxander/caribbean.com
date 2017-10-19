(function() {
  'use strict';
  angular
    .module('minotaur')
    .controller('PerfilController', PerfilController)
    .service('PerfilServices', PerfilServices);

  /** @ngInject */
  function PerfilController($scope,$timeout,$document,PerfilServices,rootServices,ClienteServices,UsuarioServices,IdiomaServices,uiGridConstants, toastr, alertify) {
    var vm = this;
    vm.modoEditar = false;
    vm.fotoCrop = false;
    vm.cambiarClave = false;
    vm.fDataPerfil = {};

    IdiomaServices.sListarIdiomaCbo().then(function(rpta){
      vm.listaIdiomas = rpta.datos;
    });

    vm.cargaPerfil = function(){
      if(!vm.fDataPerfil.idusuario) {
        rootServices.sGetSessionCI().then(function (response) {
          if(response.flag == 1){
            vm.fDataPerfil = response.datos;
            ClienteServices.sListarClientePorIdusuario(vm.fDataPerfil).then(function (response) {
              if(response.flag == 1){
                vm.fDataPerfil = response.datos;
                vm.fDataPerfilCopy = angular.copy(response.datos);
                //console.log('vm.fDataPerfilCopy',vm.fDataPerfilCopy);
              }
            });
          }
        });
      }else{
        ClienteServices.sListarClientePorIdusuario(vm.fDataPerfil).then(function (response) {
          if(response.flag == 1){
            vm.fDataPerfil = response.datos;
            vm.fDataPerfilCopy = angular.copy(response.datos);
            //console.log('vm.fDataPerfilCopy',vm.fDataPerfilCopy);
          }
        });
      }
    }
    vm.cargaPerfil();

    vm.btnCancelarEditPerfil = function(){
      vm.modoEditar = false;
      vm.fDataPerfil = angular.copy(vm.fDataPerfilCopy);
    }

    vm.btnAceptarEditPerfil = function(datos){//datos personales
      ClienteServices.sEditarPerfilCliente(datos).then(function (rpta) {
        if(rpta.flag == 1){
          UsuarioServices.sEditarIdiomaUsuario(datos).then(function (rpta) {
            if(rpta.flag == 1){
              vm.cargaPerfil();
              $scope.gChangeLanguage(datos.ididioma);
              vm.modoEditar = false;
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
        }else if( rpta.flag == 0 ){
          var title = 'Advertencia';
          var type = 'warning';
          toastr.warning(rpta.message, title);
        }else{
          alert('Ocurrió un error');
        }
      });
    }

    //CAMBIAR CONTRASEña
    vm.btnCancelClave = function(){
      vm.fDataPerfil.clave = null;
      vm.fDataPerfil.nuevaclave = null;
      vm.fDataPerfil.password = null;
      vm.cambiarClave = false;
    }

    vm.btnGuardarClave = function(){
      PerfilServices.sEditarClave(vm.fDataPerfil).then(function(rpta){
        if(rpta.flag == 1){
          vm.btnCancelClave();
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

    // SUBIDA DE IMAGENES MEDIANTE IMAGE CROP
    vm.cargarImagen = function(){      
      vm.fotoCrop = true;
      var handleFileSelect=function(evt) {        
        var file = evt.currentTarget.files[0];
        var reader = new FileReader();
        reader.onload = function (evt) {
          /* eslint-disable */
          $('#img-selecionada').attr('src', evt.target.result);           
          /* eslint-enable */
        };
        reader.readAsDataURL(file);
      };
      $timeout(function() { // lo pongo dentro de un timeout sino no funciona
        angular.element($document[0].querySelector('#fileInput2')).on('change',handleFileSelect);
      }/* no delay here */);
    }
    vm.subirFoto = function(){
      vm.fDataPerfil.image =  $('#img-selecionada').attr('src');
      PerfilServices.sSubirFoto(vm.fDataPerfil).then(function(rpta){
        if(rpta.flag == 1){
          var title = 'OK';
          var type = 'success';
          vm.fDataPerfil.nombre_foto = rpta.datos;
          vm.cancelarFoto();
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
    vm.cancelarFoto = function(){
      vm.fotoCrop = false;
      $('#img-selecionada').attr('src', '#');
    }
    vm.eliminarFoto = function(){
      alertify.okBtn("Aceptar").cancelBtn("Cancelar").confirm("¿Realmente desea realizar la acción?", function (ev) {
        ev.preventDefault();
        PerfilServices.sEliminarFoto(vm.fDataPerfil).then(function(rpta){
          if(rpta.flag == 1){
            var title = 'OK';
            var type = 'success';
            vm.fDataPerfil.nombre_foto = rpta.datos;
            vm.cancelarFoto();
            toastr.success(rpta.message, title);
          }else if( rpta.flag == 0 ){
            var title = 'Advertencia';
            var type = 'warning';
            toastr.warning(rpta.message, title);
          }else{
            alert('Ocurrió un error');
          }
        });
      });

    }
  }
  function PerfilServices($http, $q) {
    return({
        sEditarClave: sEditarClave,
        sSubirFoto:sSubirFoto,
        sEliminarFoto:sEliminarFoto,
    });

    function sEditarClave(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Usuario/editar_clave_usuario",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }

    function sSubirFoto(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Usuario/subir_imagen_usuario",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    } 

    function sEliminarFoto(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Usuario/eliminar_imagen_usuario",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
  }
})();