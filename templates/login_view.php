<div id="page-content"  ng-controller="LoginController" style="margin-top: 88px;">
	<div class="container" id="login">
		<div class="row mb-lg">
	      	<div class="col-sm-12 mt-lg">
		        <h3 class="">Welcome to <b ng-bind="l.empresaNombre"></b></h3>
		        <h5>Insert your code below</h5>
		        <form class="row" name="formLogin" role="form" novalidate >
		          	<div class="col-sm-6" >
			            <div class="form-group mb-n">
			            	<div class="input-group">
			             	<input type="text" placeholder="Insert your code" name="code" class="form-control" ng-model="l.fLogin.codigo" ng-enter="l.btnLoginToSystem()" required>
			             	<span style="position: absolute; right: 210px; z-index: 5;"><i class="fa fa-question-circle fa-2x" style="cursor: pointer; padding-top: 3px;" ng-click="l.btnInfo();"></i></span>
			             	<span class="input-group-btn m-n"><button class="btn btn-primary" style="padding-top: 5px;padding-bottom: 5px;" type="button" ng-click="l.btnLoginToSystem()" ng-disabled="formLogin.$invalid" >CLAIM YOUR PHOTOS</button></span>
			            	</div>
			            </div>
			        </div>
		          	<div class="col-sm-12" >
		        		<p>Please note, It may take up to 1 day after your escursion for your photos and video to become available.</p>
		          	</div>
		        </form>
	      	</div>
	      	<div class="col-sm-12 mt-lg" ng-show="l.error">
		        <h5 class="text-red">*The code does not exist or is disabled.</h5>
		    </div>
		    <div id="info" style="display:none;width:100%;" ng-include="'templates/popups/modal_info.php'"></div>
	    </div>
	</div>
</div>