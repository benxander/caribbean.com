<div class="modal-header">
  <h4 class="modal-title">{{me.modalTitle}}</h4>
</div>
<div class="modal-body">
	<section class="tile-body">
		<form name="formEmail" role="form" novalidate class="form-validation">
		    <div class="row">
		    	<div class="form-group col-md-12">
					<label for="titulo" class="control-label minotaur-label">Título </label>
	              	<input type="text" name="titulo" id="titulo" class="form-control" ng-model="me.fData.titulo" placeholder="Registre titulo" required>
	            </div>
		    </div>
		    <div class="row">
		    	<div class="form-group col-md-12">
		            <label class="control-label minotaur-label">Contenido</label>
		            <text-angular ng-model="me.fData.contenido"></text-angular>
	            </div>
		    </div>
		</form>
	</section>
</div>
<div class="modal-footer">
  <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" ng-click="me.cancel()"><i class="fa fa-arrow-left"></i> Cancel</button>
  <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" ng-disabled="formEmail.$invalid" ng-click="me.aceptar()"><i class="fa fa-arrow-right"></i> Grabar</button>
</div>