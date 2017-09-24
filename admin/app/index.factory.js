(function() {
  'use strict';

  angular
    .module('minotaur')
    .factory('CalendarData', CalendarData)
    .factory('PageLoading', PageLoading)
    .factory('TileLoading', TileLoading)
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
  function TileLoading(){
    /*var tile = element.parents('.tile');
        element.on('click', function(){
          tile.addClass('loading');
          cfpLoadingBar.start();

          $timeout(function(){
            tile.removeClass('loading');
            cfpLoadingBar.complete();
          },3000)*/
    var tileLoading = {
      start: function(text){
          var tile = angular.element('.tile');
          // var pageText = angular.element('.page-loading-text');
          tile.addClass('loading');
          cfpLoadingBar.start();
      },
      stop: function(){
          var tile = angular.element('.tile');
          // var pageText = angular.element('.page-loading-text');
          page.removeClass('loading');
          cfpLoadingBar.complete();
      }
    }
    return tileLoading;
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
