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
      //login
      .state('pages.login', {
        url: '/login',
        templateUrl: 'app/pages/pages-login/pages-login.html',
        controller: 'LoginController',
        controllerAs: 'ctrl',
        parent: 'pages',
        specialClass: 'core'
      })
      //cliente
      .state('cliente', {
        url: '/app/cliente',
        templateUrl: 'app/pages/cliente/cliente.html',
        controller: 'ClienteController',
        controllerAs: 'c'
      })
      //banner
      .state('banner', {
        url: '/app/banner',
        templateUrl: 'app/pages/banner/banner.html',
        controller: 'BannerController',
        controllerAs: 'b'
      })
      //idioma
      .state('idioma', {
        url: '/app/idioma',
        templateUrl: 'app/pages/idioma/idioma.html',
        controller: 'IdiomaController',
        controllerAs: 'i'
      })
      //sitio
      .state('sitio', {
        url: '/app/sitio',
        templateUrl: 'app/pages/sitio/sitio.html',
        controller: 'Sitiocontroller',
        controllerAs: 's'
      })
      //usuario
      .state('usuario', {
        url: '/app/usuario',
        templateUrl: 'app/pages/usuario/usuario.html',
        controller: 'UsuarioController',
        controllerAs: 'u'
      })
      //grupo
      .state('grupo', {
        url: '/app/grupo',
        templateUrl: 'app/pages/grupo/grupo.html',
        controller: 'GrupoController',
        controllerAs: 'g'
      })
      //rol
      .state('rol', {
        url: '/app/rol',
        templateUrl: 'app/pages/rol/rol.html',
        controller: 'RolController',
        controllerAs: 'r'
      });

    $urlRouterProvider.otherwise('/app/dashboard');
  }

})();