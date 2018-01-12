<div class="modal-header">
  <h4 class="modal-title">{{mp.modalTitle}}</h4>
</div>
<div class="modal-body">
	<section class="tile-body p-0">
		<form name="formMed" role="form" novalidate class="form-validation">
		    <div class="row">
    			<div class="col-md-6">
		    		<label class="control-label minotaur-label">Tipo Medida<small class="text-red">(*)</small></label>
			         <select class="form-control input-sm" ng-model="mp.fData.tipo_medida" ng-options="item as item.descripcion for item in mp.listaTipoMedida" required > </select>
    			</div>
    			<div class="col-md-6">
		    		<label for="denominacion" class="control-label minotaur-label">Denominación <small class="text-red">(*)</small> </label>
	              	<input type="text" name="denominacion" id="denominacion" class="form-control" ng-model="mp.fData.denominacion" placeholder="Registre denominación" required>
	              	<div ng-messages="formMed.denominacion.$error" ng-if="formMed.denominacion.$dirty" role="alert" class="help-block text-red">
	                	<div ng-messages-include="app/components/templates/messages_tmpl.html"></div>
	              	</div>
    			</div>

	        </div>

		</form>
	</section>
</div>
<div class="modal-footer">
  <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" ng-click="mp.cancel()"><i class="fa fa-arrow-left"></i> Cancelar</button>
  <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" ng-disabled="formMed.$invalid" ng-click="mp.aceptar()"><i class="fa fa-arrow-right"></i> Guardar</button>
</div>