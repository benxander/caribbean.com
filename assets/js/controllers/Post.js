(function() {
  'use strict';

	angular
	    .module('caribbean')
	    .controller('PostController', PostController)
	    .service('PostServices', PostServices);
	function PostController($scope,$routeParams,$location,PostServices) {
	    var vm = this;
	    vm.fData = {}
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

	}

	function PostServices($http, $q) {
		 return({
	    	sCargarPostBlog: sCargarPostBlog,
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
	}

})();