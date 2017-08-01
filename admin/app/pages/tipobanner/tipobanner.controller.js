(function() {
  'use strict';
  angular
    .module('minotaur')
    .controller('TipobannerController', TipobannerController)
    .service('TipobannerServices', TipobannerServices);

  /** @ngInject */
  function TipobannerController($scope,TipobannerServices) {
    var vm = this;
  }
  function TipobannerServices($http, $q) {
    return({
        sListarTipobannerCbo: sListarTipobannerCbo,
    });
    function sListarTipobannerCbo(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Tipobanner/listar_tipo_banner_cbo",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
  }
})();