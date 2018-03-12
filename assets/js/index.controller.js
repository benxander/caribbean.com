(function() {
  'use strict';

  angular
    .module('caribbean')
    .controller('MainController', MainController)
    .service('rootServices', rootServices)
    .directive('fancybox', function(){
      return {
        restrict: 'A',

        link: function(scope, element, attrs){
          $(element).fancybox({
            type        :'inline',
            scrolling   : 'yes',
            maxWidth    : 1000,
            maxHeight   : 600,
            fitToView   : true,
            width       : '80%',
            height      : '90%',
            autoSize    : false,
            closeClick  : false,
            openEffect  : 'none',
            closeEffect : 'none'
          });
        }
      }
    })
    .directive('ngEnter', function() {
      return function(scope, element, attrs) {
        element.bind("keydown", function(event) {

            if(event.which === 13) {
              //event.preventDefault();
              scope.$apply(function(){
                scope.$eval(attrs.ngEnter);
              });
              //event.stopPropagation();
            }
            //event.stopPropagation();
            //event.preventDefault();
        });
      };
    });

  /** @ngInject */
  function MainController($scope,$timeout, $location, $window, rootServices, $routeParams) {
    var vm = this;
    // console.log('$translate',$translate);
    $scope.dirWeb = angular.patchURL;
    $scope.pageInicio = true;
    $scope.$on('$routeChangeSuccess', function() {
       console.log('rP',$routeParams);
    });

    $scope.goToUrl = function ( path ) {
      $location.path( path );
    };


    rootServices.sCargarDatosWeb().then(function (response) {
      if(response.flag == 1){
        $scope.dataWeb = response.datos;
      }else{
        console.log('no data');
      }
    });
    rootServices.sCargarSecciones().then(function (response) {
      if(response.flag == 1){
        $scope.seccionWeb = response.datos;

      }else{
        console.log('no data');
      }
    });
    rootServices.sListarRedesWeb().then(function (rpta) {
      if(rpta.flag == 1){
        $scope.dataRedes = rpta.datos;
      }
    });
  }
  function rootServices($http, $q) {
    return({
        // sCargarBanners: sCargarBanners,
        sCargarDatosWeb: sCargarDatosWeb,
        sCargarSecciones: sCargarSecciones,
        sListarRedesWeb: sListarRedesWeb,
    });
    /*function sCargarBanners(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Banner/cargar_banners_web",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }*/
    function sCargarDatosWeb(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Config/listar_configuracion",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sCargarSecciones(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Seccion/listar_secciones_web",
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
