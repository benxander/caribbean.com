(function() {
  'use strict';

	angular
	    .module('caribbean')
	    .controller('BlogController', BlogController)
	    .service('BlogServices', BlogServices);
	function BlogController($scope,BlogServices) {
	    var vm = this;
	    $scope.pageInicio = false;
	    console.log('scope.pageInicio',$scope.pageInicio);
	    vm.listaNoticias = [];
	    vm.headerStyle = {
	    	'background-image' : 'url(uploads/banners/puntacana.jpg)'
	    }

	    BlogServices.sCargarNoticiasWeb().then(function (rpta) {
	      if(rpta.flag == 1){
	        vm.listaNoticias = rpta.datos;
	        console.log(vm.listaNoticias);

	      }else{
	        console.log('no data');
	      }
	    });
	}

	function BlogServices($http, $q) {
	    return({
	    	sCargarNoticiasWeb: sCargarNoticiasWeb,
	    	sCargarNoticiasSeccion: sCargarNoticiasSeccion,
	    });
	    function sCargarNoticiasWeb(pDatos) {
	      var datos = pDatos || {};
	      var request = $http({
	            method : "post",
	            url :  angular.patchURLCI + "Blog/cargar_noticias_web",
	            data : datos
	      });
	      return (request.then( handleSuccess,handleError ));
	    }
	    function sCargarNoticiasSeccion(pDatos) {
	      var datos = pDatos || {};
	      var request = $http({
	            method : "post",
	            url :  angular.patchURLCI + "Blog/cargar_noticias_seccion",
	            data : datos
	      });
	      return (request.then( handleSuccess,handleError ));
	    }
	}

})();