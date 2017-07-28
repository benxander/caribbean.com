(function() {
  'use strict';

  angular
    .module('caribbean')
    .controller('MainController', MainController)
    .service('rootServices', rootServices)
    .directive('hcChart', function () {
      return {
          restrict: 'E',
          template: '<div></div>',
          scope: {
              options: '='
          },
          link: function (scope, element) {
            // scope.$watch(function () {
            //   return attrs.chart;
            // }, function () {
            //     if (!attrs.chart) return;
            //     var charts = JSON.parse(attrs.chart);
            //     $(element[0]).highcharts(charts);
                Highcharts.chart(element[0], scope.options);
            // });

          }
      };
  })
  .directive('fancybox', function ($compile, $http) {
    return {
        restrict: 'A',

        controller: function($scope) {
             $scope.openFancybox = function (url) {

                $http.get(url).then(function(response) {
                    if (response.status == 200) {

                        var template = angular.element(response.data);
                        var compiledTemplate = $compile(template);
                        compiledTemplate($scope);

                        $.fancybox.open({
                          content: template,
                          type: 'html',
                          maxWidth: 450,
                           maxHeight: 350,
                           fitToView: false,
                           width: '90%',
                           height: '90%',
                           padding: 0,
                           autoSize: false,
                           closeClick: false,
                           openMethod: 'dropIn',
                           openSpeed: 150,
                           closeMethod: 'dropOut',
                           closeSpeed: 150,
                           beforeShow: function () {
                             $("#main-container").addClass("bluring");
                           },
                           afterClose: function () {
                             $("#main-container").removeClass("bluring");
                           }
                        });
                    }
                });
            };
        }
    };
  });

  /** @ngInject */
  function MainController($scope, rootServices, $location) {
    var vm = this;
    // console.log('$translate',$translate);


    $scope.goToUrl = function ( path ) {
      $location.path( path );
    };

    vm.login = function(){
      vm.verLogin = true;
      console.log('formLogin.$invalid',formLogin.$invalid);
    }


  }
  function rootServices($http, $q) {
    return({
        sLogoutSessionCI: sLogoutSessionCI,
        sGetSessionCI: sGetSessionCI,
    });
    function sLogoutSessionCI(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Acceso/logoutSessionCI",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sGetSessionCI(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Acceso/getSessionCI",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
  }
})();
