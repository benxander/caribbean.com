(function() {
  'use strict';

  angular
    .module('minotaur')
    .controller('PagesGalleryController', PagesGalleryController)
    .service('PagesGalleryServices', PagesGalleryServices);

  /** @ngInject */
  function PagesGalleryController($scope,$uibModal, PagesGalleryServices, rootServices, ProductoServices, Socialshare, pageLoading,toastr) {
    var vm = this;
    vm.dirImagesProducto = $scope.dirImages + "producto/";
    vm.cargarGaleria = function(datos){
      PagesGalleryServices.sListarGaleriaDescargados(datos).then(function(rpta){
        //console.log(rpta);
        vm.images = rpta.datos;
      });
    }
    vm.cargarProductos = function(){
      pageLoading.start('Procesando...');
      ProductoServices.sListarProductoPedido().then(function (rpta) {
        vm.listaProductos = angular.copy(rpta.datos);
        console.log('data',vm.listaProductos);
        pageLoading.stop();
      });
    }
    rootServices.sGetSessionCI().then(function (response) {
      if(response.flag == 1){
        vm.fDataUsuario = response.datos;
        vm.cargarGaleria(vm.fDataUsuario);
        vm.cargarProductos();

      }
    });

    vm.selectedAll = false;
    vm.isSelected = false;
    vm.fData = {}
    vm.fData.total_a_pagar = 0;
    vm.pedidoBool = false;
    vm.productoBool = false;
    vm.producto = {};
    vm.temporal = {};
    vm.temporal.cantidad = 1;
    vm.temporal.isSel = false;

    vm.selectAll = function () {
      if (vm.selectedAll) {
        vm.selectedAll = false;
        vm.isSelected = false;
      } else {
        vm.selectedAll = true;
        vm.isSelected = true;
      }

      angular.forEach(vm.images, function(image) {
        image.selected = vm.selectedAll;
      });
    };

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

      if (i === 0) {
        vm.isSelected = false;
      }
    };
    vm.btnPedidos = function(imagen){ // merchandising
      var imagen = imagen || null;
      if(vm.pedidoBool){
        vm.pedidoBool = false;
        vm.productoBool = false;

      }else{
        vm.pedidoBool = true;
        // vm.cargarProductos();
      }
    }
    vm.selectCat = function(categoria, producto){ //basico - premium
      vm.productoBool = true;
      vm.categoriaSel = categoria;
      vm.temporal.categoria = categoria;
      vm.temporal.idproductomaster = producto.idproductomaster;
      vm.temporal.producto = producto.descripcion_pm;
      vm.temporal.si_genero = producto.si_genero;
    }
    vm.cambiaProducto = function(producto){ // pestaña productos
      // vm.producto[idproductomaster] = {};
      vm.productoBool = false;
      vm.temporal = {};
      vm.temporal.cantidad = 1;
      vm.temporal.isSel = false;
      vm.temporal.idproductomaster = producto.idproductomaster;
      vm.temporal.producto = producto.descripcion_pm;
    }
    vm.cambiaColor = function(color,idproductomaster){
      vm.temporal.color = color.nombre;
    }
    vm.cambiaMedida = function(size){
      // var cantidad = vm.producto[idproductomaster].cantidad || 1;
      var cantidad = vm.temporal.cantidad;

      // vm.producto[idproductomaster].size = size;
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
      // vm.calcularTotales(idproductomaster);
      vm.temporal.total_detalle = vm.temporal.precio * cantidad;
      vm.temporal.talla = size.denominacion;
      // vm.temporal.idproducto = size.idproducto;
      // vm.temporal.cantidad = cantidad;
      // vm.temporal.precio = vm.producto[idproductomaster].precio;
      // vm.temporal.total_detalle = vm.producto[idproductomaster].total_detalle;

    }
    vm.cambiaCantidad = function(){
      // var cantidad = vm.producto[idproductomaster].cantidad || 1;
      var cantidad = vm.temporal.cantidad;
      var size = vm.temporal.size || null;
      console.log('size',size);
      // var precio = 0;
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
        // vm.temporal.cantidad = cantidad;
        // vm.temporal.precio = vm.producto[idproductomaster].precio;
        // vm.temporal.total_detalle = vm.producto[idproductomaster].total_detalle;
      }
    }
    vm.selectFotografia = function(){
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
          // vm.seleccion = arrToModal.scope.seleccion;
          // console.log('vm.seleccion',vm.seleccion);
          vm.modalTitle = 'Selecciona Fotografía';
          vm.selectFoto = function(imagen){
            arrToModal.scope.temporal.imagen = imagen;
            arrToModal.scope.temporal.isSel = true;
            // arrToModal.scope.temporal.imagen = imagen.src_thumb;
            $uibModalInstance.dismiss('cancel');
            // $uibModalInstance.close(vm.seleccion);
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
        // paginationPageSizes: [10, 50, 100, 500, 1000],
        // paginationPageSize: 10,
        // enableFiltering: true,
        // enableSorting: true,
        // useExternalPagination: true,
        // useExternalSorting: true,
        // useExternalFiltering : true,
        // enableRowSelection: true,
        // enableRowHeaderSelection: true,
        // enableFullRowSelection: false,
        // multiSelect: false,
        minRowsToShow: 3,
        appScopeProvider: vm
      }
      vm.gridOptions.columnDefs = [
        { field: 'producto', displayName: 'PRODUCTO' },
        { field: 'categoria', displayName: 'CATEGORIA',  width:100 },
        { field: 'color',  displayName: 'COLOR',  width:80 },
        { field: 'talla',  displayName: 'TALLA',  width:80 },
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
      if( !vm.temporal.color ){
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
      if( !angular.isObject(vm.temporal.imagen) ){
        toastr.warning('Seleccione una fotografía', 'Advertencia');
        return false;
      }
      // console.log('vm.temporal',vm.temporal);
      vm.arrTemporal = {}
      var adicional = '';
      if(vm.temporal.si_genero == 1){
        adicional = vm.temporal.genero == 'H'? ' - Hombre' : ' - Mujer';
      }
      vm.arrTemporal = {
        'idproducto' : vm.temporal.idproducto,
        'producto' : vm.temporal.producto + adicional,
        'categoria' : vm.temporal.categoria.descripcion_ca,
        'idcolor' : vm.temporal.idcolor,
        'color' : vm.temporal.color,
        'talla' : vm.temporal.talla,
        'cantidad' : vm.temporal.cantidad,
        'precio' : vm.temporal.precio,
        'total_detalle' : vm.temporal.total_detalle,
      }
      vm.gridOptions.data.push(vm.arrTemporal);
      // console.log('data',vm.gridOptions.data);
      // console.log('temp',temp);
      var producto = vm.temporal.producto;
      var categoria = vm.temporal.categoria;
      var si_genero = vm.temporal.si_genero;
      vm.temporal = {};
      vm.temporal.cantidad = 1;
      vm.temporal.isSel = false;
      // vm.temporal.idproductomaster = producto.idproductomaster;
      vm.temporal.producto = producto;
      vm.temporal.categoria = categoria;
      vm.temporal.si_genero = si_genero;
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
        total += parseFloat(vm.gridOptions.data[key].total_detalle);
      });
      vm.fData.total_a_pagar = total;
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
