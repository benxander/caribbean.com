<div class="modal-header">
  <h4 class="modal-title">{{mz.modalTitle}}</h4>
</div>
<div class="modal-body">
	<section class="tile-body">
		<form name="formZip" role="form" novalidate class="form-validation">

		    <div class="row">
		    	<div class="form-group col-sm-12">
		    		<p>Los archivos zip deberán subirse previamente por ftp.</p>
		    	</div>
		    </div>
		    <div class="row">
		    	<div class="form-group col-sm-12">
		            <label class="control-label minotaur-label">Imagenes Zip</label>
	            	<input class="form-control" type="text" ng-model="mz.rutaArchivo" placeholder="Ingrese el nombre del archivo zip de imagenes">
		    	</div>
		    	<div class="form-group col-sm-12">
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