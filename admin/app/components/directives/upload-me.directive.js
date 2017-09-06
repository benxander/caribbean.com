(function() {
  'use strict';

  angular
    .module('minotaur')
    .directive('uploadMe', uploadMe);

  /** @ngInject */
  function uploadMe() {
    var directive = {
        restrict: 'A',
        link: function (scope, elem, attrs) {
            var reader = new FileReader();
            reader.onload = function (e) {
                scope.image = e.target.result;
                scope.$apply();
            }
            elem.on('change', function() {
                reader.readAsDataURL(elem[0].files[0]);
                scope.file = elem[0].files[0];
            });
        }
    };
    return directive;

  }

})();
