(function() {
  'use strict';

  angular
    .module('minotaur')
    .controller('TiendaController', TiendaController)
    .service('TiendaServices', TiendaServices
      );

  /** @ngInject */
  function TiendaController($scope,$timeout, $uibModal, $stateParams, TiendaServices, ClienteServices, ExcursionServices, MensajeServices, rootServices,toastr, pageLoading, alertify) {

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
    vm.esPack = false;
    vm.esIndividual = false;
    vm.pasarela = false;
    console.log('$stateParams.',$stateParams);

    rootServices.sGetSessionCI().then(function (response) {
      if(response.flag == 1){
        vm.fDataUsuario = response.datos;
        vm.cargarMensajes();
        if(!angular.isUndefined($stateParams.id) && !angular.isUndefined(response.datos.token)){
          var idmovimiento = $stateParams.id;
          var token = $stateParams.token;

          if( token == response.datos.token ){
            $scope.actualizarMonto(0);
            $scope.fSessionCI.monedero = 0;
            $scope.actualizarSaldo(false);
            vm.modoSeleccionar = false;
            vm.irCompraExitosa(idmovimiento);
            return;
          }
        }
        vm.cargarExcursiones(vm.fDataUsuario);
        vm.cargarGaleria(vm.fDataUsuario);
      }else{
        $window.location.href = $scope.dirBase+'zona-privada';
      }
    });
    vm.cargarMensajes = function(){
      MensajeServices.sListarMensajes().then(function(rpta){
        vm.mensajes = rpta.datos;
      });
    }
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
        vm.precio_primera = vm.listaExcursiones[0].precio_primera;
        vm.precio_video = vm.listaExcursiones[0].precio_video;
      });
    }
    vm.selPaquete = function(){
      if((vm.radioModel == 'Pack' && vm.esPack) || (vm.radioModel == 'Sueltas' && vm.esIndividual )){
        return false;
      }
      if(vm.radioModel == 'Pack'){
        vm.esPack = true;
        vm.esIndividual = false;
        vm.selectAll();
      }else if(vm.radioModel == 'Sueltas'){
        vm.esPack = false;
        vm.esIndividual = true;
        vm.selectAll();
      }
    }
    vm.actualizaMontoPaquete =  function(){
      if(vm.isPagoMonedero){
        $scope.actualizarSaldo(false);
        $scope.actualizarSaldo(true,vm.monto);
      }
    }
    vm.selectAll = function () {
      if (vm.selectedAll && vm.esIndividual) {
        console.log('pack');
        vm.selectedAll = false;
        vm.isSelected = false;
        $scope.actualizarMonto(0);
        $scope.actualizarSaldo(false);
      } else if(!vm.selectedAll && vm.esPack) {
        vm.selectedAll = true;
        vm.isSelected = true;
        $scope.actualizarMonto(vm.monto);
        $scope.actualizarSaldo(true,vm.monto);
      }
      var i=0;
      angular.forEach(vm.images, function(image) {
        if(image.descargado == 2){
          image.selected = vm.selectedAll;
          i++;
        }
      });
      if(!vm.isSelected){
        i=0;
      }
      vm.seleccionadas = i;
      $scope.actualizarSeleccion(i);
    };
    vm.selectImage = function(index) {
      if(vm.esPack || !vm.esIndividual){
        return false;
      }
      var i = 0;
      var add = false;

      if (vm.images[index].selected) {
        vm.images[index].selected = false;
        add = false;
      } else {
        vm.images[index].selected = true;
        vm.isSelected = true;
        add = true;
      }
      angular.forEach(vm.images, function(image) {
        if (image.selected) {
          i++;
        }
      });

      if (i === 0) {
        vm.isSelected = false;
        $scope.actualizarMonto(0);
        $scope.actualizarSaldo(false);
      }else if(i == 1){
        console.log('foto suelta');
        $scope.actualizarMonto(vm.precio_primera);
        $scope.actualizarSaldo(true,vm.precio_primera);
        vm.monto = vm.precio_primera;
      }else if(i > 1){
        var monto_total = (i - 1)*vm.precio_adicional + vm.precio_primera;
        $scope.actualizarMonto(monto_total);
        $scope.actualizarSaldo(true,monto_total);
        vm.monto = monto_total;
      }
      vm.seleccionadas = i;
      $scope.actualizarSeleccion(i);
    };
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
      TiendaServices.sVerificarSeleccion(datos).then(function(rpta){
        pageLoading.stop();
        // vm.datosVista = rpta;
        // if(vm.datosVista.mostrar_productos){
        //   vm.cargarProductos();
        // }
        vm.modoPagar=true;
      });
      /*vm.cargarProductos = function(){
        ProductoServices.sListarProductoPedido().then(function (rpta) {
          vm.listaProductos = angular.copy(rpta.datos);
        });
      }*/
      vm.calcularGrilla = function(){
        vm.monto_total = vm.monto;
        vm.restante = parseFloat($scope.fSessionCI.monedero - vm.monto);
        if(vm.restante < 0){
          vm.monto_a_pagar = Math.abs(vm.restante);
          vm.saldo_final = 0;
        }else{
          vm.saldo_final = vm.restante;
          vm.monto_a_pagar = 0;
        }
      }
      vm.agregarGrilla = function(){
        // GRILLA RESUMEN
          vm.gridOptions = {
            minRowsToShow: 3,
            appScopeProvider: vm
          }
          vm.gridOptions.columnDefs = [
            { field: 'producto', displayName: 'PRODUCTO', minWidth:120 },
            { field: 'cantidad',  displayName: 'CANTIDAD FOTOS',  width:150 },
            { field: 'precio',  displayName: 'PRECIO',  width:80 },
            { field: 'total_detalle',  displayName: 'TOTAL',  width:80 },
            /*{ field: 'accion', displayName: '', width: 60,
              cellTemplate: '<div>' +
              '<button class="btn btn-default btn-sm text-red btn-action" ng-click="grid.appScope.btnQuitarDeLaCesta(row)" tooltip-placement="left" uib-tooltip="ELIMINAR" ng-if="row.entity.es_pedido"> <i class="fa fa-trash"></i> </button>' +
              '</div>'
            }*/
          ];
          vm.gridOptions.data = [];
          vm.getTableHeight = function(){
             var rowHeight = 26; // your row height
             var headerHeight = 25; // your header height
             return {
                height: (vm.gridOptions.data.length * rowHeight + headerHeight + 40) + "px"
                // height: (6 * rowHeight + headerHeight + 20) + "px"
             };
          };
        vm.arrTemporal = {
          'idpaquete': vm.paqueteSeleccionado.idpaquete,
          'producto' : 'PAQUETE: ' + vm.listaExcursiones[0].titulo_act,

          'cantidad' : vm.listaImagenes.length,
          // 'cantidad' : 1,
          'precio' : parseInt(vm.monto)/vm.listaImagenes.length,
          'total_detalle' : parseInt(vm.monto),
          'es_pedido': false,
          'tipo_seleccion' : 2,
          'imagenes': vm.listaImagenes,
        }
        vm.gridOptions.data.push(vm.arrTemporal);
        console.log('data',vm.gridOptions.data);
      }
      console.log('calculo');
      vm.calcularGrilla();
      vm.agregarGrilla();
      vm.modoSeleccionar=false;
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
          vm.images = arrToModal.scope.listaImagenes;
          vm.tipo_seleccion = item.tipo_seleccion;
          if(vm.tipo_seleccion == '2'){
            vm.cantidad_fotos = arrToModal.scope.temporal.size.cantidad_fotos;
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
      if( vm.temporal.tipo_seleccion == 1 ){
        if( !angular.isObject(vm.temporal.imagen) ){
          toastr.warning('Seleccione una fotografía', 'Advertencia');
          return false;
        }
      }else{
        vm.temporal.imagen = [];
        angular.forEach(vm.images, function(image,key) {
          if (image.selected) {
            vm.temporal.imagen.push(image);
          }
        });
        if(vm.temporal.imagen.length <= 0){
          toastr.warning('Seleccione fotografías', 'Advertencia');
          return false;
        }
      }
      vm.arrTemporal = {}
      var adicional = '';
      vm.gridOptions.columnDefs[1].visible = true;
      vm.gridOptions.columnDefs[2].visible = true;
      vm.gridOptions.columnDefs[3].visible = true;
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
        'es_pedido': true
      }
      vm.gridOptions.data.push(vm.arrTemporal);
      // console.log('data',vm.gridOptions.data);
      // console.log('temp',temp);
      $scope.actualizarSaldo(true,vm.temporal.total_detalle);
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
      $scope.actualizarSaldo(true,'-'+row.entity.total_detalle);
      var index = vm.gridOptions.data.indexOf(row.entity);
      vm.gridOptions.data.splice(index,1);
      vm.calcularTotales();
    }
    vm.calculaDescuentos = function(){
      if(vm.datosVista.tiene_descuento){
        vm.monto_descuento = (parseFloat(vm.monto_total) * parseFloat(vm.datosVista.descuento.descuento) / 100).toFixed(2);
        vm.monto_neto = (parseFloat(vm.monto_total) - parseFloat(vm.monto_descuento)).toFixed(2);
      }
    }
    vm.calcularTotales = function(){
      var total = 0;
      angular.forEach(vm.gridOptions.data,function (value, key) {
        total += parseFloat(value.total_detalle);
      });
      // vm.monto_total = total;
      vm.monto_total = total;
      // if($scope.fSessionCI.monedero > 0){
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
      // }
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
      $scope.actualizarMonto(0);
    }
    /*vm.completarDatos = function(){
      var modalInstance = $uibModal.open({
        templateUrl: 'app/pages/cliente/completa_datos_view.php',
        // templateUrl: 'app/pages/tienda/terminos.php',
        controllerAs: 'cdm',
        size: '',
        backdropClass: 'splash splash-2 splash-ef-16',
        windowClass: 'splash splash-2 splash-ef-16',
        backdrop: 'static',
        keyboard:false,
        scope: $scope,
        controller: function($scope, $uibModalInstance, arrToModal ){
          var vm = this;
          vm.fData = {};
          vm.fData = arrToModal.scope.fDataUsuario;
          vm.realizarPago = arrToModal.scope.realizarPago;
          console.log('vm.fData',vm.fData);
          vm.modalTitle = 'Datos Adicionales';
          vm.aceptar = function () {
            pageLoading.start('Procesando...');
            ClienteServices.sEditarDatosAdicionalesCliente(vm.fData).then(function (rpta) {
              pageLoading.stop();
              if(rpta.flag == 1){
                $uibModalInstance.dismiss('cancel');
                var title = 'OK';
                var type = 'success';
                toastr.success(rpta.message, title);
              }else if( rpta.flag == 0 ){
                var title = 'Advertencia';
                var type = 'warning';
                toastr.warning(rpta.message, title);
              }else{
                alert('Ocurrió un error');              }
            });
            $uibModalInstance.close(vm.fData);
            vm.realizarPago();
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
    }*/
    vm.btnPagar = function(){
      if(!vm.selectedTerminos){
        alert("Debe aceptar los Términos y Condiciones");
        return false;
      }
      vm.pedido = false;
      vm.total_pedido = 0;
      vm.total_venta = 0;
      angular.forEach(vm.gridOptions.data, function(item) {
        if (item.es_pedido) {
          vm.pedido = true ;
          vm.total_pedido += item.total_detalle;
        }else{
          vm.total_venta += item.total_detalle;
        }
      });
      // if(vm.pedido && (vm.fDataUsuario.hotel == null || vm.fDataUsuario.habitacion == null )){
      //   vm.completarDatos();
      // }else{
        // vm.realizarPago();
      // }
      vm.modoSeleccionar = false;
      vm.modoPagar = false;
      var datos = {
        monedero: vm.saldo_final,
        idcliente: $scope.fSessionCI.idcliente,
        saldo: $scope.fSessionCI.monedero,
        detalle: vm.gridOptions.data,
        total_pedido: vm.total_pedido,
        total_venta: vm.total_venta,
        idactividadcliente : vm.listaExcursiones[0].idactividadcliente,
        porConfirmar : (vm.monto_a_pagar > 0) ? true : false
      };
      TiendaServices.sRegistrarVenta(datos).then(function(rpta){
        if(rpta.flag == 1){
          vm.idmovimiento = rpta.idmovimiento;
          if(vm.monto_a_pagar > 0){
            vm.token = rpta.token;
            vm.pasarela = true;
            return;
          }
          vm.irCompraExitosa();
          $scope.getValidateSession();
          $scope.actualizarSaldo(false);
          $scope.actualizarMonto(0);
        }else if(rpta.flag == 0){
          alert(rpta.message);
          $scope.getValidateSession();
          location.reload();
        }else{
          alert('Error inesperado');
        }
      });

    }
    /*vm.realizarPago = function(){
      vm.modoSeleccionar = false;
      vm.modoPagar = false;
      if(vm.monto_a_pagar > 0){
       vm.pasarela = true;
       return;
      }
      pagarOk();

    }
    vm.pagarOk = function(){
      var datos = {
        monedero: vm.saldo_final,
        idcliente: $scope.fSessionCI.idcliente,
        saldo: $scope.fSessionCI.monedero,
        detalle: vm.gridOptions.data,
        total_pedido: vm.total_pedido,
        total_venta: vm.total_venta,
        idactividadcliente : vm.listaExcursiones[0].idactividadcliente
      };
      TiendaServices.sRegistrarVenta(datos).then(function(rpta){
        if(rpta.flag == 1){
          vm.irCompraExitosa();
          $scope.getValidateSession();
          $scope.actualizarSaldo(false);
          $scope.actualizarMonto(0);
        }else if(rpta.flag == 0){
          alert(rpta.message);
          $scope.getValidateSession();
          location.reload();
        }else{
          alert('Error inesperado');
        }
      });
    }*/
    vm.irCompraExitosa = function(idmovimiento){
      var id = idmovimiento || null;
      if(id){
        vm.images = null;
      }else{
        $scope.actualizarSaldo(false);
      }
      var datos = {
        imagenes : vm.images,
        idmovimiento : id
      }
      pageLoading.start('Procesando descarga...');
      TiendaServices.sDescargarArchivosPagados(datos).then(function(rpta){
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
    vm.btnTerminosCondiciones = function(){
      var modalInstance = $uibModal.open({
        templateUrl: 'app/pages/tienda/terminos.php',
        controllerAs: 'mt',
        size: 'lg',
        backdropClass: 'splash-2 splash-ef-12',
        windowClass: 'splash-2 splash-ef-12',
        // backdrop: 'static',
        // keyboard:false,
        scope: $scope,
        controller: function($scope, $uibModalInstance, arrToModal ){
          var vm = this;
          var paramDatos = {
            idseccion : 6 // terminos y condiciones
          }
          TiendaServices.sListarSeccion(paramDatos).then(function(rpta){
            vm.modalTitle = rpta.datos.titulo;
            vm.contenido = rpta.datos.contenido;
            console.log('rpta',rpta);


          });
          vm.cancel = function () {
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
  }

  function TiendaServices($http, $q) {
    return({
        sListarNoDescargados: sListarNoDescargados,
        sDescargarArchivosPagados: sDescargarArchivosPagados,
        sVerificarSeleccion: sVerificarSeleccion,
        sRegistrarVenta: sRegistrarVenta,
        sRegistrarMovimiento: sRegistrarMovimiento,
        sListarSeccion: sListarSeccion,
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

    function sRegistrarVenta(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Movimiento/registrar_venta",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sRegistrarMovimiento(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Movimiento/registrar_pedido",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sListarSeccion(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Seccion/listar_seccion",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
  }
})();
