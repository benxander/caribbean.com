(function() {
  'use strict';

	angular
	    .module('caribbean')
	    .controller('PostController', PostController)
	    .service('PostServices', PostServices);
	function PostController($scope,$routeParams,$location,PostServices) {
	    var vm = this;
	    vm.fData = {}
	    vm.slides = null;
	    $("html, body").animate({
            scrollTop: 0
        }, 800, 'linear');
	    // console.log($routeParams,'$routeParams.modulo');
	    var searchObject = $location.search();
	    console.log('searchObject',searchObject);
	    PostServices.sCargarPostBlog(searchObject).then(function (rpta) {
	      if(rpta.flag == 1){
	        vm.fData = rpta.datos;

	      }else{
	        console.log('no data');
	      }
	    });
	    vm.myInterval = 5000;
	    vm.noWrapSlides = false;
	    vm.active = 0;
	    var slides = vm.slides = [];
	    var currIndex = 0;
	    var datos = {
	    	idblog : searchObject.id
	    }
	    PostServices.sCargarGaleriaBlog(datos).then(function (rpta) {
	      if(rpta.flag == 1){
	        vm.slides = rpta.datos;
	        vm.active = vm.slides[0].idblogimagen;

	      }else{
	        console.log('no data');
	      }
	    });




	}

	function PostServices($http, $q) {
		 return({
	    	sCargarPostBlog: sCargarPostBlog,
	    	sCargarGaleriaBlog: sCargarGaleriaBlog,
	    });
	    function sCargarPostBlog(pDatos) {
	      var datos = pDatos || {};
	      var request = $http({
	            method : "post",
	            url :  angular.patchURLCI + "Blog/cargar_post_blog",
	            data : datos
	      });
	      return (request.then( handleSuccess,handleError ));
	    }
	    function sCargarGaleriaBlog(pDatos) {
	      var datos = pDatos || {};
	      var request = $http({
	            method : "post",
	            url :  angular.patchURLCI + "Blog/cargar_imagenes_blog",
	            data : datos
	      });
	      return (request.then( handleSuccess,handleError ));
	    }
	}

})();