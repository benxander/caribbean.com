/* global moment:false */
(function() {
  'use strict';

  /* eslint-disable */
  angular
    .module('minotaur')
    .constant('moment', moment)
    .constant('_', window._)
    .constant('L', L)
    .constant('empresaNombre','Caribbean Photo Studio');
  /*esling-enable*/

})();
