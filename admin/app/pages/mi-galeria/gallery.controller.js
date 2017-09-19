(function() {
  'use strict';

  angular
    .module('minotaur')
    .controller('PagesGalleryController', PagesGalleryController)
    .service('PagesGalleryServices', PagesGalleryServices);

  /** @ngInject */
  function PagesGalleryController($scope, PagesGalleryServices) {
    var vm = this;

    console.log('$scope.fSessionCI',$scope.fSessionCI);
    vm.cargarGaleria = function(datos){
      PagesGalleryServices.sListarGaleriaDescargados(datos).then(function(rpta){
        console.log(rpta);
      });
    }

    vm.cargarGaleria($scope.fSessionCI);

    vm.images = [
      {
        src: '../uploads/clientes/123456/descargadas/cat1.jpg',
        title: 'Sed ut perspiciatis unde',
        category: 'cats',
        selected: false
      },{
        src: '../uploads/clientes/123456/descargadas/cat2.jpg',
        title: 'Quis autem vel eum iure',
        category: 'cats',
        selected: false
      },{
        src: '../uploads/clientes/123456/descargadas/cat3.jpg',
        title: 'Temporibus autem quibusdam',
        category: 'cats',
        selected: false
      },{
        src: '../uploads/clientes/123456/descargadas/cat4.jpg',
        title: 'Neque porro quisquam est',
        category: 'cats',
        selected: false
      },{
        src: '../uploads/clientes/123456/descargadas/cat5.jpg',
        title: 'Et harum quidem rerum',
        category: 'cats',
        selected: false
      },{
        src: '../uploads/clientes/123456/descargadas/animal1.jpg',
        title: 'Nemo enim ipsam voluptatem',
        category: 'animals',
        selected: false
      },{
        src: '../uploads/clientes/123456/descargadas/animal2.jpg',
        title: 'At vero eos et accusamus',
        category: 'animals',
        selected: false
      },{
        src: '../uploads/clientes/123456/descargadas/animal3.jpg',
        title: 'Itaque earum rerum hic tenetur',
        category: 'animals',
        selected: false
      },{
        src: '../uploads/clientes/123456/descargadas/animal4.jpg',
        title: 'Ut enim ad minima veniam',
        category: 'animals',
        selected: false
      },{
        src: '../uploads/clientes/123456/descargadas/animal5.jpg',
        title: 'Temporibus autem quibusdam',
        category: 'animals',
        selected: false
      },{
        src: '../uploads/clientes/123456/descargadas/city1.jpg',
        title: 'Neque porro quisquam est',
        category: 'cities',
        selected: false
      },{
        src: '../uploads/clientes/123456/descargadas/city6.jpg',
        title: 'Nam libero tempore',
        category: 'cities',
        selected: false
      },{
        src: '../uploads/clientes/123456/descargadas/city2.jpg',
        title: 'Neque porro quisquam est',
        category: 'cities',
        selected: false
      },{
        src: '../uploads/clientes/123456/descargadas/city3.jpg',
        title: 'Nam libero tempore',
        category: 'cities',
        selected: false
      },{
        src: '../uploads/clientes/123456/descargadas/city4.jpg',
        title: 'Neque porro quisquam est',
        category: 'cities',
        selected: false
      },{
        src: '../uploads/clientes/123456/descargadas/city5.jpg',
        title: 'Nam libero tempore',
        category: 'cities',
        selected: false
      },{
        src: 'https://www.youtube.com/embed/uyxjlRI_FUA',
        title: 'Nam libero tempore',
        category: 'cities',
        selected: false
      }
    ];

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
