(function() {
  'use strict';

  angular
    .module('minotaur')
    .factory('CalendarData', CalendarData)
    .factory('PageLoading', PageLoading)
    .factory('PinesNotifications', PinesNotifications);

  /** @ngInject */

  /* Esta factoria ya no la uso, no lo tomen en cuenta para el Calendar por ahora. */
  function CalendarData($http/*,rootServices*/) {


    var interfazCalendarData = {};
    interfazCalendarData.getDataCalendarCitas = getDataCalendarCitas;
    return interfazCalendarData;

    function getDataCalendarCitas(arrParams) {
      return $http.post(arrParams.url, arrParams.datos).then(handleSuccess, handleError('Recurso no encontrado'));
    }
  }
  function PageLoading(){
    var pageLoading = {
      start: function(text){
          var page = angular.element('#page-loading');
          var pageText = angular.element('.page-loading-text');
          page.addClass('visible');
          pageText.text(text);
      },
      stop: function(){
          var page = angular.element('#page-loading');
          var pageText = angular.element('.page-loading-text');
          page.removeClass('visible');
          pageText.text('');
      }
    }
    return pageLoading;
  }
  function PinesNotifications($window){
    return {
      notify: function (args) {
        args.styling = 'fontawesome';
        args.mouse_reset = false;
        var notification = new $window.PNotify(args);
        notification.notify = notification.update;
        return notification;
      },
    };
  }
})();
