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
    // $locationProvider.hashPrefix('');
    $routeProvider
    .when('/', {
      // templateUrl: angular.dirViews . '/main.php',
      templateUrl: function(param) {
          return angular.dirViews + 'login_view.php';
        },
      controller: 'LoginController',
      controllerAs: 'l',
    })
    .when("/a?", {
      templateUrl: function(param) {
          return angular.dirViews +  'login_view.php';
        },
      controller: 'LoginController',
      controllerAs: 'l',

    })
    ;
  }

})();
// DOCUMENT LOAD //
    (function($) {
      $(window).load(function() {
        /* Remove preloader */
        $(".preloader-wrapper").fadeOut(1000, function() {
          $(this).remove();
        });
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
