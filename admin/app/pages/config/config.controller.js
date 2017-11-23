(function() {
  'use strict';
  angular
    .module('minotaur')
    .controller('ConfigController', ConfigController)
    .service('ConfigServices', ConfigServices);

  /** @ngInject */
  function ConfigController($scope,ConfigServices,toastr) {
    var vm = this;
    var openedToasts = [];
    vm.fData = {}
    ConfigServices.sListarRedesWeb().then(function (rpta) {
      if(rpta.flag == 1){
        vm.listaRedes = rpta.datos;
      }
    });
    // vm.listaRedes = [
    //   {id:1, descripcion: 'FACEBOOK'},
    //   {id:2, descripcion: 'YOUTUBE'},

    // ];
    vm.listarConfiguracion = function(){
      ConfigServices.sListarConfig().then(function (rpta) {
        if(rpta.flag == 1){
          vm.fData = rpta.datos;
          vm.fData.cLogo = false;
          vm.fData.cLogoFooter = false;
          vm.fData.cFavicon = false;
          vm.fData.cAppleIcon = false;
          vm.fData.cWaterMark = false;

        }else{

        }
      });
    }
    vm.listarConfiguracion();
    vm.aceptar = function(){
      console.log('vm.fData',vm.fData);
      console.log('vm.listaRedes',vm.listaRedes);
      vm.fData.redes = vm.listaRedes;
      ConfigServices.sEditarConfig(vm.fData).then(function (rpta) {
        if(rpta.flag == 1){
          var title = 'OK';
          var type = 'success';

        }else if(rpta.flag == 2){
          var title = 'Advertencia';
          var type = 'warning';
        }else{
          alert('Ocurrió un error');
        }
        vm.listarConfiguracion();
        openedToasts.push(toastr[type](rpta.message, title));
      });
    }
  }
  function ConfigServices($http, $q) {
    return({
        sListarConfig: sListarConfig,
        sEditarConfig: sEditarConfig,
        sListarRedesWeb: sListarRedesWeb,
    });
    function sListarConfig(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Config/listar_configuracion",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sEditarConfig(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Config/editar_configuracion",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sListarRedesWeb(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Config/listar_redes_web",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
  }
})();