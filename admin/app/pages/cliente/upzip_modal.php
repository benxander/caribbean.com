<div class="modal-header">
  <h4 class="modal-title">{{mz.modalTitle}}</h4>
</div>
<div class="modal-body">
	<section class="tile-body">
		<form name="formZip" role="form" novalidate class="form-validation">

		    <div class="row">
		    	<div class="form-group col-sm-12">
		    		<p>El archivo zip deberá subirse previamente por ftp a la carpeta /uploads/temporal/</p>
		    	</div>
		    </div>
		    <div class="row">
		    	<div class="form-group col-sm-12">
						<label class="control-label minotaur-label">Archivo Zip</label>
						<div class="input-group">
							<input class="form-control" type="text" ng-model="mz.rutaArchivo" placeholder="Ingrese el nombre del archivo zip de imágenes y/o videos" style="text-align:left!important">
							<span class="input-group-addon">.zip</span>
						</div>
		    	</div>
		    	<div class="form-group col-sm-12" style="display:none">
						<label class="control-label minotaur-label">Videos Zip</label>
						<input class="form-control" type="text" ng-model="mz.rutaVideo" placeholder="Ingrese el nombre del archivo zip de videos">
		    	</div>
		    </div>
		</form>
	</section>
</div>
<div class="modal-footer">
  <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" ng-click="mz.cancel()"><i class="fa fa-arrow-left"></i> Cancel</button>
  <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" ng-disabled="formZip.$invalid" ng-click="mz.aceptar()"><i class="fa fa-arrow-right"></i> Grabar</button>
</div>