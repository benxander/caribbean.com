<div class="modal-header">
  <h4 class="modal-title">{{cdm.modalTitle}}</h4>
</div>
<div class="modal-body">
	<section class="tile-body">
		<form name="formCliente" role="form" novalidate class="form-validation">
		    <div class="row">
	   	        <div class="form-group col-md-12">
		    		<span>Por favor complete los siguientes campos. Importantes para la entrega de su pedido.</span>
		    	</div>
	   	        <div class="form-group col-md-6">
					<label for="hotel" class="control-label minotaur-label">Hotel  <small class="text-red">(*)</small> </label>
	              	<input type="text" name="hotel" id="hotel" class="form-control" ng-model="cdm.fData.hotel" placeholder="Registre Hotel" required >
	            </div>
	            <div class="form-group col-md-6">
					<label for="habitacion" class="control-label minotaur-label">Habitación  <small class="text-red">(*)</small> </label>
	              	<input type="text" name="habitacion" id="habitacion" class="form-control" ng-model="cdm.fData.habitacion" placeholder="Registre Habitación" required >
	            </div>

		    </div>
		</form>
	</section>
</div>
<div class="modal-footer">
  <!-- <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" ng-click="cdm.cancel()"><i class="fa fa-arrow-left"></i> Cancel</button> -->
  <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" ng-disabled="formCliente.$invalid" ng-click="cdm.aceptar()"><i class="fa fa-arrow-right"></i> Grabar</button>
</div>