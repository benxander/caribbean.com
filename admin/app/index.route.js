
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
      //acceso-cliente
      .state('acceso-cliente', {
        url: '/app/acceso-cliente',
        templateUrl: 'app/pages/acceso-cliente/acceso-cliente.html',
        controller: 'AccesoClienteController',
        controllerAs: 'vm'
      })
      //excursion
      .state('excursion', {
        url: '/app/excursion',
        templateUrl: 'app/pages/excursion/excursion.html',
        controller: 'ExcursionController',
        controllerAs: 'e'
      })
      //banner
      .state('banner', {
        url: '/app/banner',
        templateUrl: 'app/pages/banner/banner.html',
        controller: 'BannerController',
        controllerAs: 'b'
      })
      //seccion
      .state('seccion', {
        url: '/app/seccion',
        templateUrl: 'app/pages/seccion/seccion.html',
        controller: 'SeccionController',
        controllerAs: 'se'
      })
      //reportes
      .state('reportes', {
        url: '/app/reportes',
        templateUrl: 'app/pages/reportes/reportes.html',
        controller: 'ReportesController',
        controllerAs: 're'
      })
      //blog
      .state('blog', {
        url: '/app/blog',
        templateUrl: 'app/pages/blog/blog.html',
        controller: 'BlogController',
        controllerAs: 'bl'
      })
      //config
      .state('config', {
        url: '/app/config',
        templateUrl: 'app/pages/config/config.html',
        controller: 'ConfigController',
        controllerAs: 'cg'
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
      })
      //perfil
      .state('perfil', {
        url: '/app/perfil',
        templateUrl: 'app/pages/perfil/perfil.html',
        controller: 'PerfilController',
        controllerAs: 'p'
      })//galeria personal
      .state('mi-galeria', {
        url: '/app/mi-galeria',
        templateUrl: 'app/pages/mi-galeria/gallery.html',
        controller: 'PagesGalleryController',
        controllerAs: 'ga'
      })//galeria tienda
      .state('tienda', {
        url: '/app/tienda',
        templateUrl: 'app/pages/tienda/tienda.html',
        controller: 'TiendaController',
        controllerAs: 'ctrl'
      })
      .state('pago', {
        url: '/app/pago/?id&token',
        templateUrl: 'app/pages/pago/pago.html',
        controller: 'PagoController',
        controllerAs: 'pg'
      })
      .state('descuento', {
        url: '/app/descuento',
        templateUrl: 'app/pages/descuento/descuento.html',
        controller: 'DescuentoController',
        controllerAs: 'des'
      })
      .state('ajustes', {
        url: '/app/ajustes',
        templateUrl: 'app/pages/ajustes/ajustes.html',
        controller: 'AjustesController',
        controllerAs: 'aj'
      })
      .state('email', {
        url: '/app/email',
        templateUrl: 'app/pages/email/email.html',
        controller: 'EmailController',
        controllerAs: 'em'
      })
      .state('mensaje', {
        url: '/app/mensaje',
        templateUrl: 'app/pages/mensaje/mensaje.html',
        controller: 'MensajeController',
        controllerAs: 'mj'
      })
      .state('producto', {
        url: '/app/producto',
        templateUrl: 'app/pages/producto/producto.html',
        controller: 'ProductoController',
        controllerAs: 'pr'
      })
      .state('pedido', {
        url: '/app/pedido',
        templateUrl: 'app/pages/pedido/pedido.html',
        controller: 'PedidoController',
        controllerAs: 'pe'
      })
      .state('encuesta', {
        url: '/app/encuesta',
        templateUrl: 'app/pages/encuesta/encuesta.html',
        controller: 'EncuestaController',
        controllerAs: 'enc'
      })
      .state('medida', {
        url: '/app/medida',
        templateUrl: 'app/pages/medida/medida.html',
        controller: 'MedidaController',
        controllerAs: 'me'
      });

    $urlRouterProvider.otherwise('/app/cliente');
  }

})();
