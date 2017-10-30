(function() {
  'use strict';
  if (!window.location.origin) {
    window.location.origin = window.location.protocol+"//"+window.location.host;
  }
  var dirWebRoot =  window.location.origin + directoryApp+'/';
  angular.patchURL = dirWebRoot;
  angular.patchURLCI = dirWebRoot+'ci.php/';

  angular
    .module('minotaur')
    .config(config)
    .config(configApp);

  /** @ngInject */
  function config($logProvider, toastrConfig, $translateProvider, $locationProvider,$qProvider) {
    // Enable log
    $logProvider.debugEnabled(true);
    // Set options third-party lib
    toastrConfig.allowHtml = true;
    toastrConfig.timeOut = 3000;
    toastrConfig.extendedTimeOut = 1000;
    toastrConfig.positionClass = 'toast-top-right';
    toastrConfig.preventDuplicates = false;
    toastrConfig.preventOpenDuplicates = false;
    toastrConfig.progressBar = true;
    toastrConfig.closeButton = '<button><i class="fa fa-times"></i></button>';



    // $qProvider.errorOnUnhandledRejections(false);

    // angular-language
    $translateProvider.useStaticFilesLoader({
      prefix: 'assets/languages/',
      suffix: '.json'
    });
    $translateProvider.useLocalStorage();
    $translateProvider.preferredLanguage('es');
    $translateProvider.useSanitizeValueStrategy(null);

    // remove ! hash prefix
    $locationProvider.hashPrefix('');
  }

  function configApp(socialshareConfProvider) {
    socialshareConfProvider.configure([
      {
        'provider': 'twitter',
        'conf': {
          'url': 'http://720kb.net',
          'text': '720kb is enough',
          'via': 'npm',
          'hashtags': 'angularjs,socialshare,angular-socialshare',
          'trigger': 'click',
          'popupHeight': 800,
          'popupWidth' : 400
        }
      },
      {
        'provider': 'facebook',
        'conf': {
          'url': 'http://dantecervantes/social-share-con-angular-js',
          'trigger': 'click',
          'popupHeight': 800,
          'popupWidth' : 400
        }
      }
    ]);
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
