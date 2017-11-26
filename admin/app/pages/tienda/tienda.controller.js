(function() {
  'use strict';

  angular
    .module('minotaur')
    .controller('TiendaController', TiendaController)
    .service('TiendaServices', TiendaServices
      );

  /** @ngInject */
  function TiendaController($scope, $uibModal, TiendaServices, ClienteServices, ExcursionServices, rootServices,toastr, pageLoading) {

    var vm = this;
    var scope = $scope;
    console.log('scope',scope);
    vm.seleccionadas = 0;
    vm.modoSeleccionar = true;
    //vm.modoSeleccionar = false;
    vm.modoPagar = false;
    vm.modoDescargaCompleta = false;
    vm.monto = 0;
    //vm.modoDescargaCompleta = true;
    vm.cargarGaleria = function(datos){
      pageLoading.start('Cargando archivos...');
      TiendaServices.sListarNoDescargados(datos).then(function(rpta){
        vm.images = rpta.datos;
        pageLoading.stop();
      });
    }
    vm.cargarExcursiones = function(datos){
      ExcursionServices.sListarExcursionPaquetesCliente(datos).then(function(rpta){
        vm.listaExcursiones = rpta.datos;
        vm.listaPaquetes = vm.listaExcursiones[0].paquetes;
        vm.monto = vm.listaPaquetes[0].monto;
      });
    }
    vm.selPaquete = function(idpaquete){
      console.log('idpaquete',idpaquete);
      angular.forEach(vm.listaPaquetes, function(paquete,key) {
        if(paquete.idpaquete == idpaquete){
          vm.listaPaquetes[key].selected = true;
          vm.monto = paquete.monto;
        }else{
          vm.listaPaquetes[key].selected = false;
        }
      });
    }
    rootServices.sGetSessionCI().then(function (response) {
      if(response.flag == 1){
        vm.fDataUsuario = response.datos;
        vm.cargarExcursiones(vm.fDataUsuario);
        vm.cargarGaleria(vm.fDataUsuario);
      }
    });

    vm.selectedAll = false;
    vm.isSelected = false;
    // console.log('$scope.isSelected',$scope.isSelected);
    // $scope.isSelected = vm.isSelected;

    vm.selectAll = function () {
      var monto = 0;
      if (vm.selectedAll) {
        vm.selectedAll = false;
        vm.isSelected = false;

      } else {
        vm.selectedAll = true;
        vm.isSelected = true;
      }

      angular.forEach(vm.images, function(image) {
        image.selected = vm.selectedAll;
        if(vm.isSelected){
          monto = monto + image.precio_float;
        }
      });
      vm.monto_total = monto.toFixed(2);
    };

    vm.selectImage = function(index) {
      var i = 0;
      var monto = 0;

      if (vm.images[index].selected) {
        vm.images[index].selected = false;
      } else {
        vm.images[index].selected = true;
        vm.isSelected = true;

      }

      angular.forEach(vm.images, function(image) {
        if (image.selected) {
          i++;
          // monto = monto + image.precio_float;
        }
      });

      if (i === 0) {
        vm.isSelected = false;
      }
     vm.seleccionadas = i;
     $scope.actualizarSeleccion(i,vm.monto);
      // console.log('fSessionCI.key_grupo', $scope.fSessionCI.key_grupo);
      // vm.monto_total = monto.toFixed(2);
    };

    // $scope.$watch('vm.monto',function(newValue,oldValue = vm.monto) {
    //   console.log('newValue',newValue);
    //   console.log('oldValue',oldValue);
    //   if (newValue===oldValue) {
    //     console.log('vm.monto',vm.monto);
    //     return;
    //   }
    //   console.log('watch dif');
    //   $scope.actualizarSaldo(newValue,vm.monto);
    // });
    vm.monto_total = 0.00;
    vm.monto_descuento = 0.00;
    vm.monto_bonificacion = 0.00;

    vm.btnDescargarFiles = function(){
      if(!vm.isSelected){
        return;
      }

      pageLoading.start('Verificando seleccion...');
      var datos = {
        seleccion : vm.images,
        usuario : vm.fDataUsuario
      }

      TiendaServices.sVerificarSeleccion(datos).then(function(rpta){
        vm.datosVista = rpta;
        vm.calculaDescuentos();

        if(vm.datosVista.mostrar_productos){
          angular.forEach(vm.images, function(image,key) {
            if (image.selected) {
              vm.images[key].lista_productos = angular.copy(vm.datosVista.lista_productos);
            }
          });
        }

        vm.modoSeleccionar=false;
        vm.modoPagar=true;
        pageLoading.stop();
      });
    }

    vm.calculaDescuentos = function(){
      if(vm.datosVista.tiene_bonificacion){
        var encontrado = false;
        angular.forEach(vm.images, function(image) {
          if (image.selected && !encontrado) {
            vm.monto_bonificacion = image.precio_float;
            encontrado = true;
          }
        });
      }

      if(vm.datosVista.tiene_descuento){
        vm.monto_descuento = (parseFloat(vm.monto_total) * parseFloat(vm.datosVista.descuento.descuento) / 100).toFixed(2);
        vm.monto_neto = (parseFloat(vm.monto_total) - parseFloat(vm.monto_descuento)).toFixed(2);
      }
    }

    vm.updatePrecio = function(producto){
      var productos = (parseInt(producto.cantidad) * parseFloat(producto.precio)).toFixed(2);
      vm.monto_total = (parseFloat(vm.monto_total) + parseFloat(productos)).toFixed(2);
      vm.calculaDescuentos();
    }

    vm.btnVolver = function(){
      angular.forEach(vm.images, function(image) {
        image.selected = false;
      });
      vm.monto_total = 0.00;
      vm.modoSeleccionar=true;
      vm.modoPagar=false;
    }
    vm.btnPagar = function(){
      vm.modoSeleccionar = false;
      vm.modoPagar=false;
      /*aqui deberia incorporar proceso de pago y si es valido llevarlo al metodo que mueve las imagenes y muestra la encuesta*/
      vm.irCompraExitosa();
    }

    vm.irCompraExitosa = function(){
      pageLoading.start('Procesando descarga...');
      TiendaServices.sDescargarArchivosPagados(vm.images).then(function(rpta){
        if(rpta.flag == 1){
          vm.modoDescargaCompleta=true;
          var title = 'OK';
          var type = 'success';
          toastr.success(rpta.message, title);
        }else if(rpta.flag == 0){
          var title = 'Advertencia';
          var type = 'warning';
          toastr.warning(rpta.message, title);
        }else{
          alert('Error inesperado');
        }
        pageLoading.stop();
      });
    }

    vm.calificar = function(value){
      vm.calificacion = value;
      vm.fDataUsuario.puntos = value;
      ClienteServices.sRegistrarPuntuacion(vm.fDataUsuario).then(function(rpta){
        if(rpta.flag == 1){
          vm.modoCalificacionOk=true;
          var title = 'OK';
          var type = 'success';
          toastr.success(rpta.message, title);
        }else if(rpta.flag == 0){
          var title = 'Advertencia';
          var type = 'warning';
          toastr.warning(rpta.message, title);
        }else{
          alert('Error inesperado');
        }
      });
    }
    vm.btnPedidos = function(index){
      var modalInstance = $uibModal.open({
          templateUrl: 'app/pages/tienda/pedido_formview.php',
          controllerAs: 'mp',
          size: 'lg',
          backdropClass: 'splash splash-2 splash-ef-16',
          windowClass: 'splash splash-2 splash-ef-16',
          backdrop: 'static',
          keyboard:false,
          scope: $scope,
          controller: function($scope, $uibModalInstance, arrToModal ){
            var vm = this;
            vm.fData = {};
            vm.modoEdicion = false;
            vm.getPaginationServerSide = arrToModal.getPaginationServerSide;
            vm.modalTitle = 'Merchandise';

            // botones
              vm.aceptar = function () {
                // ClienteServices.sRegistrarCliente(vm.fData).then(function (rpta) {
                //   if(rpta.flag == 1){
                //     $uibModalInstance.close(vm.fData);
                //     vm.getPaginationServerSide();
                //     var title = 'OK';
                //     var type = 'success';
                //     toastr.success(rpta.message, title);
                //   }else if( rpta.flag == 0 ){
                //     var title = 'Advertencia';
                //     var type = 'warning';
                //     toastr.warning(rpta.message, title);
                //   }else{
                //     alert('Ocurrió un error');
                //   }
                // });

              };
              vm.cancel = function () {
                $uibModalInstance.dismiss('cancel');
              };
          },
          resolve: {
            arrToModal: function() {
              return {
                getPaginationServerSide : vm.getPaginationServerSide,
                scope : vm,
              }
            }
          }
        });
    }
  }

  function TiendaServices($http, $q) {
    return({
        sListarNoDescargados: sListarNoDescargados,
        sDescargarArchivosPagados: sDescargarArchivosPagados,
        sVerificarSeleccion:sVerificarSeleccion,
    });

    function sListarNoDescargados(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Archivo/listar_archivos_no_descargados",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }

    function sDescargarArchivosPagados(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Compra/descargar_archivos_pagados",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }

    function sVerificarSeleccion(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Compra/verificar_archivos_seleccion",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
  }
})();
