(function() {
  'use strict';
  angular
    .module('minotaur')
    .controller('IdiomaController', IdiomaController)
    .service('IdiomaServices', IdiomaServices);

  /** @ngInject */
  function IdiomaController($scope,IdiomaServices) {
    var vm = this;
  }
  function IdiomaServices($http, $q) {
    return({
        sListarIdiomaCbo: sListarIdiomaCbo,
    });
    function sListarIdiomaCbo(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Idioma/listar_idiomas_cbo",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
  }
})();