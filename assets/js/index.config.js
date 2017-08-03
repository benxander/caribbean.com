(function() {
  'use strict';

  if (!window.location.origin) {
    window.location.origin = window.location.protocol+"//"+window.location.host;
  }
  var dirWebRoot =  window.location.origin + directoryApp;
  angular.patchURL = dirWebRoot+'/';
  angular.patchURLCI = dirWebRoot+'/ci.php/';

  angular
    .module('caribbean')
    .config(config);

  /** @ngInject */
  function config($logProvider, $locationProvider) {
    // Enable log
    $logProvider.debugEnabled(true);

    $locationProvider.html5Mode(true);
    // remove ! hash prefix
    $locationProvider.hashPrefix('');

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
