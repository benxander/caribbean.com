(function() {
  'use strict';

  angular
    .module('minotaur')
    .controller('TiendaController', TiendaController)
    .service('TiendaServices', TiendaServices
      );

  /** @ngInject */
  function TiendaController($scope,$timeout, $uibModal, TiendaServices, ClienteServices, ExcursionServices, ProductoServices, rootServices,toastr, pageLoading, alertify) {

    var vm = this;
    var scope = $scope;
    vm.dirImagesProducto = $scope.dirImages + "producto/";
    vm.seleccionadas = 0;
    vm.modoSeleccionar = true;
    vm.modoPagar = false;
    vm.modoDescargaCompleta = false;
    vm.monto = 0;
    vm.alertAdicionales = false;
    vm.isPagoMonedero = false;
    vm.paqueteSeleccionado = {};
    vm.selectedAll = false;
    vm.isSelected = false;
    vm.selectedTerminos = false;

    vm.cantidad_adic = 0;
    vm.cantidad_video = 0;
    vm.monto_total = 0.00;
    vm.monto_a_pagar = 0.00;
    vm.monto_descuento = 0.00;
    vm.monto_bonificacion = 0.00;
    vm.monto_adicionales = 0.00;
    vm.monto_adicionales_video = 0.00;
    vm.precio_video = 0;
    vm.precio_adicional = 0;

    rootServices.sGetSessionCI().then(function (response) {
      if(response.flag == 1){
        vm.fDataUsuario = response.datos;
        vm.cargarExcursiones(vm.fDataUsuario);
        vm.cargarGaleria(vm.fDataUsuario);
      }
    });
    vm.cargarGaleria = function(datos){
      pageLoading.start('Cargando archivos...');
      TiendaServices.sListarNoDescargados(datos).then(function(rpta){
        vm.images = rpta.datos;
        pageLoading.stop();
      });
    }
    vm.cargarExcursiones = function(datos){
      ExcursionServices.sListarExcursionPaquetesCliente(datos).then(function(rpta){
        console.log(rpta.datos);
        vm.listaExcursiones = rpta.datos;
        vm.listaPaquetes = vm.listaExcursiones[0].paquetes;
        vm.paqueteSeleccionado = vm.listaPaquetes[0];
        vm.monto = vm.listaPaquetes[0].monto;
        vm.precio_adicional = vm.listaExcursiones[0].precio_por_adicional;
        vm.precio_video = vm.listaExcursiones[0].precio_video;
      });
    }
    vm.selPaquete = function(idpaquete){
      angular.forEach(vm.listaPaquetes, function(paquete,key) {
        if(paquete.idpaquete == idpaquete){
          vm.listaPaquetes[key].selected = true;
          vm.paqueteSeleccionado = paquete;
          vm.monto = parseFloat(paquete.monto);
          vm.actualizaMontoPaquete();
        }else{
          vm.listaPaquetes[key].selected = false;
        }
      });
    }
    vm.actualizaMontoPaquete =  function(){
      if(vm.isPagoMonedero){
        $scope.actualizarSaldo(false);
        $scope.actualizarSaldo(true,vm.monto);
        if($scope.seleccionadas > vm.paqueteSeleccionado.cantidad){
          var cantidad = $scope.seleccionadas - vm.paqueteSeleccionado.cantidad;
          $scope.actualizarSaldo(true,cantidad * vm.precio_adicional);
        }
      }
    }
    vm.selectAll = function () {
      if (vm.selectedAll) {
        vm.selectedAll = false;
        vm.isSelected = false;

      } else {
        vm.selectedAll = true;
        vm.isSelected = true;
      }
      var i=0;
      angular.forEach(vm.images, function(image) {
        if(!vm.isPagoMonedero && vm.paqueteSeleccionado){
          vm.isPagoMonedero = true;
          $scope.actualizarSaldo(true,vm.monto);
        }
        if(image.descargado == 2){
          image.selected = vm.selectedAll;
          i++;
        }
      });
      vm.seleccionadas = i;
      if(i > vm.paqueteSeleccionado.cantidad){
        var cantidad = i - vm.paqueteSeleccionado.cantidad;
        if(vm.isSelected){
          $scope.actualizarSaldo(true,cantidad * vm.precio_adicional);
        }else{
          $scope.actualizarSaldo(true,'-'+(cantidad * vm.precio_adicional));
          i=0;
        }
      }else if(!vm.isSelected){
        i=0;
      }
      $scope.actualizarSeleccion(i);
    };
    vm.selectImage = function(index) {
      var i = 0;
      var add = false;

      if (vm.images[index].selected) {
        vm.images[index].selected = false;
        add = false;
      } else {
        vm.images[index].selected = true;
        vm.isSelected = true;
        add = true;
        if(!vm.isPagoMonedero && vm.paqueteSeleccionado){
          vm.isPagoMonedero = true;
          $scope.actualizarSaldo(true,vm.monto);
        }
      }

      angular.forEach(vm.images, function(image) {
        if (image.selected) {
          i++;
        }
      });

      if (i === 0) {
        vm.isSelected = false;
      }
      vm.seleccionadas = i;
      $scope.actualizarSeleccion(i);
      if(add && (vm.seleccionadas > vm.paqueteSeleccionado.cantidad)){
        if(!vm.alertAdicionales){
          alert("Apartir de ahora se cobrará USD$ "+vm.precio_adicional+" por cada foto adicional");
          vm.alertAdicionales = true;
        }
        $scope.actualizarSaldo(true,vm.precio_adicional);
      }else if(!add && vm.seleccionadas >= vm.paqueteSeleccionado.cantidad){
        $scope.actualizarSaldo(true,'-'+ vm.precio_adicional);
      }
    };
    vm.confirmDescarga = function(){
      if(!vm.isSelected){
        return;
      }
      if($scope.seleccionadas < vm.paqueteSeleccionado.cantidad){
        alertify.confirm('¿Esta seguro de continuar? <br/>'+
          'Aun tiene '+ (vm.paqueteSeleccionado.cantidad - vm.seleccionadas)
          +' fotos por seleccionar', function(){
           vm.verResumen();
        });
      }else{
        vm.verResumen();
      }
    }
    vm.verResumen = function(){
      if(!vm.isSelected){
        return;
      }
      pageLoading.start('Procesando...');
      vm.listaImagenes = [];
      angular.forEach(vm.images, function(image) {
        if (image.selected) {
          vm.listaImagenes.push(image);
        }
      });
      var datos = {
        seleccion : vm.images,
        usuario : vm.fDataUsuario
      }
      // vm.cargarProductos = function(){
      // pageLoading.start('Procesando...');
      ProductoServices.sListarProductoPedido().then(function (rpta) {
        vm.listaProductos = angular.copy(rpta.datos);
        // console.log('data',vm.listaProductos);
        // pageLoading.stop();
      });
      // }
      TiendaServices.sVerificarSeleccion(datos).then(function(rpta){
        pageLoading.stop();
        vm.datosVista = rpta;
        // vm.calcularTotales();
        // vm.calculaDescuentos();
        vm.agregarGrilla();

        vm.modoSeleccionar=false;
        vm.modoPagar=true;
      });
      vm.agregarGrilla = function(){

        // GRILLA RESUMEN
          vm.gridOptions = {
            minRowsToShow: 3,
            appScopeProvider: vm
          }
          vm.gridOptions.columnDefs = [
            { field: 'producto', displayName: 'PRODUCTO' },
            { field: 'categoria', displayName: 'CATEGORIA',  width:100, visible:false },
            { field: 'color',  displayName: 'COLOR',  width:80, visible:false },
            { field: 'talla',  displayName: 'TALLA',  width:120, visible:false },
            { field: 'cantidad',  displayName: 'CANTIDAD',  width:80 },
            { field: 'precio',  displayName: 'PRECIO',  width:80 },
            { field: 'total_detalle',  displayName: 'TOTAL',  width:80 },
            { field: 'accion', displayName: '', width: 60,
              cellTemplate: '<div>' +
              '<button class="btn btn-default btn-sm text-red btn-action" ng-click="grid.appScope.btnQuitarDeLaCesta(row)" tooltip-placement="left" uib-tooltip="ELIMINAR"> <i class="fa fa-trash"></i> </button>' +
              '</div>'
            }
          ];
          vm.gridOptions.data = [];
        vm.arrTemporal = {
          'producto' : 'PAQUETE: ' + vm.paqueteSeleccionado.titulo_pq,

          'cantidad' : 1,
          'precio' : parseInt(vm.monto),
          'total_detalle' : parseInt(vm.monto),
          // 'tipo_seleccion' : vm.temporal.tipo_seleccion,
          // 'imagenes': vm.temporal.imagen,
        }
        vm.gridOptions.data.push(vm.arrTemporal);
        if(vm.cantidad_adic>0){
          vm.arrTemporal = {
            'idproducto' : 'FOTO ADICIONAL',
            'cantidad' : parseInt(vm.cantidad_adic),
            'precio' : parseInt(vm.precio_adicional),
            'total_detalle' : parseInt(vm.monto_adicionales),
          }
          vm.gridOptions.data.push(vm.arrTemporal);
        }
        if(vm.cantidad_video>0){
          vm.arrTemporal = {
            'idproducto' : 'VIDEO ADICIONAL',
            'cantidad' : parseInt(vm.cantidad_video),
            'precio' : parseInt(vm.precio_video),
            'total_detalle' : parseInt(vm.monto_adicionales_video),
          }
          vm.gridOptions.data.push(vm.arrTemporal);
        }
        vm.calcularGrilla();
        // vm.calculaDescuentos();
      }
      vm.calcularGrilla = function(){
        vm.cantidad_adic = $scope.seleccionadas - vm.paqueteSeleccionado.cantidad;
        console.log(vm.precio_adicional,vm.precio_video );
        if(vm.cantidad_adic > 0){
          vm.monto_adicionales = parseFloat(vm.cantidad_adic * vm.precio_adicional);
        }else{
          vm.cantidad_adic = 0;
        }
        vm.monto_total = parseFloat(vm.monto + vm.monto_adicionales);
        if(vm.datosVista.tiene_descuento){
          vm.monto_descuento = (parseFloat(vm.monto_total) * parseFloat(vm.datosVista.descuento.descuento) / 100);
        }

        vm.monto_total = parseFloat(vm.monto_total - vm.monto_descuento);
        vm.restante = parseFloat($scope.fSessionCI.monedero - vm.monto_total).toFixed(2);


        if(vm.restante < 0){
          vm.monto_a_pagar = Math.abs(vm.restante);
          vm.saldo_final = 0;
        }else{
          vm.saldo_final = vm.restante;
          vm.monto_a_pagar = 0;
        }
      }
    }
    vm.btnPedidos = function(imagen){ // btn merchandising
      var imagen = imagen || null;
      if(vm.pedidoBool){ // regresar
        vm.pedidoBool = false;
        vm.productoBool = false;
        //$state.reload();
        vm.cargarGaleria(vm.fDataUsuario,true);
      }else{ // merchandising
        vm.pedidoBool = true;
        vm.imagen = imagen;
      }
    }
    vm.cambiaProducto = function(producto){ // pestaña productos
      vm.productoBool = false;
    }
    vm.selectCat = function(categoria, producto){ //basico - premium
      vm.productoBool = true;
      vm.categoriaSel = categoria;

      vm.temporal = {};
      vm.temporal.cantidad = 1;
      vm.temporal.isSel = false;
      vm.temporal.idproductomaster = producto.idproductomaster;
      vm.temporal.producto = producto.descripcion_pm;
      vm.temporal.categoria = categoria;
      vm.temporal.idproductomaster = producto.idproductomaster;
      vm.temporal.producto = producto.descripcion_pm;
      vm.temporal.si_genero = producto.si_genero;
      vm.temporal.si_color = producto.si_color;
      vm.temporal.tipo_seleccion = producto.tipo_seleccion;
      // vm.temporal.color = null;
      // vm.temporal.idcolor = null;
      // vm.temporal.idcolor = null;
      if( vm.temporal.tipo_seleccion == 1 && vm.imagen ){
        vm.temporal.imagen = vm.imagen;
        vm.temporal.isSel = true;
      }else if( vm.temporal.tipo_seleccion == 2 ){
        vm.temporal.imagen = [];
      }else{
        vm.temporal.imagen = null;
      }
    }
    vm.cambiaColor = function(color,idproductomaster){
      vm.temporal.color = color.nombre;
    }
    vm.cambiaMedida = function(size){
      var cantidad = vm.temporal.cantidad;
      vm.temporal.size = size;
      if( cantidad== 1 ){
        vm.temporal.precio = size.precio;
      }else
      if( cantidad > 1 && cantidad < 6 ){
        vm.temporal.precio = size.precio_2_5;
      }else
      if( cantidad >= 6 ){
        vm.temporal.precio = size.precio_mas_5;
      }else{
        vm.temporal.precio = 0;
      }
      if(vm.temporal.tipo_seleccion == '2'){
        vm.temporal.isSel = false;
        angular.forEach(vm.images, function(image) {
          image.selected = false;
        });
      }
      vm.temporal.total_detalle = vm.temporal.precio * cantidad;
      vm.temporal.talla = size.denominacion;
    }
    vm.cambiaCantidad = function(){
      var cantidad = vm.temporal.cantidad;
      var size = vm.temporal.size || null;
      console.log('size',size);
      if(size){
        if( cantidad== 1 ){
          vm.temporal.precio = size.precio;
        }else if( cantidad > 1 && cantidad < 6 ){
          vm.temporal.precio = size.precio_2_5;
        }else if( cantidad >= 6 ){
          vm.temporal.precio = size.precio_mas_5;
        }else{
          vm.temporal.precio = 0;
        }
        vm.temporal.total_detalle = vm.temporal.precio * cantidad;
      }
    }
    vm.selectFotografia = function(item){
      if(item.tipo_seleccion == '2' && !angular.isObject(vm.temporal.size)){
        toastr.warning('Seleccione primero un tamaño', 'Advertencia');
        return false;
      }
      var modalInstance = $uibModal.open({
        templateUrl: 'app/pages/tienda/galeria_modal_tienda.php',
        controllerAs: 'gm',
        size: 'lg',
        backdropClass: 'splash splash-2 splash-info splash-ef-13',
        windowClass: 'splash splash-2 splash-info splash-ef-13',
        // backdrop: 'static',
        // keyboard:false,
        scope: $scope,
        controller: function($scope, $uibModalInstance, arrToModal ){
          var vm = this;
          // vm.seleccion = arrToModal.scope.seleccion;
          console.log('seleccion',item.tipo_seleccion);
          vm.images = arrToModal.scope.listaImagenes;
          console.log('vm.images',vm.images);
          vm.tipo_seleccion = item.tipo_seleccion;
          if(vm.tipo_seleccion == '2'){
            vm.cantidad_fotos = arrToModal.scope.temporal.size.cantidad_fotos;
            console.log('size',arrToModal.scope.temporal.size.cantidad_fotos);
          }
          vm.modalTitle = 'Selecciona Fotografía';
          vm.selectFoto = function(imagen, index){
            if(vm.tipo_seleccion == '1'){
              arrToModal.scope.temporal.imagen = imagen;
              arrToModal.scope.temporal.isSel = true;
              $uibModalInstance.dismiss('cancel');
            }else{
              vm.cantidad_fotos = arrToModal.scope.temporal.size.cantidad_fotos;
              var i = 0;
              if (vm.images[index].selected) {
                vm.images[index].selected = false;
              } else {
                vm.images[index].selected = true;
              }
              angular.forEach(vm.images, function(image) {
                if (image.selected) {
                  i++;
                }
              });
              if (i >= vm.cantidad_fotos) {
                arrToModal.scope.temporal.isSel = true;
                $uibModalInstance.dismiss('cancel');
              }
            }
          }
          vm.aceptar = function () {
            $uibModalInstance.dismiss('cancel');
          };
        },
        resolve: {
          arrToModal: function() {
            return {
              scope : vm,
            }
          }
        }
      });

    }
    vm.agregarItem = function(temp){
      if( !vm.temporal.idcolor && vm.temporal.si_color == 1){
        toastr.warning('Seleccione un color', 'Advertencia');
        return false;
      }
      if( vm.temporal.si_genero == 1 && !vm.temporal.genero ){
        toastr.warning('Seleccione un género', 'Advertencia');
        return false;
      }
      if( !angular.isObject(vm.temporal.size) ){
        toastr.warning('Seleccione un tamaño', 'Advertencia');
        return false;
      }
      // if( vm.temporal.tipo_seleccion == 1 ){
      //   console.log('unica');
      //   if( !angular.isObject(vm.temporal.imagen) ){
      //     toastr.warning('Seleccione una fotografía', 'Advertencia');
      //     return false;
      //   }
      // }else{
      //   console.log('multiple');
      //   vm.temporal.imagen = [];
      //   angular.forEach(vm.images, function(image,key) {
      //     if (image.selected) {
      //       vm.temporal.imagen.push(image);
      //     }
      //   });
      //   if(vm.temporal.imagen.length <= 0){
      //     toastr.warning('Seleccione fotografías', 'Advertencia');
      //     return false;
      //   }
      // }
      console.log('vm.temporal',vm.temporal);
      vm.arrTemporal = {}
      var adicional = '';
      if(vm.temporal.si_genero == 1){
        adicional = vm.temporal.genero == 'H'? ' - HOMBRE' : ' - MUJER';
      }
      vm.arrTemporal = {
        'idproducto' : vm.temporal.idproducto,
        'producto' : vm.temporal.producto + adicional,
        'genero' : vm.temporal.si_genero == 1 ? vm.temporal.genero : null,
        'categoria' : vm.temporal.categoria.descripcion_ca,
        'idcolor' : vm.temporal.idcolor,
        'color' : vm.temporal.color,
        'talla' : vm.temporal.talla,
        'cantidad' : vm.temporal.cantidad,
        'precio' : vm.temporal.precio,
        'total_detalle' : vm.temporal.total_detalle,
        'tipo_seleccion' : vm.temporal.tipo_seleccion,
        'imagenes': vm.temporal.imagen,
      }
      vm.gridOptions.data.push(vm.arrTemporal);
      // console.log('data',vm.gridOptions.data);
      // console.log('temp',temp);
      var producto = vm.temporal.producto;
      var categoria = vm.temporal.categoria;
      var si_genero = vm.temporal.si_genero;
      var tipo_seleccion = vm.temporal.tipo_seleccion;
      vm.temporal = {};
      vm.temporal.cantidad = 1;
      vm.temporal.isSel = false;
      // vm.temporal.idproductomaster = producto.idproductomaster;
      vm.temporal.producto = producto;
      vm.temporal.categoria = categoria;
      vm.temporal.si_genero = si_genero;
      vm.temporal.tipo_seleccion = tipo_seleccion;
      vm.calcularTotales();
    }
    vm.btnQuitarDeLaCesta = function(row){
      var index = vm.gridOptions.data.indexOf(row.entity);
            vm.gridOptions.data.splice(index,1);
            vm.calcularTotales();
    }
    vm.calculaDescuentos = function(){
      // if(vm.datosVista.tiene_bonificacion){
      //   var encontrado = false;
      //   angular.forEach(vm.images, function(image) {
      //     if (image.selected && !encontrado) {
      //       vm.monto_bonificacion = image.precio_float;
      //       encontrado = true;
      //     }
      //   });
      // }

      if(vm.datosVista.tiene_descuento){
        vm.monto_descuento = (parseFloat(vm.monto_total) * parseFloat(vm.datosVista.descuento.descuento) / 100).toFixed(2);
        vm.monto_neto = (parseFloat(vm.monto_total) - parseFloat(vm.monto_descuento)).toFixed(2);
      }
    }


    vm.calcularTotales = function(){
      var total = 0;
      angular.forEach(vm.gridOptions.data,function (value, key) {
        total += parseFloat(vm.gridOptions.data[key].total_detalle);
      });
      // vm.monto_total = total;
      vm.monto_total = total;
      if($scope.fSessionCI.monedero > 0){
        vm.saldo_inicial = $scope.fSessionCI.monedero;
        vm.restante = vm.saldo_inicial - vm.monto_total;
        console.log('vm.restante',vm.restante);
        if(vm.restante <= 0){
          vm.monto_a_pagar = Math.abs(vm.restante);
          vm.saldo_final = 0;
        }else{
          vm.saldo_final = vm.restante;
          vm.monto_a_pagar = 0;
        }
      }
    }
    vm.btnVolver = function(){
      /*angular.forEach(vm.images, function(image) {
        image.selected = false;
      });*/
      vm.monto_total = 0.00;
      vm.modoSeleccionar = true;
      vm.modoPagar = false;
      // vm.selectedAll = false;
      //vm.isPagoMonedero = false;
      /*$scope.actualizarSeleccion(0,0);
      $scope.actualizarSaldo(false);*/
    }
    vm.limpiar = function(){
      vm.cantidad_adic = 0;
      vm.cantidad_video = 0;
      vm.monto_total = 0.00;
      vm.monto_a_pagar = 0.00;
      vm.monto_descuento = 0.00;
      vm.monto_bonificacion = 0.00;
      vm.monto_adicionales = 0.00;
      vm.monto_adicionales_video = 0.00;
      vm.modoPagar = false;
      vm.selectedAll = false;
      vm.isPagoMonedero = false;
      $scope.actualizarSeleccion(0);
      $scope.actualizarSaldo(false);
    }
    vm.btnValidar = function(){
      if(!vm.selectedTerminos){
        alert("Debe aceptar los Términos y Condiciones");
        return false;
      }else{
        vm.btnPagar();
      }
    }
    vm.btnPagar = function(){
      vm.modoSeleccionar = false;
      vm.modoPagar = false;
      if(vm.monto_a_pagar > 0){
       /*aqui deberia incorporar proceso de pago y si es valido llevarlo al metodo que mueve las imagenes y muestra la encuesta*/
      }

      var datos = {
        monedero: vm.restante,
        idcliente: $scope.fSessionCI.idcliente,
        saldo: $scope.fSessionCI.monedero
      };
      TiendaServices.sActualizarMonedero(datos).then(function(rpta){
        if(rpta.flag == 1){
          vm.irCompraExitosa();
          $scope.getValidateSession();
          $scope.actualizarSaldo(false);
        }else{
          alert(rpta.message);
          $scope.getValidateSession();
          location.reload();
        }
      });

    }
    vm.irCompraExitosa = function(){
      pageLoading.start('Procesando descarga...');
      TiendaServices.sDescargarArchivosPagados(vm.images).then(function(rpta){
        if(rpta.flag == 1){
          vm.modoDescargaCompleta=true;
          vm.limpiar();
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
  }

  function TiendaServices($http, $q) {
    return({
        sListarNoDescargados: sListarNoDescargados,
        sDescargarArchivosPagados: sDescargarArchivosPagados,
        sVerificarSeleccion: sVerificarSeleccion,
        sActualizarMonedero: sActualizarMonedero,
        sRegistrarMovimiento: sRegistrarMovimiento,
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

    function sActualizarMonedero(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Cliente/actualizar_monedero",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sRegistrarMovimiento(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Movimiento/registrar_movimiento",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
  }
})();
