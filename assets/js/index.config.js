(function() {
  'use strict';

  if (!window.location.origin) {
    window.location.origin = window.location.protocol+"//"+window.location.host;
  }
  var dirWebRoot =  window.location.origin + directoryApp;
  angular.patchURL = dirWebRoot+'/';
  angular.patchURLCI = dirWebRoot+'/ci.php/';
  angular.dirViews = angular.patchURL+'templates/';

  angular
    .module('caribbean')
    .config(config);
  /** @ngInject */
  function config($routeProvider, $locationProvider){
    $locationProvider.html5Mode(true);
    // remove ! hash prefix
    $locationProvider.hashPrefix('');
    $routeProvider
    .when('/', {
      // templateUrl: angular.dirViews . '/main.php',
      templateUrl: function(param) {
          return angular.dirViews + 'main.php';
        },
      controller: 'MainController',
      // resolve:{
      //   loadAsset: ['$ocLazyLoad', function($ocLazyLoad){
      //     return $ocLazyLoad.load(['assets/js/controllers/HomeCtrl.js'])
      //   }]
      // }
    })
    .when('/zona-privada', {
      // templateUrl: 'templates/blog.php',
      templateUrl: function(param) {
      console.log('param',param);
          return angular.dirViews +  'login_view.php';
          // return angular.dirViews + param.templateFile + '.php';
        },
      controller: 'LoginController',
      controllerAs: 'l',

    })
    .when('/blog', {
      // templateUrl: 'templates/blog.php',
      templateUrl: function(param) {
      console.log('param',param);
          return angular.dirViews +  'blog.php';
          // return angular.dirViews + param.templateFile + '.php';
        },
      controller: 'BlogController',

    }).when('/post', {
      templateUrl: function(param) {
      console.log('param',param);
          return angular.dirViews +  'post.php';
          // return angular.dirViews + param.templateFile + '.php';
        },
      controller: 'PostController',
      controllerAs: 'bp',
    });
  }
  /*function config($logProvider,$routeProvider, $locationProvider) {
    // Enable log
    $logProvider.debugEnabled(true);

    // $locationProvider.html5Mode(true);
    // remove ! hash prefix
    $locationProvider.hashPrefix('');
    $routeProvider
    .when('/', {
      templateUrl: 'templates/seccion/servicios.html',
      controller: 'MainController'

      // resolve:{
      //   loadAsset: ['$ocLazyLoad', function($ocLazyLoad){
      //     return $ocLazyLoad.load(['assets/js/controllers/Inicio.js'])
      //   }]
      // }
    }).when('/servicios', {
      templateUrl: 'templates/seccion/servicios.html',
      controller: 'MainController'

      // resolve:{
      //   loadAsset: ['$ocLazyLoad', function($ocLazyLoad){
      //     return $ocLazyLoad.load(['assets/js/controllers/Inicio.js'])
      //   }]
      // }
    })
   .otherwise({
        redirectTo: '/'
      });
      console.log('route', $routeProvider);
  }*/

})();
// DOCUMENT LOAD //
    (function($) {
      $(window).load(function() {
        /* Remove preloader */
        $(".preloader-wrapper").fadeOut(1000, function() {
          $(this).remove();
          $(".traductor").css({"visibility": "visible"});
        });
        /* page scroll */
        // var offset = $("body").data("offset");
        // $(document).on('click', 'a.page-scroll', function(event) {
        //   var $anchor = $(this);
        //   console.log('anchor',$($anchor.attr('href')).offset().top);
        //   $('html, body').stop().animate({
        //     scrollTop: $($anchor.attr('href')).offset().top - (offset - 1)
        //   }, 500, 'linear');
        //   event.preventDefault();
        // });

      });
    })(jQuery);

function handleError(error) {
  return function () {
    return {success: false, message: Notification.warning({message: error})};
  };
}
function handleSuccess(response) {
    return( response.data );
}
