<div class="modal-header">
  <h4 class="modal-title">{{mp.modalTitle}}</h4>
</div>
<div class="modal-body">
	<section class="tile-body p-0">
		<form name="formBlog" role="form" novalidate class="form-validation">
		    <div class="row">
    			<div class="col-md-12">
		    		<label for="descripcion_pm" class="control-label minotaur-label">Denominación <small class="text-red">(*)</small> </label>
	              	<input type="text" name="descripcion_pm" id="descripcion_pm" class="form-control" ng-model="mp.fData.descripcion_pm" placeholder="Registre descripcion_pm" required>
	              	<div ng-messages="formBlog.descripcion_pm.$error" ng-if="formBlog.descripcion_pm.$dirty" role="alert" class="help-block text-red">
	                	<div ng-messages-include="app/components/templates/messages_tmpl.html"></div>
	              	</div>
    			</div>

	        </div>

		</form>
	</section>
</div>
<div class="modal-footer">
  <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" ng-click="mp.cancel()"><i class="fa fa-arrow-left"></i> Cancelar</button>
  <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" ng-disabled="formBlog.$invalid" ng-click="mp.aceptar()"><i class="fa fa-arrow-right"></i> Guardar</button>
</div>