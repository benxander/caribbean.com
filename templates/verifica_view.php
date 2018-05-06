<div id="page-content" style="margin-top: 88px;">
	<div class="container">
		<div class="row mb-lg">
	      	<div class="col-sm-12 mt-lg">
		        <h1 class=""><small>Welcome to <b ng-bind="ve.empresaNombre"></b></small></h1>
		        <h5 class="btn-{{ve.class}} text-center p-md">{{ve.fData.mensaje}}</h5>
	      	</div>
	      	<div class="col-sm-12 mt-lg">
		      	<h5>Redirecting in {{ve.counter}} seconds...</h5>
				<button class="btn btn-info" ng-click="ve.redirige()">Go Admin</button>
			</div>
	    </div>
	</div>
</div>