var caribbean = angular.module('caribbean', [
	'ngRoute',
	'ngCookies',
	'oc.lazyLoad'
	//'ngFacebook'
]);
/*caribbean.constant('FACEBOOK_APP_ID', '197123207485024');
// pass d0727fe35bdd54585fd8bf24f5ec7b4c
caribbean.config(['$routeProvider','$locationProvider','$facebookProvider','FACEBOOK_APP_ID',
	function($routeProvider,$locationProvider,$facebookProvider,facebookAppId) {
	$locationProvider.hashPrefix('');
	$locationProvider.html5Mode(true);

	$facebookProvider.setAppId(facebookAppId);
	$facebookProvider.setPermissions("email,user_friends");
	$routeProvider
	.when('/', {
		templateUrl: 'view/home/index',
		controller: 'HomeCtrl',
		resolve:{
			loadAsset: ['$ocLazyLoad', function($ocLazyLoad){
				return $ocLazyLoad.load(['assets/js/controllers/HomeCtrl.js'])
			}]
		}
	})
	.when('/about', {
		templateUrl: 'view/about/index',
		controller: 'AboutCtrl',
		resolve:{
			loadAsset: ['$ocLazyLoad', function($ocLazyLoad){
				return $ocLazyLoad.load(['assets/js/controllers/AboutCtrl.js'])
			}]
		}
	})
	.when('/contact', {
		templateUrl: 'view/contact/index',
		controller: 'ContactCtrl',
		resolve:{
			loadAsset: ['$ocLazyLoad', function($ocLazyLoad){
				return $ocLazyLoad.load(['assets/js/controllers/ContactCtrl.js'])
			}]
		}
	})
	.when('/signup', {
		templateUrl: 'view/registro/index',
		controller: 'SignupCtrl',
		resolve:{
			loadAsset: ['$ocLazyLoad', function($ocLazyLoad){
				return $ocLazyLoad.load(['assets/js/controllers/signupCtrl.js'])
			}]
		}
	})
}]);
caribbean.run([function() {
  (function(){
     if (document.getElementById('facebook-jssdk')) {return;}
     var firstScriptElement = document.getElementsByTagName('script')[0];
     var facebookJS = document.createElement('script');
     facebookJS.id = 'facebook-jssdk';
     facebookJS.src = '//connect.facebook.net/en_US/all.js';
     firstScriptElement.parentNode.insertBefore(facebookJS, firstScriptElement);
   }());
}]);*/