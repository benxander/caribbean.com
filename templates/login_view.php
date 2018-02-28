<div id="page-content"  ng-controller="LoginController" style="margin-top: 88px;">
	<div class="container" id="login">
		<div class="row mb-lg">
	      	<div class="col-sm-12 mt-lg">
		        <h3 class="">Welcome to <b>{{l.empresaNombre}}</b></h3>
		        <h5>Insert your code here</h5>
		        <form class="row" name="formLogin" role="form" novalidate >
		          	<div class="col-sm-6" >
			            <div class="form-group">
			            	<div class="input-group">
			             	<input type="text" placeholder="Insert your code" name="code" class="form-control" ng-model="l.fLogin.codigo" ng-enter="l.btnLoginToSystem()" required>
			             	<span class="input-group-btn m-n"><button class="btn btn-primary" style="padding-top: 5px;padding-bottom: 5px;" type="button" ng-click="l.btnLoginToSystem()" ng-disabled="formLogin.$invalid" >CLAIM YOUR PHOTOS</button></span>
			            	</div>
			            </div>
			        </div>
		        </form>
	      	</div>
	      	<div class="col-sm-12 mt-lg" ng-show="l.error">
		        <h5 class="text-red">*The code does not exist or is disabled.</h5>
		    </div>
	    </div>
	</div>
</div>