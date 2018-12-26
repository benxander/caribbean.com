
(function() {
  'use strict';

  angular
    .module('minotaur')
    .config(routerConfig);

  /** @ngInject */
  function routerConfig($stateProvider, $urlRouterProvider) {
    $stateProvider
      //dashboard
      .state('dashboard', {
        url: '/app/dashboard',
        templateUrl: 'app/pages/dashboard/dashboard.html',
        controller: 'DashboardController',
        controllerAs: 'dashboard'
      })
      //app core pages (errors, login,signup)
      .state('pages', {
        url: '/app/pages',
        template: '<div ui-view></div>'
      })
      .state('my-gallery', {
        url: '/app/my-gallery',
        templateUrl: 'app/pages/my-gallery/gallery.html',
        controller: 'PagesGalleryController',
        controllerAs: 'ga'
      })//galeria tienda
      .state('shop', {
        url: '/app/shop',
        templateUrl: 'app/pages/shop/shop.html',
        controller: 'TiendaController',
        controllerAs: 'ctrl'
      })
      .state('pago', {
        url: '/app/pago/?id&token',
        templateUrl: 'app/pages/pago/pago.html',
        controller: 'PagoController',
        controllerAs: 'pg'
      })


    $urlRouterProvider.otherwise('/app/my-gallery');
  }

})();
