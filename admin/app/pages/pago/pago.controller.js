(function() {
  'use strict';

  angular
    .module('minotaur')
    .controller('PagoController', PagoController)
    .service('PagoServices', PagoServices);

  /** @ngInject */
  function PagoController($scope,$timeout,$window, $uibModal, $stateParams, PagoServices, TiendaServices, ClienteServices, MensajeServices, rootServices, toastr, pageLoading, alertify) {

    var vm = this;
    var scope = $scope;
    vm.cancelaPago = false;
    vm.modoDescargaCompleta = false;
    $scope.dirBase = angular.patchURL;
    console.log('$stateParams.',$stateParams);

    rootServices.sGetSessionCI().then(function (response) {
      if(response.flag == 1){
        vm.fDataUsuario = response.datos;
        vm.cargarMensajes();
        if(!angular.isUndefined($stateParams.id) && !angular.isUndefined(response.datos.token)){
          var idmovimiento = $stateParams.id;
          var token = $stateParams.token;

          if( token == response.datos.token ){
            $scope.actualizarMonto(0);
            $scope.fSessionCI.monedero = 0;
            $scope.actualizarSaldo(false);
            vm.modoSeleccionar = false;
            vm.irCompraExitosa(idmovimiento);
            return;
          }
          vm.cancelaPago = true;
        }else{
          vm.cancelaPago = true;
        }
      }else{
        $window.location.href = $scope.dirBase;
      }
    });
    vm.cargarMensajes = function(){
      MensajeServices.sListarMensajes().then(function(rpta){
        vm.mensajes = rpta.datos;
      });
    }

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
      $scope.actualizarMonto(0);
    }

    vm.irCompraExitosa = function(idmovimiento){
      var id = idmovimiento || null;
      vm.images = null;
      var datos = {
        imagenes : vm.images,
        idmovimiento : id
      }
      pageLoading.start('Loading...');
      TiendaServices.sDescargarArchivosPagados(datos).then(function(rpta){
        pageLoading.stop();
        if(rpta.flag == 1){
          vm.modoDescargaCompleta=true;
          vm.limpiar();
          var title = 'OK';
          var type = 'success';
          toastr.success(rpta.message, title);
          $timeout(function() {
            $window.location.href = $scope.dirBase+'admin/#/app/mi-galeria';
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
    vm.calificar = function(value){
      vm.calificacion = value;
      vm.fDataUsuario.puntos = value;
      ClienteServices.sRegistrarPuntuacion(vm.fDataUsuario).then(function(rpta){
        if(rpta.flag == 1){
          vm.modoCalificacionOk=true;
          var title = 'OK';
          var type = 'success';
          toastr.success(rpta.message, title);
          $timeout(function() {
            $window.location.href = $scope.dirBase+'admin/#/app/mi-galeria';
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

  }

  function PagoServices($http, $q) {
    return({

    });

  }
})();
