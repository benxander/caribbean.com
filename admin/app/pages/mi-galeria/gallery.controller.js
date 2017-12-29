(function() {
  'use strict';

  angular
    .module('minotaur')
    .controller('PagesGalleryController', PagesGalleryController)
    .service('PagesGalleryServices', PagesGalleryServices);

  /** @ngInject */
  function PagesGalleryController($scope,$uibModal, PagesGalleryServices, rootServices, ProductoServices, Socialshare, pageLoading) {
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
    vm.pedidoBool = false;
    vm.productoBool = false;
    vm.producto = {};

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
    vm.selectPedido = function(){
      if(vm.pedidoBool){
        vm.pedidoBool = false;
        vm.productoBool = false;

      }else{
        vm.pedidoBool = true;
        // vm.cargarProductos();
      }
    }
    vm.selectSize = function(categoria){
      vm.productoBool = true;
      vm.categoriaSel = categoria;
      console.log('categoriaSel',vm.categoriaSel);
    }
    vm.cambiaProducto = function(idproductomaster){
      vm.producto[idproductomaster] = {};
      vm.productoBool = false;

    }
    vm.cambiaColor = function(color,idproductomaster){
      console.log('color',color);
      vm.producto[idproductomaster].activo = true;
    }
    vm.cambiaMedida = function(size,idproductomaster){
      var cantidad = vm.producto[idproductomaster].cantidad || 1;
      vm.producto[idproductomaster].size = size;
      if( cantidad== 1 ){
        vm.producto[idproductomaster].precio = size.precio;
      }else
      if( cantidad > 1 && cantidad < 6 ){
        vm.producto[idproductomaster].precio = size.precio_2_5;
      }else
      if( cantidad >= 6 ){
        vm.producto[idproductomaster].precio = size.precio_mas_5;
      }else{
        vm.producto[idproductomaster].precio = 0;
      }
      // vm.calcularTotales(idproductomaster);
      vm.producto[idproductomaster].total_detalle = vm.producto[idproductomaster].precio * cantidad;
      vm.producto[idproductomaster].activo = true;
    }
    vm.cambiaCantidad = function(idproductomaster){
      var cantidad = vm.producto[idproductomaster].cantidad || 1;
      var size = vm.producto[idproductomaster].size || null;
      console.log('size',size);
      // var precio = 0;
      if(size){
        if( cantidad== 1 ){
          vm.producto[idproductomaster].precio = size.precio;
        }else
        if( cantidad > 1 && cantidad < 6 ){
          vm.producto[idproductomaster].precio = size.precio_2_5;
          console.log('size.precio_2_5',size.precio_2_5);
        }else
        if( cantidad >= 6 ){
          vm.producto[idproductomaster].precio = size.precio_mas_5;
        }else{
          vm.producto[idproductomaster].precio = 0;
        }
        vm.producto[idproductomaster].total_detalle = vm.producto[idproductomaster].precio * cantidad;
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
          vm.modalTitle = 'Selecciona Fotografía';

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
    vm.btnPedidos = function(imagen){
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
          vm.categoria = 1;
          vm.fData = {};
          vm.producto = {};
          vm.modoEdicion = false;
          vm.getPaginationServerSide = arrToModal.getPaginationServerSide;
          vm.modalTitle = 'Merchandising';
          vm.dirImagesProducto = $scope.dirImages + "producto/";
          vm.fData.imagen = imagen;
          // PRODUCTOS
            pageLoading.start('Procesando...');
            ProductoServices.sListarProductoPedido().then(function (rpta) {
              vm.listaProductos = angular.copy(rpta.datos);
              // vm.listaProductos.splice(0,0,{ id : '', descripcion:'Seleccione un producto'});
              // vm.listaExcursionesFiltro = angular.copy(rpta.datos);
              // vm.fData.producto = vm.listaProductos[0];
              pageLoading.stop();

            });
          vm.cambiaColor = function(color,idproductomaster){
            console.log('color',color);
            vm.producto[idproductomaster].activo = true;
          }
          vm.cambiaProducto = function(size,idproductomaster){
            var cantidad = vm.producto[idproductomaster].cantidad || 1;
            vm.producto[idproductomaster].size = size;
            if( cantidad== 1 ){
              vm.producto[idproductomaster].precio = size.precio;
            }else
            if( cantidad > 1 && cantidad < 6 ){
              vm.producto[idproductomaster].precio = size.precio_2_5;
            }else
            if( cantidad >= 6 ){
              vm.producto[idproductomaster].precio = size.precio_mas_5;
            }else{
              vm.producto[idproductomaster].precio = 0;
            }
            // vm.calcularTotales(idproductomaster);
            vm.producto[idproductomaster].total_detalle = vm.producto[idproductomaster].precio * cantidad;
            vm.producto[idproductomaster].activo = true;

          }
          vm.cambiaCantidad = function(idproductomaster){
            var cantidad = vm.producto[idproductomaster].cantidad || 1;
            var size = vm.producto[idproductomaster].size || null;
            console.log('size',size);
            // var precio = 0;
            if(size){
              if( cantidad== 1 ){
                vm.producto[idproductomaster].precio = size.precio;
              }else
              if( cantidad > 1 && cantidad < 6 ){
                vm.producto[idproductomaster].precio = size.precio_2_5;
                console.log('size.precio_2_5',size.precio_2_5);
              }else
              if( cantidad >= 6 ){
                vm.producto[idproductomaster].precio = size.precio_mas_5;
              }else{
                vm.producto[idproductomaster].precio = 0;
              }
              vm.producto[idproductomaster].total_detalle = vm.producto[idproductomaster].precio * cantidad;
            }
          }
          vm.desactivar = function(idproductomaster){
            vm.producto[idproductomaster] = {};
          }
          // botones
            vm.aceptar = function () {
              console.log('vm.producto',vm.producto);
              console.log('vm.fData',vm.fData);
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
