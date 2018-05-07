<div class="modal-header">
  <h4 class="modal-title">{{mv.modalTitle}}</h4>
</div>
<div class="modal-body">
	<section class="tile-body p-0">
		<form name="formVid" role="form" novalidate class="form-validation">
			<div class="row">
				<div class="form-group col-sm-6">
					<label for="cantidad" class="control-label minotaur-label">Subir Video: </label>
					<input type="file" ng-model="mv.video" accept=".mp4">
				</div>

			</div>

		</form>
	</section>
</div>
<div class="modal-footer">
  <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" ng-click="mv.cancel()"><i class="fa fa-arrow-left"></i> Cancelar</button>
  <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" ng-disabled="formVid.$invalid" ng-click="mv.aceptar()"><i class="fa fa-arrow-right"></i> Subir</button>
</div>