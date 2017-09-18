<div class="modal-header">
  <h4 class="modal-title">{{mc.modalTitle}}</h4>
</div>
<div class="modal-body">
	<section class="tile-body">
		<form name="formUsuario" role="form" novalidate class="form-validation">
		    <div class="row">
	            <div class="form-group col-md-6">
					<label for="grupo" class="control-label minotaur-label">Grupo</label>
	            	<select class="form-control" ng-model="mu.fData.grupo" ng-options="item.id as item.descripcion for item in mu.listaGrupos" > </select>
	            </div>
	            <div class="form-group col-md-6">
					<label for="idioma" class="control-label minotaur-label">Idioma</label>
	              	<select class="form-control" ng-model="mu.fData.idioma" ng-options="item.id as item.descripcion for item in mu.listaIdiomas" > </select>
	            </div>
	            <div class="form-group col-md-6">
					<label for="username" class="control-label minotaur-label">Nombre de Usuario <small class="text-red">(*)</small> </label>
	              	<input type="text" name="username" id="username" class="form-control" ng-model="mu.fData.username" placeholder="Registre Nombre de Usuario" required>
	            </div>
	            <div class="form-group col-md-6">
					<label for="password" class="control-label minotaur-label">Contraseña <small class="text-red">(*)</small> </label>
	              	<input type="password" name="password" id="password" class="form-control" ng-model="mu.fData.password" placeholder="Registre Contraseña" required>
	            	<input type="checkbox" name="newpassword" value="generar"> Generar nueva contraseña?
	            </div>
		    </div>
		</form>
	</section>
</div>
<div class="modal-footer">
  <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" ng-click="mu.cancel()"><i class="fa fa-arrow-left"></i> Cancel</button>
  <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" ng-disabled="formUsuario.$invalid" ng-click="mu.aceptar()"><i class="fa fa-arrow-right"></i> Grabar</button>
</div>