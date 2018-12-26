(function() {
  'use strict';

  angular
    .module('minotaur')
    .controller('DashboardController', DashboardController)
  /** @ngInject */
  function DashboardController(moment, $scope) {
    var vm = this;
    $scope.actualizarSeleccion(0,0);
    $scope.actualizarSaldo(false);
    $scope.actualizarMonto(0);
    vm.datePicker = {
      date: {
        startDate: moment().subtract(1, "days"),
        endDate: moment()
      },
      opts: {
        ranges: {
          'This Month': [moment().startOf('month'), moment()],
          'Today': [moment(), moment()],
          'Yesterday': [moment().subtract(1, 'day'), moment().subtract(1, 'day')],
          'Last 7 Days': [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        opens: 'left'
      }
    };
  }



})();
