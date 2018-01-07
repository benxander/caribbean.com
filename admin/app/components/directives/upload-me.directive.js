(function() {
  'use strict';

  angular
    .module('minotaur')
    .directive('uploadMe', uploadMe)
    .directive('uploadMe2', uploadMe2)
    .directive('uploadMe3', uploadMe3);

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
  function uploadMe2() {
    var directive = {
        restrict: 'A',
        link: function (scope, elem, attrs) {
            var reader2 = new FileReader();
            reader2.onload = function (e) {
                scope.image2 = e.target.result;
                scope.$apply();
            }
            elem.on('change', function() {
                reader2.readAsDataURL(elem[0].files[0]);
                scope.file2 = elem[0].files[0];
            });
        }
    };
    return directive;
  }
  function uploadMe3() {
    var directive = {
        restrict: 'A',
        link: function (scope, elem, attrs) {
            var reader3 = new FileReader();
            reader3.onload = function (e) {
                scope.image3 = e.target.result;
                scope.$apply();
            }
            elem.on('change', function() {
                reader3.readAsDataURL(elem[0].files[0]);
                scope.file3 = elem[0].files[0];
            });
        }
    };
    return directive;
  }

})();
