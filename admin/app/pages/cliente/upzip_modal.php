<div class="modal-header">
  <h4 class="modal-title">{{mz.modalTitle}}</h4>
</div>
<div class="modal-body">
	<section class="tile-body">
		<form name="formZip" role="form" novalidate class="form-validation">

		    <div class="row">
		    	<div class="form-group col-sm-12">
		    		<p>Subir un archivo zip que tenga todas las fotos sueltas de los clientes.</p>
		    	</div>
		    </div>
		    <div class="row">
		    	<div class="form-group col-sm-12">
		            <label class="control-label minotaur-label">Copiar ruta de archivo</label>
	            	<!-- <input type="file" class="filestyle" nv-file-select="" uploader="uploader" filestyle button-text="Zip" icon-name="fa fa-inbox" accept=".zip" required="true"> -->
	            	<input type="text" ng-model="mz.rutaArchivo" required="true">
		    	</div>
		    </div>
		</form>
	</section>
</div>
<div class="modal-footer">
  <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" ng-click="mz.cancel()"><i class="fa fa-arrow-left"></i> Cancel</button>
  <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" ng-disabled="formZip.$invalid" ng-click="mz.aceptar()"><i class="fa fa-arrow-right"></i> Grabar</button>
</div>