(function() {
  'use strict';

  angular
    .module('minotaur')
    .controller('TiendaController', TiendaController)
    .service('TiendaServices', TiendaServices
      );

  /** @ngInject */
  function TiendaController($scope, TiendaServices, ClienteServices, ExcursionServices, rootServices,toastr) {
    var vm = this;
    vm.modoSeleccionar = true;
    //vm.modoSeleccionar = false;
    vm.modoPagar = false;
    vm.modoDescargaCompleta = false;
    //vm.modoDescargaCompleta = true;
    vm.cargarGaleria = function(datos){
      TiendaServices.sListarNoDescargados(datos).then(function(rpta){
        vm.images = rpta.datos;
      });
    }
    vm.cargarExcursiones = function(datos){
      ExcursionServices.sListarExcursionPaquetesCliente(datos).then(function(rpta){
        vm.listaExcursiones = rpta.datos;
        vm.listaPaquetes = vm.listaExcursiones[0].paquetes;
      });
    }

    rootServices.sGetSessionCI().then(function (response) {
      if(response.flag == 1){
        vm.fDataUsuario = response.datos;
        vm.cargarGaleria(vm.fDataUsuario);
        vm.cargarExcursiones(vm.fDataUsuario);
      }
    });

    vm.selectedAll = false;
    vm.isSelected = false;

    vm.selectAll = function () {
      var monto = 0;
      if (vm.selectedAll) {
        vm.selectedAll = false;
        vm.isSelected = false;

      } else {
        vm.selectedAll = true;
        vm.isSelected = true;
      }

      angular.forEach(vm.images, function(image) {
        image.selected = vm.selectedAll;
        if(vm.isSelected){
          monto = monto + image.precio_float;
        }
      });
      vm.monto_total = monto.toFixed(2);
    };

    vm.selectImage = function(index) {
      var i = 0;
      var monto = 0;

      if (vm.images[index].selected) {
        vm.images[index].selected = false;
      } else {
        vm.images[index].selected = true;
        vm.isSelected = true;
      }

      angular.forEach(vm.images, function(image) {
        if (image.selected) {
          i++;
          monto = monto + image.precio_float;
        }
      });

      if (i === 0) {
        vm.isSelected = false;
      }
      console.log('monto', monto);
      vm.monto_total = monto.toFixed(2);
    };
    vm.monto_total = 0.00;

    vm.btnDescargarFiles = function(){
      vm.modoSeleccionar=false;
      vm.modoPagar=true;
    }

    vm.btnVolver = function(){
      vm.modoSeleccionar=true;
      vm.modoPagar=false;
    }

    vm.btnPagar = function(){
      vm.modoSeleccionar = false;
      vm.modoPagar=false;

      /*aqui deberia incorporar proceso de pago y si es valido llevarlo al metodo que mueve las imagenes y muestra la encuesta*/

      vm.irCompraExitosa();
    }

    vm.irCompraExitosa = function(){
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
            url :  angular.patchURLCI + "Archivo/descargar_archivos_pagados",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
  }
})();
