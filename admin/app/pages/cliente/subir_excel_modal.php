<div class="modal-header">
  <h4 class="modal-title">{{mc.modalTitle}}</h4>
</div>
<div class="modal-body">
	<section class="tile-body">
		<form name="formExcel" role="form" novalidate class="form-validation">

		    <div class="row">
		    	<div class="form-group col-sm-12">
		    		<p>Subir un archivo excel que tenga un encabezado con la figura.</p>
		    		<p>El código y la excursión son obligatorios. (excursion es el ID de una excursion del menu EXCURSIONES)</p>
		    		<img src="assets/images/excel.JPG" alt="">
		    	</div>
		    </div>
		    <div class="row">
		    	<div class="form-group col-sm-12">
		            <label class="control-label minotaur-label">Subir excel</label>
	            	<input type="file" class="filestyle" nv-file-select="" uploader="uploader" filestyle button-text="Excel" icon-name="fa fa-inbox" accept=".xls, .xlsx" required="true">
		    	</div>
		    </div>
		</form>
	</section>
</div>
<div class="modal-footer">
  <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" ng-click="mc.cancel()"><i class="fa fa-arrow-left"></i> Cancel</button>
  <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" ng-disabled="formExcel.$invalid" ng-click="mc.aceptar()"><i class="fa fa-arrow-right"></i> Grabar</button>
</div>