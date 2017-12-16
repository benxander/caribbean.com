(function() {
  'use strict';

  angular
    .module('minotaur')
    .controller('TiendaController', TiendaController)
    .service('TiendaServices', TiendaServices
      );

  /** @ngInject */
  function TiendaController($scope, TiendaServices, ClienteServices, ExcursionServices, rootServices,toastr, pageLoading, alertify) {

    var vm = this;
    var scope = $scope;
    console.log('scope',scope);
    vm.seleccionadas = 0;
    vm.modoSeleccionar = true;
    //vm.modoSeleccionar = false;
    vm.modoPagar = false;
    vm.modoDescargaCompleta = false;
    vm.monto = 0;
    vm.alertAdicionales = false;

    vm.isPagoMonedero = false;
    vm.paqueteSeleccionado = {};
    //vm.modoDescargaCompleta = true;
    vm.cargarGaleria = function(datos){
      pageLoading.start('Cargando archivos...');
      TiendaServices.sListarNoDescargados(datos).then(function(rpta){
        vm.images = rpta.datos;
        pageLoading.stop();
      });
    }
    vm.cargarExcursiones = function(datos){
      ExcursionServices.sListarExcursionPaquetesCliente(datos).then(function(rpta){
        console.log(rpta.datos);
        vm.listaExcursiones = rpta.datos;
        vm.listaPaquetes = vm.listaExcursiones[0].paquetes;
        vm.paqueteSeleccionado = vm.listaPaquetes[0];
        vm.monto = vm.listaPaquetes[0].monto;
        vm.precio_adicional = vm.listaExcursiones[0].precio_por_adicional;
        vm.precio_video = vm.listaExcursiones[0].precio_video;
      });
    }
    vm.selPaquete = function(idpaquete){
      console.log('idpaquete',idpaquete);
      angular.forEach(vm.listaPaquetes, function(paquete,key) {
        if(paquete.idpaquete == idpaquete){
          vm.listaPaquetes[key].selected = true;
          vm.paqueteSeleccionado = paquete;
          vm.monto = paquete.monto;
          vm.actualizaMontoPaquete();
        }else{
          vm.listaPaquetes[key].selected = false;
        }
      });
    }
    vm.actualizaMontoPaquete =  function(){
      if(vm.isPagoMonedero){
        $scope.actualizarSaldo(false);
        $scope.actualizarSaldo(true,vm.monto);
        if($scope.seleccionadas > vm.paqueteSeleccionado.cantidad){
          var cantidad = $scope.seleccionadas - vm.paqueteSeleccionado.cantidad;
          $scope.actualizarSaldo(true,cantidad * vm.precio_adicional);
        }
      }
    }
    rootServices.sGetSessionCI().then(function (response) {
      if(response.flag == 1){
        vm.fDataUsuario = response.datos;
        vm.cargarExcursiones(vm.fDataUsuario);
        vm.cargarGaleria(vm.fDataUsuario);
      }
    });

    vm.selectedAll = false;
    vm.isSelected = false;
    // console.log('$scope.isSelected',$scope.isSelected);
    // $scope.isSelected = vm.isSelected;

    vm.selectAll = function () {
      var monto = 0;
      if (vm.selectedAll) {
        vm.selectedAll = false;
        vm.isSelected = false;

      } else {
        vm.selectedAll = true;
        vm.isSelected = true;
      }
      var i=0;
      angular.forEach(vm.images, function(image) {
        image.selected = vm.selectedAll;
        monto = monto + image.precio_float;
        if(!vm.isPagoMonedero && vm.paqueteSeleccionado){
          vm.isPagoMonedero = true;
          $scope.actualizarSaldo(true,vm.monto);
        }
        if(image.descargado == 2){
          i++;
        }
      });
      if(i > vm.paqueteSeleccionado.cantidad){
        var cantidad = i - vm.paqueteSeleccionado.cantidad;
        if(vm.isSelected){
          $scope.actualizarSaldo(true,cantidad * vm.precio_adicional);
        }else{
          $scope.actualizarSaldo(true,'-'+(cantidad * vm.precio_adicional));
          i=0;
        }
      }
      $scope.actualizarSeleccion(i,vm.monto);
      vm.monto_total = monto.toFixed(2);
    };

    vm.selectImage = function(index) {
      var i = 0;
      var monto = 0;
      var add = true;

      if (vm.images[index].selected) {
        vm.images[index].selected = false;
        add = false;
      } else {
        vm.images[index].selected = true;
        vm.isSelected = true;
        add = true;
        if(!vm.isPagoMonedero && vm.paqueteSeleccionado){
          vm.isPagoMonedero = true;
          $scope.actualizarSaldo(true,vm.monto);
        }
      }

      angular.forEach(vm.images, function(image) {
        if (image.selected) {
          i++;
          // monto = monto + image.precio_float;
        }
      });

      if (i === 0) {
        vm.isSelected = false;
      }
      vm.seleccionadas = i;
      $scope.actualizarSeleccion(i,vm.monto);
      console.log(vm.paqueteSeleccionado);
      if(add && (vm.seleccionadas > vm.paqueteSeleccionado.cantidad)){
        if(!vm.alertAdicionales){
          alert("Apartir de ahora se cobrará USD$ "+vm.precio_adicional+" por cada foto adicional");
          vm.alertAdicionales = true;
        }

        $scope.actualizarSaldo(true,vm.precio_adicional);
      }else if(!add && vm.seleccionadas > vm.paqueteSeleccionado.cantidad){
        $scope.actualizarSaldo(true,'-'+ vm.precio_adicional);
      }
      // console.log('fSessionCI.key_grupo', $scope.fSessionCI.key_grupo);
      // vm.monto_total = monto.toFixed(2);
    };

    // $scope.$watch('vm.monto',function(newValue,oldValue = vm.monto) {
    //   console.log('newValue',newValue);
    //   console.log('oldValue',oldValue);
    //   if (newValue===oldValue) {
    //     console.log('vm.monto',vm.monto);
    //     return;
    //   }
    //   console.log('watch dif');
    //   $scope.actualizarSaldo(newValue,vm.monto);
    // });
    vm.monto_total = 0.00;
    vm.monto_descuento = 0.00;
    vm.monto_bonificacion = 0.00;

    vm.confirmDescarga = function(){
      console.log($scope.seleccionadas);
      console.log(vm.paqueteSeleccionado.cantidad);
      if($scope.seleccionadas < vm.paqueteSeleccionado.cantidad){
        alertify.confirm('¿Esta seguro de continuar? <br/>'+
          'Aun tiene '+ (vm.paqueteSeleccionado.cantidad - vm.seleccionadas)
          +' fotos por seleccionar', function(){
           vm.btnDescargarFiles();
        });
      }else{
        vm.btnDescargarFiles();
      }
    }

    vm.btnDescargarFiles = function(){
      if(!vm.isSelected){
        return;
      }
      pageLoading.start('Verificando seleccion...');
      var datos = {
        seleccion : vm.images,
        usuario : vm.fDataUsuario
      }

      TiendaServices.sVerificarSeleccion(datos).then(function(rpta){
        vm.datosVista = rpta;
        vm.calculaDescuentos();

        if(vm.datosVista.mostrar_productos){
          angular.forEach(vm.images, function(image,key) {
            if (image.selected) {
              vm.images[key].lista_productos = angular.copy(vm.datosVista.lista_productos);
            }
          });
        }
        vm.modoSeleccionar=false;
        vm.modoPagar=true;
        pageLoading.stop();
      });
    }

    vm.calculaDescuentos = function(){
      if(vm.datosVista.tiene_bonificacion){
        var encontrado = false;
        angular.forEach(vm.images, function(image) {
          if (image.selected && !encontrado) {
            vm.monto_bonificacion = image.precio_float;
            encontrado = true;
          }
        });
      }

      if(vm.datosVista.tiene_descuento){
        vm.monto_descuento = (parseFloat(vm.monto_total) * parseFloat(vm.datosVista.descuento.descuento) / 100).toFixed(2);
        vm.monto_neto = (parseFloat(vm.monto_total) - parseFloat(vm.monto_descuento)).toFixed(2);
      }
    }

    vm.updatePrecio = function(producto){
      var productos = (parseInt(producto.cantidad) * parseFloat(producto.precio)).toFixed(2);
      vm.monto_total = (parseFloat(vm.monto_total) + parseFloat(productos)).toFixed(2);
      vm.calculaDescuentos();
    }

    vm.btnVolver = function(){
      angular.forEach(vm.images, function(image) {
        image.selected = false;
      });
      vm.monto_total = 0.00;
      vm.modoSeleccionar = true;
      vm.modoPagar = false;
      vm.selectedAll = false;
      vm.isPagoMonedero = false;
      $scope.actualizarSeleccion(0,0);
      $scope.actualizarSaldo(false);
    }
    vm.btnPagar = function(){
      vm.modoSeleccionar = false;
      vm.modoPagar=false;
      /*aqui deberia incorporar proceso de pago y si es valido llevarlo al metodo que mueve las imagenes y muestra la encuesta*/
      vm.irCompraExitosa();
    }

    vm.irCompraExitosa = function(){
      pageLoading.start('Procesando descarga...');
      TiendaServices.sDescargarArchivosPagados(vm.images).then(function(rpta){
        if(rpta.flag == 1){
          vm.modoDescargaCompleta=true;
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
        }else if(rpta.flag == 0){
          var title = 'Advertencia';
          var type = 'warning';
          toastr.warning(rpta.message, title);
        }else{
          alert('Error inesperado');
        }
      });
    }

  }

  function TiendaServices($http, $q) {
    return({
        sListarNoDescargados: sListarNoDescargados,
        sDescargarArchivosPagados: sDescargarArchivosPagados,
        sVerificarSeleccion:sVerificarSeleccion,
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
  }
})();
