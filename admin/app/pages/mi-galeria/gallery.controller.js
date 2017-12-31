(function() {
  'use strict';

  angular
    .module('minotaur')
    .controller('PagesGalleryController', PagesGalleryController)
    .service('PagesGalleryServices', PagesGalleryServices);

  /** @ngInject */
  function PagesGalleryController($scope,$uibModal, PagesGalleryServices, rootServices, Socialshare, pageLoading) {
    var vm = this;
    $scope.actualizarSeleccion(0,0);
    $scope.actualizarSaldo(false);

    vm.cargarGaleria = function(datos){
      PagesGalleryServices.sListarGaleriaDescargados(datos).then(function(rpta){
        //console.log(rpta);
        vm.images = rpta.datos;
      });
    }

    rootServices.sGetSessionCI().then(function (response) {
      if(response.flag == 1){
        vm.fDataUsuario = response.datos;
        vm.cargarGaleria(vm.fDataUsuario);
      }
    });

    vm.selectedAll = false;
    vm.isSelected = false;

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
            vm.modalTitle = 'Merchandising';

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
