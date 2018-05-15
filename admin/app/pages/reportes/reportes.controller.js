(function() {
  'use strict';
  angular
    .module('minotaur')
    .controller('ReportesController', ReportesController)
    .service('ReportesServices', ReportesServices);

  /** @ngInject */
  function ReportesController($scope,$uibModal,$filter, ReportesServices,toastr,alertify, pageLoading, uiGridConstants, ModalReporteFactory) {
    var vm = this;
    var openedToasts = [];
    vm.listaReportes = [];
    ReportesServices.listarReportes().then(function (rpta) {
      vm.listaReportes = rpta.datos;
      console.log('lista: ', vm.listaReportes);
      if(rpta.flag == 0){
        vm.showDivEmptyData = true;
      }
    });
    vm.selectedReport = {};

    vm.selectReport = function(row){
      vm.selectedReport = row;
      console.log('vm.selectedReport.id',vm.selectedReport.id);
    }
    //CONFIGURACIÓN PARA EL DATEPICKER
    vm.fBusqueda = {};
    vm.dp = {}
    vm.dateUIDesde = {} ;
    vm.dateUIHasta = {} ;
    vm.dp.formats = ['dd-MM-yyyy','yyyy/MM/dd','dd.MM.yyyy','shortDate'];
    vm.dp.format = vm.dp.formats[0]; // formato por defecto
    vm.dp.datePikerOptions = {
      formatYear: 'yy',
      showWeeks: false
    };
    vm.dateUIDesde.openDP = function($event) {
      $event.preventDefault();
      $event.stopPropagation();
      vm.dateUIDesde.opened = true;
    };

    vm.dateUIHasta.openDP = function($event) {
      $event.preventDefault();
      $event.stopPropagation();
      vm.dateUIHasta.opened = true;
    };
    vm.fBusqueda.desde = new Date();
    vm.fBusqueda.hasta = new Date();
    // BOTON PROCESAR
    vm.btnProcesarReporte = function () {
      switch ( vm.selectedReport.id ) {
        case 'CLI-EM':
          if(vm.fBusqueda.desde == undefined || vm.fBusqueda.hasta == undefined){
                alert('Ingrese una fecha válida'); return false;
          }
          vm.fBusqueda.fDesde = moment(vm.fBusqueda.desde).format('DD-MM-YYYY');
          vm.fBusqueda.fHasta = moment(vm.fBusqueda.hasta).format('DD-MM-YYYY');
          vm.fBusqueda.titulo = vm.selectedReport.titulo;
          vm.fBusqueda.salida = 'excel'; // de momento solo tendremos excel
          var arrParams = {
            titulo: vm.fBusqueda.titulo,
            datos: vm.fBusqueda,
            metodo: 'js'
          }

          if( vm.fBusqueda.salida == 'pdf' ){
            // arrParams.url = angular.patchURLCI+strController+'/report_detalle_por_venta_caja';
            alert('Reporte en PDF aun no implementado.'); return false;
          }else if( vm.fBusqueda.salida == 'excel' ){
            arrParams.url = angular.patchURLCI+'Reportes/clientes_email_excel';
          }
          ModalReporteFactory.getPopupReporte(arrParams);
          break;
        // NINGUN REPORTE SELECCIONADO
          default:
            toastr.warning('Seleccione un reporte', 'Advertencia');
      }
    }

  }
  function ReportesServices($http, $q) {
    return({
      listarReportes: listarReportes

    });
    function listarReportes(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Reportes/listar_reportes",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
  }
})();