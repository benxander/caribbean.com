<div class="btn-group" role="group" aria-label="..." ng-click="facebookRegistration()">
  <button type="button" class="btn" style="background-color: #4864b3; color: #ffffff;"> <i class="fa fa-facebook"></i> | Login With Facebook </button>
</div>
<form name="registroForm" ng-submit="registrationSubmit(registro)" role="form">
	<legend>Sign UP for FREE</legend>

	<div class="form-group">
		<label for="">Name *</label>
		<input type="text" class="form-control" name="user_name" ng-model="registro.user_name" placeholder="Name" required>
		<span class="label label-danger" ng-if="registroForm.user_name.$invalid && registroForm.user_name.$dirty" >Required</span>
	</div>

	<div class="form-group">
		<label for="">Email *</label>
		<input type="email" class="form-control" name="user_email" ng-model="registro.user_email" placeholder="Email" required>
		<span class="label label-danger" ng-if="registroForm.user_email.$invalid && registroForm.user_email.$dirty" >Required</span>
	</div>

	<div class="form-group">
		<label for="">Phone *</label>
		<input type="text" class="form-control" name="user_phone" ng-model="registro.user_phone" placeholder="Phone" required>
		<span class="label label-danger" ng-if="registroForm.user_phone.$invalid && registroForm.user_phone.$dirty" >Required</span>
	</div>

	<div class="form-group">
		<label for="">Password *</label>
		<input type="password" class="form-control" name="user_password" ng-model="registro.user_password" placeholder="Password" minlength="8" required>
		<span class="label label-danger" ng-if="registroForm.user_password.$invalid && registroForm.user_password.$dirty" >Required</span>
	</div>

	<button type="submit" class="btn btn-primary" ng-disabled="registroForm.$invalid || registroForm.$pristine">Submit</button>
</form>