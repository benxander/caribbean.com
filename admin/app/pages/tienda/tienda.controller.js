(function() {
  'use strict';

  angular
    .module('minotaur')
    .controller('TiendaController', TiendaController)
    .service('TiendaServices', TiendaServices
      );

  /** @ngInject */
  function TiendaController($scope, TiendaServices, rootServices) {
    var vm = this;
    vm.modoSeleccionar = true;
    vm.modoPagar = false;
    vm.modoDescarga = false;
    vm.cargarGaleria = function(datos){
      TiendaServices.sListarNoDescargados(datos).then(function(rpta){
        vm.images = rpta.datos;
      });
    }

    rootServices.sGetSessionCI().then(function (response) {
      if(response.flag == 1){
        vm.fDataUsuario = response.datos;
        vm.cargarGaleria(vm.fDataUsuario);
      }
    });
 
    vm.selectedAll = false;
    vm.isSelected = false;

    vm.selectAll = function () {
      if (vm.selectedAll) {
        vm.selectedAll = false;
        vm.isSelected = false;
      } else {
        vm.selectedAll = true;
        vm.isSelected = true;
      }

      angular.forEach(vm.images, function(image) {
        image.selected = vm.selectedAll;
      });
    };

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

      if (i === 0) {
        vm.isSelected = false;
      }
    };

    vm.btnDescargarFiles = function(){ 
      vm.modoSeleccionar=false;
      vm.modoPagar=true;
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
          vm.modoDescarga=true;
        }else if(rpta.flag == 0){

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
