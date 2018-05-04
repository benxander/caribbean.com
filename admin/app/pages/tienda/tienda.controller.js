(function() {
  'use strict';

  angular
    .module('minotaur')
    .controller('TiendaController', TiendaController)
    .service('TiendaServices', TiendaServices
      );

  /** @ngInject */
  function TiendaController($scope,$window,$timeout, $uibModal, $stateParams, TiendaServices, ClienteServices, ExcursionServices, MensajeServices, rootServices,toastr, pageLoading, alertify) {

    var vm = this;
    var scope = $scope;
    vm.dirImagesProducto = $scope.dirImages + "producto/";
    vm.seleccionadas = 0;
    vm.modoSeleccionar = true;
    vm.modoPagar = false;
    vm.modoDescargaCompleta = false;
    vm.monto = 0;
    vm.alertAdicionales = false;
    vm.isPagoMonedero = false;
    vm.paqueteSeleccionado = {};
    vm.selectedAll = false;
    vm.isSelected = false;
    vm.selectedTerminos = false;

    vm.cantidad_adic = 0;
    vm.cantidad_video = 0;
    vm.monto_total = 0.00;
    vm.monto_a_pagar = 0.00;
    vm.monto_descuento = 0.00;
    vm.monto_bonificacion = 0.00;
    vm.monto_adicionales = 0.00;
    vm.monto_adicionales_video = 0.00;
    vm.precio_adicional = 0;
    vm.esPack = false;
    vm.esIndividual = false;
    vm.pasarela = false;
    vm.fData = {}
    console.log('$stateParams.',$stateParams);

    rootServices.sGetSessionCI().then(function (response) {
      if(response.flag == 1){
        vm.fDataUsuario = response.datos;
        vm.cargarMensajes();
        /*if(!angular.isUndefined($stateParams.id) && !angular.isUndefined(response.datos.token)){
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
        }*/
        vm.cargarExcursiones();
        vm.cargarGaleria(vm.fDataUsuario);
      }else{
        $window.location.href = $scope.dirBase+'zona-privada';
      }
    });
    vm.cargarMensajes = function(){
      MensajeServices.sListarMensajes().then(function(rpta){
        vm.mensajes = rpta.datos;
      });
    }
    vm.cargarGaleria = function(datos){
      pageLoading.start('Loading...');
      TiendaServices.sListarNoDescargados(datos).then(function(rpta){
        vm.images = rpta.datos;
        pageLoading.stop();
      });
    }
    vm.cargarExcursiones = function(){
      ExcursionServices.sListarExcursionPaquetesSesion().then(function(rpta){
        console.log(rpta.datos);
        vm.listaExcursiones = rpta.datos;
        // vm.listaPaquetes = vm.listaExcursiones[0].paquetes;
        // vm.paqueteSeleccionado = vm.listaPaquetes[0];
        vm.monto = vm.listaExcursiones[0].precio_pack;
        vm.monto_paquete = vm.listaExcursiones[0].precio_pack;
        vm.precio_adicional = vm.listaExcursiones[0].precio_adicional;
        vm.precio_primera = vm.listaExcursiones[0].precio_primera;
        if( vm.listaExcursiones[0].oferta ){
          vm.btnVerOferta();
        }
      });
    }
    vm.selPaquete = function(){
      if((vm.radioModel == 'Pack' && vm.esPack) || (vm.radioModel == 'Sueltas' && vm.esIndividual )){
        return false;
      }
      if(vm.radioModel == 'Pack'){
        vm.esPack = true;
        vm.esIndividual = false;
        vm.selectAll();
      }else if(vm.radioModel == 'Sueltas'){
        vm.esPack = false;
        vm.esIndividual = true;
        vm.selectAll();
      }
    }
    vm.actualizaMontoPaquete =  function(){
      if(vm.isPagoMonedero){
        $scope.actualizarSaldo(false);
        $scope.actualizarSaldo(true,vm.monto);
      }
    }
    vm.selectAll = function () {
      if (vm.selectedAll && vm.esIndividual) {
        console.log('todas -> sueltas');
        vm.selectedAll = false;
        vm.isSelected = false;
        $scope.actualizarMonto(0);
        $scope.actualizarSaldo(false);
      } else if(!vm.selectedAll && vm.esPack) {
        console.log('else if');
        vm.selectedAll = true;
        vm.isSelected = true;
        vm.monto = vm.monto_paquete;
        $scope.actualizarMonto(vm.monto);
        $scope.actualizarSaldo(true,vm.monto);
      }
      var i=0;
      angular.forEach(vm.images, function(image) {
        if(image.descargado == 2){
          image.selected = vm.selectedAll;
          i++;
        }
      });
      if(!vm.isSelected){
        i=0;
      }
      vm.seleccionadas = i;
      $scope.actualizarSeleccion(i);
    };
    vm.selectImage = function(index) {
      if(vm.esPack || !vm.esIndividual){
        return false;
      }
      var i = 0;
      var add = false;

      if (vm.images[index].selected) {
        vm.images[index].selected = false;
        add = false;
      } else {
        vm.images[index].selected = true;
        vm.isSelected = true;
        add = true;
      }
      angular.forEach(vm.images, function(image) {
        if (image.selected) {
          i++;
        }
      });

      if (i === 0) {
        vm.isSelected = false;
        $scope.actualizarMonto(0);
        $scope.actualizarSaldo(false);
      }else if(i == 1){
        console.log('foto suelta');
        $scope.actualizarMonto(vm.precio_primera);
        $scope.actualizarSaldo(true,vm.precio_primera);
        vm.monto = vm.precio_primera;
      }else if(i > 1){
        var monto_total = (i - 1)*vm.precio_adicional + vm.precio_primera;
        $scope.actualizarMonto(monto_total);
        $scope.actualizarSaldo(true,monto_total);
        vm.monto = monto_total;
      }
      vm.seleccionadas = i;
      $scope.actualizarSeleccion(i);
    };
    vm.verResumen = function(){

      if(!vm.isSelected){
        return;
      }
      pageLoading.start('Loading...');
      vm.listaImagenes = [];
      angular.forEach(vm.images, function(image) {
        if (image.selected) {
          vm.listaImagenes.push(image);
        }
      });
      var datos = {
        seleccion : vm.images,
        usuario : vm.fDataUsuario
      }
      TiendaServices.sVerificarSeleccion(datos).then(function(rpta){
        pageLoading.stop();
        vm.modoPagar=true;
        if( rpta.flag == 0 ){
          var title = 'Advertencia';
          var type = 'warning';
          toastr.warning(rpta.message, title);
          location.reload();
        }
      });
      vm.calcularTotales = function(){
        vm.monto_total = vm.monto;
        vm.restante = parseFloat($scope.fSessionCI.monedero - vm.monto);
        if(vm.restante < 0){
          vm.monto_a_pagar = Math.abs(vm.restante);
          vm.saldo_final = 0;
        }else{
          vm.saldo_final = vm.restante;
          vm.monto_a_pagar = 0;
        }
      }
      vm.agregarGrilla = function(){
        // GRILLA RESUMEN
          vm.gridOptions = {
            minRowsToShow: 3,
            appScopeProvider: vm
          }
          vm.gridOptions.columnDefs = [
            { field: 'producto', displayName: 'PRODUCTO', minWidth:120 },
            { field: 'cantidad',  displayName: 'CANTIDAD FOTOS',  width:150 },
            { field: 'precio',  displayName: 'PRECIO',  width:80 },
            { field: 'total_detalle',  displayName: 'TOTAL',  width:80 },
          ];
          vm.gridOptions.data = [];
          vm.getTableHeight = function(){
             var rowHeight = 26; // your row height
             var headerHeight = 25; // your header height
             return {
                height: (vm.gridOptions.data.length * rowHeight + headerHeight + 40) + "px"
                // height: (6 * rowHeight + headerHeight + 20) + "px"
             };
          };
        vm.arrTemporal = {
          'idpaquete': null,
          'producto' : 'PAQUETE: ' + vm.listaExcursiones[0].descripcion,

          'cantidad' : vm.listaImagenes.length,
          // 'cantidad' : 1,
          'precio' : parseInt(vm.monto)/vm.listaImagenes.length,
          'total_detalle' : parseInt(vm.monto),
          'es_pedido': false,
          'tipo_seleccion' : 2,
          'imagenes': vm.listaImagenes,
        }
        vm.gridOptions.data.push(vm.arrTemporal);
        console.log('data',vm.gridOptions.data);
      }
      console.log('calculo');
      vm.calcularTotales();
      vm.agregarGrilla();
      vm.modoSeleccionar=false;
    }

    vm.btnVolver = function(){
      vm.monto_total = 0.00;
      vm.modoSeleccionar = true;
      vm.modoPagar = false;
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

    vm.btnPagar = function(){
      if(!vm.selectedTerminos){
        alert("You must accept the Terms and Conditions");
        return false;
      }
      vm.pedido = false;
      vm.total_pedido = 0;
      vm.total_venta = vm.monto_a_pagar;
      vm.modoSeleccionar = false;
      vm.modoPagar = false;
      var datos = {
        monedero: vm.saldo_final,
        idcliente: $scope.fSessionCI.idcliente,
        saldo: $scope.fSessionCI.monedero,
        detalle: vm.gridOptions.data,
        total_pedido: vm.total_pedido,
        total_venta: vm.total_venta,
        idexcursion : vm.listaExcursiones[0].idexcursion,
        tipo_pack : vm.esPack ? 1 : 2,
        porConfirmar : (vm.monto_a_pagar > 0) ? true : false
      };
      console.log('datos',datos);
      TiendaServices.sRegistrarVenta(datos).then(function(rpta){
        if(rpta.flag == 1){
          vm.idmovimiento = rpta.idmovimiento;
          if(vm.monto_a_pagar > 0){
            vm.token = rpta.token;
            vm.pasarela = true;
            console.log('pasarela',vm.pasarela);
            return;
          }
          vm.irCompraExitosa();
          $scope.getValidateSession();
          $scope.actualizarSaldo(false);
          $scope.actualizarMonto(0);
        }else if(rpta.flag == 0){
          alert(rpta.message);
          $scope.getValidateSession();
          location.reload();
        }else{
          alert('Error inesperado');
        }
      });

    }
    /*vm.realizarPago = function(){
      vm.modoSeleccionar = false;
      vm.modoPagar = false;
      if(vm.monto_a_pagar > 0){
       vm.pasarela = true;
       return;
      }
      pagarOk();

    }
    vm.pagarOk = function(){
      var datos = {
        monedero: vm.saldo_final,
        idcliente: $scope.fSessionCI.idcliente,
        saldo: $scope.fSessionCI.monedero,
        detalle: vm.gridOptions.data,
        total_pedido: vm.total_pedido,
        total_venta: vm.total_venta,
        idactividadcliente : vm.listaExcursiones[0].idactividadcliente
      };
      TiendaServices.sRegistrarVenta(datos).then(function(rpta){
        if(rpta.flag == 1){
          vm.irCompraExitosa();
          $scope.getValidateSession();
          $scope.actualizarSaldo(false);
          $scope.actualizarMonto(0);
        }else if(rpta.flag == 0){
          alert(rpta.message);
          $scope.getValidateSession();
          location.reload();
        }else{
          alert('Error inesperado');
        }
      });
    }*/
    vm.irCompraExitosa = function(){
      $scope.actualizarSaldo(false);
      var datos = {
        imagenes : vm.images,
        procesado : vm.esPack
      }
      pageLoading.start('Loading...');
      TiendaServices.sDescargarArchivosPagados(datos).then(function(rpta){
        if(rpta.flag == 1){
          vm.modoDescargaCompleta=true;
          vm.limpiar();
          var title = 'OK';
          var type = 'success';
          toastr.success(rpta.message, title);
        }else if(rpta.flag == 0){
          var title = 'Advertencia';
          var type = 'warning';
          toastr.warning(rpta.message, title);
        }else{
          alert('Error inesperado');
        }
        pageLoading.stop();
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
          console.log('calificacion y redir');
          $timeout(function() {
            $window.location.href = $scope.dirBase+'admin/#/app/mi-galeria';
          },2000);
        }else if(rpta.flag == 0){
          var title = 'Advertencia';
          var type = 'warning';
          toastr.warning(rpta.message, title);
        }else{
          alert('Error inesperado');

        }
      });
    }
    vm.btnTerminosCondiciones = function(){
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
    }
    vm.btnVerOferta = function(){
      var modalInstance = $uibModal.open({
        templateUrl: 'app/pages/tienda/oferta.php',
        controllerAs: 'mo',
        size: '',
        backdropClass: 'splash-2 splash-ef-12',
        windowClass: 'splash-2 splash-ef-12',
        backdrop: 'static',
        keyboard:false,
        scope: $scope,
        controller: function($scope, $uibModalInstance, arrToModal ){
          var vm = this;
          vm.fData = arrToModal.scope.fData;
          vm.selectFotografia = arrToModal.scope.selectFotografia;
          var paramDatos = {
            idseccion : 9 // oferta
          }
          TiendaServices.sListarSeccion(paramDatos).then(function(rpta){
            vm.modalTitle = rpta.datos.titulo;
            vm.contenido = rpta.datos.contenido;
          });
          vm.aceptar = function(){
            // console.log('fData',vm.fData);
            TiendaServices.sEnviarEmailOferta(vm.fData).then(function(rpta){
              if(rpta.flag == 1){
                var title = 'OK';
                var type = 'success';
                toastr.success(rpta.message, title);
                $uibModalInstance.close(vm.fData);
              }else if(rpta.flag == 0){
                var title = 'Advertencia';
                var type = 'warning';
                toastr.warning(rpta.message, title);
              }else{
                alert('Error inesperado');
              }
            });
          }
          vm.cancel = function (){
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
    vm.selectFotografia = function(){
      var modalInstance = $uibModal.open({
        templateUrl: 'app/pages/tienda/galeria_modal_tienda.php',
        controllerAs: 'gm',
        size: 'lg',
        backdropClass: 'splash splash-2 splash-info splash-ef-13',
        windowClass: 'splash splash-2 splash-info splash-ef-13',
        // backdrop: 'static',
        // keyboard:false,
        scope: $scope,
        controller: function($scope, $uibModalInstance, arrToModal ){
          var vm = this;
          vm.images = arrToModal.scope.images;
          vm.tipo_seleccion = 1;
          vm.modalTitle = 'Selecciona Fotografía';
          vm.selectFoto = function(imagen, index){
            arrToModal.scope.fData.imagen = imagen;
            arrToModal.scope.fData.isSel = true;
            $uibModalInstance.dismiss('cancel');
          }
          vm.aceptar = function () {
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
  }

  function TiendaServices($http, $q) {
    return({
        sListarNoDescargados: sListarNoDescargados,
        sDescargarArchivosPagados: sDescargarArchivosPagados,
        sVerificarSeleccion: sVerificarSeleccion,
        sRegistrarVenta: sRegistrarVenta,
        sEnviarEmailOferta: sEnviarEmailOferta,
        sListarSeccion: sListarSeccion,
    });

    function sListarNoDescargados(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Archivo/listar_archivos_no_descargados",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }

    function sDescargarArchivosPagados(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Compra/descargar_archivos_pagados",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }

    function sVerificarSeleccion(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Compra/verificar_archivos_seleccion",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }

    function sRegistrarVenta(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Movimiento/registrar_venta",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sEnviarEmailOferta(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Compra/enviar_correo_oferta",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sListarSeccion(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Seccion/listar_seccion",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
  }
})();
