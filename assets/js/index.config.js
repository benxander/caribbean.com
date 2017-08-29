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
  function config($logProvider,$routeProvider, $locationProvider) {
    // Enable log
    $logProvider.debugEnabled(true);

    $locationProvider.html5Mode(true);
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
   /* .otherwise({
        redirectTo: '/'
      })*/;
      console.log('route', $routeProvider);
  }

})();

function handleError(error) {
  return function () {
    return {success: false, message: Notification.warning({message: error})};
  };
}
function handleSuccess(response) {
    return( response.data );
}
