angular.module('caribbean')
.controller('SignupCtrl', ['$scope','$http','$facebook','FACEBOOK_APP_ID','$cookies',
	'signupServices',
	function ($scope,$http,$facebook,facebookAppId,$cookies,
		signupServices) {
	$scope.resetear = function(){
		$scope.registro = {
			user_name: '',
			user_email: '',
			user_phone: '',
			user_password: '',
		};
	}
	$scope.resetear();
	$scope.facebookRegistration = function(){
		$facebook.login().then(function(response){
			console.log('response',response);
			$cookies.put('fbsr_'+facebookAppId, response.authResponse.signedRequest);
			var datos = {
				signedRequest: response.authResponse.signedRequest,
				accessToken: response.authResponse.accessToken,
				userID: response.authResponse.userID
			}
			signupServices.sRegistroFacebook(datos).then(function(rpta){
				console.log('rpta',rpta);
				if(rpta.flag == 1){

				}else{
					alert('Aviso: Validacion');
				}
			});
		});
	}
	$scope.registrationSubmit = function(datos){
		console.log('scope.registro',datos);
		signupServices.sRegistrarUsuario(datos).then(function(rpta){
			console.log('rpta',rpta);
			if(rpta.flag == 1){
				$scope.resetear();
			}else{
				alert('Aviso: Validacion');
			}
		});
	}
}])
.service('signupServices', function($http,$q){
	return ({
		sRegistrarUsuario : sRegistrarUsuario,
		sRegistroFacebook : sRegistroFacebook,
	});
	function sRegistrarUsuario(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url : "api/registro/crear_usuario",
            data : datos
      });
      return (request.then(
      	function (rpta) {return rpta.data;},
      	function (rpta) {alert('Falló el registro');return rpta.data;})
      );
    }
    function sRegistroFacebook(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url : "api/registro/facebook",
            data : datos
      });
      return (request.then(
      	function (rpta) {return rpta.data;},
      	function (rpta) {alert('Falló el registro');return rpta.data;})
      );
    }
});