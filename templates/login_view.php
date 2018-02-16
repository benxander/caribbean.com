<div id="page-content"  ng-controller="LoginController" style="margin-top: 88px;">
	<div class="container" id="login">
		<div class="row mb-lg">
	      	<div class="col-sm-12 mt-lg">
		        <h3 class="">Bienvenido a <b>{{l.empresaNombre}}</b></h3>
		        <h5>Ingrese el código.</h5>
		        <form class="row" name="formLogin" role="form" novalidate >
		          	<div class="col-sm-6" >
			            <div class="form-group">
			            	<div class="input-group">
			             	<input type="text" placeholder="Ingrese su código" name="code" class="form-control" ng-model="l.fLogin.codigo" required>
			             	<span class="input-group-btn m-n"><button class="btn btn-primary" style="padding-top: 5px;padding-bottom: 5px;" type="button" ng-click="l.btnLoginToSystem()" ng-disabled="formLogin.$invalid" >Ingresar</button></span>
			            	</div>
			            </div>
			        </div>
		        </form>
	      	</div>
	    </div>
	</div>
</div>