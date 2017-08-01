(function() {
  'use strict';
  angular
    .module('minotaur')
    .controller('SeccionController', SeccionController)
    .service('SeccionServices', SeccionServices);

  /** @ngInject */
  function SeccionController($scope,SeccionServices) {
    var vm = this;
  }
  function SeccionServices($http, $q) {
    return({
        sListarSeccionCbo: sListarSeccionCbo,
    });
    function sListarSeccionCbo(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Seccion/listar_seccion_cbo",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
  }
})();