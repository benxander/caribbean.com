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
  }
})();