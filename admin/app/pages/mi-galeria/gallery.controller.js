(function() {
  'use strict';

  angular
    .module('minotaur')
    .controller('PagesGalleryController', PagesGalleryController)
    .service('PagesGalleryServices', PagesGalleryServices);

  /** @ngInject */
  function PagesGalleryController($scope,$uibModal, $state,$stateParams, PagesGalleryServices, rootServices, MensajeServices, TiendaServices, ClienteServices, Socialshare, pageLoading,toastr) {
    var vm = this;
    vm.dirImagesProducto = $scope.dirImages + "producto/";
    $scope.actualizarSeleccion(0,0);
    $scope.actualizarSaldo(false);
    vm.pasarela = false;
    vm.boolVideo = false;
    vm.selectedAll = true;
    vm.images = [];
    vm.cargarGaleria = function(datos,loader){
      var loader = loader || false;
      if(loader){
        pageLoading.start('Loading...');
      }
      PagesGalleryServices.sListarGaleriaDescargados(datos).then(function(rpta){
        vm.images = rpta.datos;
        if(loader){
          pageLoading.stop();
        }
        angular.forEach(vm.images, function(image) {
          image.selected = vm.selectedAll;
        });
      });
    }
    vm.cargarMensajes = function(){
      MensajeServices.sListarMensajes().then(function(rpta){
        vm.mensajes = rpta.datos;
      });
    }
    rootServices.sGetSessionCI().then(function (response) {
      if(response.flag == 1){
        vm.cargarMensajes();
        vm.fDataUsuario = response.datos;
        vm.cargarGaleria(vm.fDataUsuario, true);
        // vm.cargarProductos();
      }
    });


    vm.isSelected = true;
    vm.fData = {}
    vm.fData.total_a_pagar = 0;
    vm.pedidoBool = false;
    vm.productoBool = false;
    vm.producto = {};
    vm.temporal = {};
    vm.temporal.cantidad = 1;
    vm.temporal.isSel = false;
    vm.modoDescargaCompleta = false;

    vm.selectAll = function () {
      if (vm.selectedAll) {
        console.log('sele1',vm.selectedAll);
        vm.selectedAll = false;
        vm.isSelected = false;
      } else {
        console.log('sele2',vm.selectedAll);
        vm.selectedAll = true;
        vm.isSelected = true;
      }

      angular.forEach(vm.images, function(image) {
        image.selected = vm.selectedAll;
      });
    };
    // vm.selectAll();
    vm.selectImage = function(index) {
      var i = 0;

      if (vm.images[index].selected) {
        vm.images[index].selected = false;
      } else {
        vm.images[index].selected = true;
        vm.isSelected = true;
      }

      angular.forEach(vm.images, function(image) {
        if (image.selected) {
          i++;
        }
      });
      if( i == vm.images.length ){
        vm.selectedAll = true;
      }else{
        vm.selectedAll = false;
      }

      if (i === 0) {
        vm.isSelected = false;
      }
    };
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
        toastr.warning('Seleccione primero un tamaño', 'Warning');
        return false;
      }
      var modalInstance = $uibModal.open({
        templateUrl: 'app/pages/mi-galeria/galeria_modal.php',
        controllerAs: 'gm',
        size: 'lg',
        backdropClass: 'splash splash-2 splash-info splash-ef-13',
        windowClass: 'splash splash-2 splash-info splash-ef-13',
        // backdrop: 'static',
        // keyboard:false,
        scope: $scope,
        controller: function($scope, $uibModalInstance, arrToModal ){
          var vm = this;
          vm.images = arrToModal.scope.images;
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
    // GRILLA PEDIDOS
      vm.gridOptions = {
        minRowsToShow: 3,
        appScopeProvider: vm
      }
      vm.gridOptions.columnDefs = [
        { field: 'producto', displayName: 'PRODUCTO' },
        { field: 'categoria', displayName: 'CATEGORIA',  width:100 },
        { field: 'color',  displayName: 'COLOR',  width:80 },
        { field: 'talla',  displayName: 'TALLA',  width:120 },
        { field: 'cantidad',  displayName: 'CANTIDAD',  width:80 },
        { field: 'precio',  displayName: 'PRECIO',  width:80 },
        { field: 'total_detalle',  displayName: 'TOTAL',  width:80 },
        { field: 'accion', displayName: '', width: 60,
          cellTemplate: '<div>' +
          '<button class="btn btn-default btn-sm text-red btn-action" ng-click="grid.appScope.btnQuitarDeLaCesta(row)" tooltip-placement="left" uib-tooltip="ELIMINAR"> <i class="fa fa-trash"></i> </button>' +
          '</div>'
        }
      ];
    vm.agregarItem = function(temp){
      if( !vm.temporal.idcolor && vm.temporal.si_color == 1){
        toastr.warning('Seleccione un color', 'Warning');
        return false;
      }
      if( vm.temporal.si_genero == 1 && !vm.temporal.genero ){
        toastr.warning('Seleccione un género', 'Warning');
        return false;
      }
      if( !angular.isObject(vm.temporal.size) ){
        toastr.warning('Seleccione un tamaño', 'Warning');
        return false;
      }
      if( vm.temporal.tipo_seleccion == 1 ){
        console.log('unica');
        if( !angular.isObject(vm.temporal.imagen) ){
          toastr.warning('Seleccione una fotografía', 'Warning');
          return false;
        }
      }else{
        console.log('multiple');
        vm.temporal.imagen = [];
        angular.forEach(vm.images, function(image,key) {
          if (image.selected) {
            vm.temporal.imagen.push(image);
          }
        });
        if(vm.temporal.imagen.length <= 0){
          toastr.warning('Seleccione fotografías', 'Warning');
          return false;
        }
      }
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
      var index = vm.gridOptions.data.indexOf(row.entity);
            vm.gridOptions.data.splice(index,1);
            vm.calcularTotales();
    }
    vm.calcularTotales = function(){
      var total = 0;
      angular.forEach(vm.gridOptions.data,function (value, key) {
        total += parseFloat(value.total_detalle);
      });
      vm.fData.total_pedido = total;
      // if($scope.fSessionCI.monedero > 0){
        vm.fData.saldo_inicial = $scope.fSessionCI.monedero;
        vm.restante = vm.fData.saldo_inicial - vm.fData.total_pedido;
        console.log('vm.restante',vm.restante);
        if(vm.restante <= 0){
          vm.fData.total_a_pagar = Math.abs(vm.restante);
          vm.fData.saldo_final = 0;
        }else{
          vm.fData.saldo_final = vm.restante;
          vm.fData.total_a_pagar = 0;
        }
      // }
    }
    vm.btnPagar = function(){
      if(vm.gridOptions.data.length <= 0){
        alert("Debe agregar un pedido a la cesta");
        return false;
      }
      if(!vm.selectedTerminos){
        alert("Debe aceptar los Términos y Condiciones");
        return false;
      }
      if(vm.fDataUsuario.hotel == null || vm.fDataUsuario.habitacion == null ){
        // console.log('completa datos');
        vm.completarDatos();
      }else{
        // console.log('pagar');
        vm.PagarPedido();
      }

    }
    vm.completarDatos = function(){
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
          vm.PagarPedido = arrToModal.scope.PagarPedido;
          console.log('vm.fData',vm.fData);
          vm.modalTitle = 'Datos Adicionales';
          vm.aceptar = function () {
            pageLoading.start('Loading...');
            ClienteServices.sEditarDatosAdicionalesCliente(vm.fData).then(function (rpta) {
              pageLoading.stop();
              if(rpta.flag == 1){
                $uibModalInstance.dismiss('cancel');
                var title = 'OK';
                var type = 'success';
                toastr.success(rpta.message, title);
              }else if( rpta.flag == 0 ){
                var title = 'Warning';
                var type = 'warning';
                toastr.warning(rpta.message, title);
              }else{
                alert('Ocurrió un error');              }
            });
            $uibModalInstance.close(vm.fData);
            vm.PagarPedido();
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
    vm.PagarPedido = function(){
      if(vm.fData.total_a_pagar > 0){
       /*aqui deberia incorporar proceso de pago y si es valido llevarlo al metodo que mueve las imagenes y muestra la encuesta*/
       vm.pasarela = true;
       return;
      }
      vm.pagarOk();
      /*vm.fData.detalle = vm.gridOptions.data;
      pageLoading.start('Loading...');
      TiendaServices.sRegistrarMovimiento(vm.fData).then(function(rpta){
        pageLoading.stop();
        if(rpta.flag == 1){
          // vm.limpiar();
          vm.temporal = {};
          vm.gridOptions.data = [];
          // vm.pedidoBool = false;
          vm.productoBool = false;
          vm.modoDescargaCompleta=true;
          $scope.getValidateSession();
          $scope.actualizarSaldo(false);
          var title = 'OK';
          var type = 'success';
          toastr.success(rpta.message, title);
          // $state.reload();
        }else if(rpta.flag == 0){
          var title = 'Warning';
          var type = 'warning';
          toastr.warning(rpta.message, title);
          $scope.getValidateSession();
          location.reload();
        }else{
          alert('Error de desarrollo');
        }
      });*/
    }
    vm.pagarOk = function(){
      vm.fData.detalle = vm.gridOptions.data;
      pageLoading.start('Loading...');
      TiendaServices.sRegistrarMovimiento(vm.fData).then(function(rpta){
        pageLoading.stop();
        if(rpta.flag == 1){
          // vm.limpiar();
          vm.temporal = {};
          vm.gridOptions.data = [];
          // vm.pedidoBool = false;
          vm.productoBool = false;
          vm.modoDescargaCompleta=true;
          $scope.getValidateSession();
          $scope.actualizarSaldo(false);
          var title = 'OK';
          var type = 'success';
          toastr.success(rpta.message, title);
          // $state.reload();
        }else if(rpta.flag == 0){
          var title = 'Warning';
          var type = 'warning';
          toastr.warning(rpta.message, title);
          $scope.getValidateSession();
          location.reload();
        }else{
          alert('Error de desarrollo');
        }
      });
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
    vm.btnDescargarFiles = function(){
      if(!vm.isSelected){
        return;
      }

      angular.forEach(vm.images, function(image,key) {
        if (image.selected) {

          var enlace = document.createElement('a');
          enlace.style.display = "none";
          enlace.href = image.src_share;
          enlace.download = image.nombre_archivo;
          document.body.appendChild(enlace);
          enlace.click();
          enlace.parentNode.removeChild(enlace);
        }
      });
    }
    vm.calificar = function(value){
      console.log('click');
      vm.calificacion = value;
      vm.fDataUsuario.puntos = value;
      ClienteServices.sRegistrarPuntuacion(vm.fDataUsuario).then(function(rpta){
        if(rpta.flag == 1){
          vm.modoCalificacionOk=true;
          var title = 'OK';
          var type = 'success';
          toastr.success(rpta.message, title);
        }else if(rpta.flag == 0){
          var title = 'Warning';
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

  function PagesGalleryServices($http, $q) {
    return({
        sListarGaleriaDescargados: sListarGaleriaDescargados,
    });

    function sListarGaleriaDescargados(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Archivo/listar_galeria_descargados",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
  }
})();
