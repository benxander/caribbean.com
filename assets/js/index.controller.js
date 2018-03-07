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
    .directive("owlCarousel", function() {
      return {
        restrict: 'E',
        transclude: false,
        link: function (scope) {
          scope.initCarousel = function(element) {
            // provide any default options you want
            var defaultOptions = {
            };
            var customOptions = scope.$eval($(element).attr('data-options'));
            // combine the two options objects
            for(var key in customOptions) {
              defaultOptions[key] = customOptions[key];
            }
            // init carousel
            $(element).owlCarousel(defaultOptions);
          };
        }
      };
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
    })
    .directive('owlCarouselItem', [function() {
      return {
        restrict: 'A',
        transclude: false,
        link: function(scope, element) {
          // wait for the last item in the ng-repeat then call init
          if(scope.$last) {
            scope.initCarousel(element.parent());
          }
        }
      };
    }]);

  /** @ngInject */
  function MainController($scope,$sce, $timeout, $location, $window, rootServices, BlogServices,$routeParams) {
    var vm = this;
    // console.log('$translate',$translate);
    $scope.dirWeb = angular.patchURL;
    $scope.pageInicio = true;
    $scope.$on('$routeChangeSuccess', function() {
       console.log('rP',$routeParams);
    });
    // $scope.fSessionCI = {};
    // $scope.items1 = [
    //   {
    //     'titulo': 'Responsive',
    //     'descripcion' : 'Aenean luctus mi mollis quam feugiat consequat eu sed eros. Cras suscipit eu est sed imperdiet luctus.',
    //     'clase' : 'halcyon-icon-eyeglasses'
    //   },
    //   {
    //     'titulo': 'Seleccione sus fotos',
    //     'descripcion' : 'Luctus mi mollis quam feugiat conseq uat eu sed eros. Cras suscipit eu est sed imperdiet. Aenean mdiet.',
    //     'clase' : 'halcyon-icon-photo-camera'
    //   },
    //   {
    //     'titulo': 'Pagos con Paypal y Tarjeta',
    //     'descripcion' : 'Luctus mi mollis quam feugiat conseq uat eu sed eros. Cras suscipit eu est sed imperdiet. Aenean mdiet.',
    //     'clase' : 'halcyon-icon-id-card-4'
    //   },
    //   {
    //     'titulo': 'Otro item',
    //     'descripcion' : 'Luctus mi mollis quam feugiat conseq uat eu sed eros. Cras suscipit eu est sed imperdiet. Aenean mdiet.',
    //     'clase' : 'halcyon-icon-id-card-2'
    //   }
    // ];

    $scope.goToUrl = function ( path ) {
      $location.path( path );
    };
    $scope.scrollTo = function(id) {
      var delay = 0;
       console.log('home');
      if($location.path( '/' )){

        $timeout(function() {
          if(id == 'inicio'){
            $("html, body").animate({
                scrollTop: 0
            }, 800, 'linear');
          }else{
            var offset = $("body").data("offset");
            $("html, body").animate({
                scrollTop: $('#'+id).offset().top - offset
            }, 800, 'linear');
            console.log('offset',$('#'+id).offset().top);
          }

        },delay);

        // $location.path( '/' );
        // delay = 200;
        // $scope.pageInicio = true;
      }else{
       console.log('blog');

      }
      return false;
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
        console.log('fichas.imagenes',$scope.seccionWeb[2].contenedor[1].fichas[0].imagenes);
        var fichas = $scope.seccionWeb[2].contenedor[1].fichas;
        angular.forEach(fichas, function(ficha,key){
          if(ficha.html_vimeo){
            $scope.seccionWeb[2].contenedor[1].fichas[key].htmlVimeo = $sce.trustAsHtml(ficha.html_vimeo);
          }
        });
      }else{
        console.log('no data');
      }
    });
    rootServices.sListarRedesWeb().then(function (rpta) {
      if(rpta.flag == 1){
        $scope.dataRedes = rpta.datos;
      }
    });
    // SECCION BLOG
      var paramDatos = {
        'limit': 3,
        'sortName': 'fecha',
        'sort' : 'DESC'
      }
      BlogServices.sCargarNoticiasSeccion(paramDatos).then(function (rpta) {
        if(rpta.flag == 1){
          vm.listaNoticiasSec = rpta.datos;
          console.log(vm.listaNoticiasSec);

        }else{
          console.log('no data');
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
