(function() {
  'use strict';

  angular
    .module('minotaur')
    .controller('PagesGalleryController', PagesGalleryController)
    .service('PagesGalleryServices', PagesGalleryServices);

  /** @ngInject */
  function PagesGalleryController($scope,$timeout, $window, $uibModal, $state,$stateParams, PagesGalleryServices, rootServices, MensajeServices, TiendaServices, ClienteServices, pageLoading, Socialshare,toastr) {
    var vm = this;
    vm.dirImagesProducto = $scope.dirImages + "producto/";
    $scope.actualizarSeleccion(0,0);
    $scope.actualizarSaldo(false);
    vm.pasarela = false;
    vm.boolVideo = false;
    vm.boolCalificaDisabled = true;
    vm.selectedAll = true;
    vm.images = [];
    vm.cargarGaleria = function(datos,loader){
      var loader = loader || false;
      if(loader){
        pageLoading.start('Loading Gallery...');
        console.log('loading');
      }
      PagesGalleryServices.sListarGaleriaDescargados(datos).then(function(rpta){
        vm.images = rpta.datos;
        angular.forEach(vm.images, function(image) {
          image.selected = vm.selectedAll;
        });
        if(loader){
          pageLoading.stop();
        }
      });
    }
    vm.cargarMensajes = function(){
      MensajeServices.sListarMensajes().then(function(rpta){
        vm.mensajes = rpta.datos;
      });
    }
    rootServices.sGetSessionCI().then(function (response) {
      if(response.flag == 1){
        vm.cargarMensajes();
        vm.fDataUsuario = response.datos;
        vm.cargarGaleria(vm.fDataUsuario, true);
        // vm.cargarProductos();
      }
    });


    vm.isSelected = true;
    vm.fData = {}
    vm.fData.total_a_pagar = 0;
    vm.calificaBool = false;
    vm.productoBool = false;
    vm.producto = {};
    vm.temporal = {};
    vm.temporal.cantidad = 1;
    vm.temporal.isSel = false;
    vm.modoDescargaCompleta = false;

    vm.selectAll = function () {
      if (vm.selectedAll) {
        console.log('sele1',vm.selectedAll);
        vm.selectedAll = false;
        vm.isSelected = false;
      } else {
        console.log('sele2',vm.selectedAll);
        vm.selectedAll = true;
        vm.isSelected = true;
      }

      angular.forEach(vm.images, function(image) {
        image.selected = vm.selectedAll;
      });
    };
    // vm.selectAll();
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
      if( i == vm.images.length ){
        vm.selectedAll = true;
      }else{
        vm.selectedAll = false;
      }

      if (i === 0) {
        vm.isSelected = false;
      }
    };

    vm.limpiar = function(){
      vm.cantidad_adic = 0;
      vm.cantidad_video = 0;
      vm.monto_total = 0.00;
      vm.monto_a_pagar = 0.00;
      vm.monto_descuento = 0.00;
      vm.monto_bonificacion = 0.00;
      vm.monto_adicionales = 0.00;
      vm.monto_adicionales_video = 0.00;
      vm.modoPagar = false;
      vm.selectedAll = false;
      vm.isPagoMonedero = false;
      $scope.actualizarSeleccion(0);
      $scope.actualizarSaldo(false);
    }
    vm.btnDescargarFiles = function(){
      if(!vm.isSelected){
        console.log('no hay seleccionados');
        return;
      }

      angular.forEach(vm.images, function(image,key) {
        if (image.selected) {

          var enlace = document.createElement('a');
          enlace.style.display = "none";
          enlace.href = image.src_share;
          enlace.download = image.nombre_archivo;
          document.body.appendChild(enlace);
          enlace.click();
          enlace.parentNode.removeChild(enlace);
        }
      });
      vm.calificaBool = true;
      vm.fDataUsuario.comentarios = null;
    }
    vm.btnDescargarFile = function(image){
      var enlace = document.createElement('a');
      enlace.style.display = "none";
      enlace.href = image.src_share;
      enlace.download = image.nombre_archivo;
      document.body.appendChild(enlace);
      enlace.click();
      enlace.parentNode.removeChild(enlace);

      /*vm.calificaBool = true;
      vm.fDataUsuario.comentarios = null;*/
    }
    vm.btnDescargarZip =function(){
      pageLoading.start('Processing...');
      PagesGalleryServices.sComprimirSeleccionados(vm.images).then(function(rpta){
        pageLoading.stop();
        if(rpta.flag == 1){
          var enlace = document.createElement('a');
          enlace.style.display = "none";
          enlace.href = rpta.datos.zip;
          enlace.download = rpta.datos.nombre;
          document.body.appendChild(enlace);
          enlace.click();
          enlace.parentNode.removeChild(enlace);

          vm.calificaBool = true;
          vm.fDataUsuario.comentarios = null;
        }else{
          console.log('rpta',rpta);
          var title = 'Warning';
          toastr.warning(rpta.message, title);
        }
      });
    }
    vm.calificar = function(value){
      console.log('click');
      vm.calificacion = value;
      vm.fDataUsuario.puntos = value;
      // vm.modoCalificacionOk=true;
      vm.boolCalificaDisabled = false;

    }
    vm.guardarCalificacion = function(){
      vm.boolCalificaDisabled = true;
      pageLoading.start('Processing ...');
      ClienteServices.sRegistrarPuntuacion(vm.fDataUsuario).then(function(rpta){
        pageLoading.stop();
        if(rpta.flag == 1){
          vm.modoCalificacionOk=true;
          var title = 'OK';
          var type = 'success';
          toastr.success(rpta.message, title);
          $timeout(function() {
            vm.calificaBool = false;
          },2000);
        }else if(rpta.flag == 0){
          var title = 'Warning';
          var type = 'warning';
          toastr.warning(rpta.message, title);
        }else{
          alert('Error inesperado');

        }
      });
    }
    /*vm.btnTerminosCondiciones = function(){
      var modalInstance = $uibModal.open({
        templateUrl: 'app/pages/tienda/terminos.php',
        controllerAs: 'mt',
        size: 'lg',
        backdropClass: 'splash-2 splash-ef-12',
        windowClass: 'splash-2 splash-ef-12',
        // backdrop: 'static',
        // keyboard:false,
        scope: $scope,
        controller: function($scope, $uibModalInstance, arrToModal ){
          var vm = this;
          var paramDatos = {
            idseccion : 6 // terminos y condiciones
          }
          TiendaServices.sListarSeccion(paramDatos).then(function(rpta){
            vm.modalTitle = rpta.datos.titulo;
            vm.contenido = rpta.datos.contenido;
            console.log('rpta',rpta);


          });
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
    }*/
  }

  function PagesGalleryServices($http, $q) {
    return({
        sListarGaleriaDescargados: sListarGaleriaDescargados,
        sComprimirSeleccionados: sComprimirSeleccionados,
    });

    function sListarGaleriaDescargados(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Archivo/listar_galeria_descargados",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sComprimirSeleccionados(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Archivo/comprimir_seleccionados",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
  }
})();
