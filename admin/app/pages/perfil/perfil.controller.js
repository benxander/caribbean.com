(function() {
  'use strict';
  angular
    .module('minotaur')
    .controller('PerfilController', PerfilController)
    .service('PerfilServices', PerfilServices);

  /** @ngInject */
  function PerfilController($scope,PerfilServices,rootServices,ClienteServices,UsuarioServices,IdiomaServices,uiGridConstants, toastr, alertify) {
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
      ClienteServices.sEditarCliente(datos).then(function (rpta) {
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
      vm.cambiarClave = false;
      vm.fDataPerfil.clave = null;
      vm.fDataPerfil.nuevaclave = null;
      vm.fDataPerfil.password = null;
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
      vm.image = {
         originalImage: '',
         croppedImage: '',
      };
      vm.cropType='circle';

      var handleFileSelect2=function(evt) {
        var file = evt.currentTarget.files[0];
        var reader = new FileReader();
        reader.onload = function (evt) {
          /* eslint-disable */
          $scope.$apply(function($scope){
            vm.image.originalImage=evt.target.result;
            // vm.image.fotoNueva=evt.target.result;
            console.log("foto", vm.image);
          });
          /* eslint-enable */
        };
        reader.readAsDataURL(file);
      };
      $timeout(function() { // lo pongo dentro de un timeout sino no funciona
        angular.element($document[0].querySelector('#fileInput2')).on('change',handleFileSelect2);
      });
    }
    vm.subirFoto = function(){
      vm.image.nombre_foto = vm.ficha.nombre_foto;
      vm.image.idcliente = vm.ficha.idcliente;
      vm.image.nombre = vm.ficha.nombre;
      PacienteServices.sSubirFoto(vm.image).then(function(rpta){
        if(rpta.flag == 1){
          var title = 'OK';
          var iconClass = 'success';
          vm.ficha.nombre_foto = rpta.datos;
          vm.fotoCrop = false;
          vm.image = {
             originalImage: '',
             croppedImage: '',
          };

        }else if( rpta.flag == 0 ){
          var title = 'Advertencia';
          // vm.toast.title = 'Advertencia';
          var iconClass = 'warning';
          // vm.options.iconClass = {name:'warning'}
        }else{
          alert('Ocurrió un error');
        }
        var toast = toastr[iconClass](rpta.message, title, vm.options);
        openedToasts.push(toast);
      });
    }
    vm.cancelarFoto = function(){
      vm.fotoCrop = false;
      vm.image = {
         originalImage: '',
         croppedImage: '',
      };
    }
    vm.eliminarFoto = function(){
      alertify.okBtn("Aceptar").cancelBtn("Cancelar").confirm("¿Realmente desea realizar la acción?", function (ev) {
        ev.preventDefault();
        PacienteServices.sEliminarFoto(vm.ficha).then(function(rpta){
          if(rpta.flag == 1){
            var title = 'OK';
            var iconClass = 'success';
            vm.ficha.nombre_foto = rpta.datos;
            vm.fotoCrop = false;
            vm.image = {
               originalImage: '',
               croppedImage: '',
            };

          }else if( rpta.flag == 0 ){
            var title = 'Advertencia';
            // vm.toast.title = 'Advertencia';
            var iconClass = 'warning';
            // vm.options.iconClass = {name:'warning'}
          }else{
            alert('Ocurrió un error');
          }
          var toast = toastr[iconClass](rpta.message, title, vm.options);
          openedToasts.push(toast);
        });
      });

    }  
  }
  function PerfilServices($http, $q) {
    return({
        sEditarClave: sEditarClave,
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
  }
})();