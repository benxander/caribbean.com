(function() {
  'use strict';
  angular
    .module('minotaur')
    .controller('ConfigController', ConfigController)
    .service('ConfigServices', ConfigServices);

  /** @ngInject */
  function ConfigController($scope,ConfigServices) {
    var vm = this;
  }
  function ConfigServices($http, $q) {
    return({
        sListarConfigCbo: sListarConfigCbo,
    });
    function sListarConfigCbo(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Config/listar_seccion_cbo",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
  }
})();