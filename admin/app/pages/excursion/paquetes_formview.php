<div class="modal-header">
  <h4 class="modal-title">{{mb.modalTitle}}</h4>
</div>
<div class="modal-body">
	<section class="tile-body p-0">
		<form name="formPaq" role="form" novalidate class="form-validation">


			<fieldset>
				<legend align="right" class="f-16">Paquetes</legend>
				<div class="row">
					<div class="form-group col-sm-3">
			    		<label for="cantidad" class="control-label minotaur-label">Porc. cant. % </label>
		              	<input type="text" name="cantidad" id="cantidad" class="form-control input-sm" ng-model="mb.fData.temporal.porc_cantidad"  ng-disabled="!mb.fData.cantidad" ng-change="mb.calcularCantidad()">
		            </div>
		            <div class="form-group col-sm-3">
			    		<label for="cantidad" class="control-label minotaur-label">Cantidad</label>
		              	<input type="text" name="cantidad" id="cantidad" class="form-control input-sm" ng-model="mb.fData.temporal.cantidad" ng-disabled="true">
		            </div>
		            <div class="form-group col-sm-3">
			    		<label for="cantidad" class="control-label minotaur-label">Porc. Monto. % </label>
		              	<input type="text" name="cantidad" id="cantidad" class="form-control input-sm" ng-model="mb.fData.temporal.porc_monto" ng-disabled="!mb.fData.monto" ng-change="mb.calcularMonto()">
		            </div>
		            <div class="form-group col-sm-3">
			    		<label for="cantidad" class="control-label minotaur-label">Monto $</label>
		              	<input type="text" name="cantidad" id="cantidad" class="form-control input-sm" ng-model="mb.fData.temporal.monto"  ng-disabled="true">
		            </div>
		            <div class="form-group mb-sm col-sm-12">
			            <div class="btn-group" style="min-width: 100%">
			                <a href="" class="btn btn-info" ng-click="mb.agregarItem(); $event.preventDefault();" style="min-width: 100%;"  tabindex="115">Agregar</a>
			            </div>
			        </div>
		            <div class="col-md-12 col-sm-12">
		              <div ui-grid="mb.gridOptions" ui-grid-auto-resize class="grid table-responsive" style="height: 150px"></div>
		            </div>
				</div>
			</fieldset>
		</form>
	</section>
</div>
<div class="modal-footer">
  <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" ng-click="mb.cancel()"><i class="fa fa-arrow-left"></i> Cancelar</button>
  <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" ng-disabled="formPaq.$invalid" ng-click="mb.aceptar()"><i class="fa fa-arrow-right"></i> Guardar</button>
</div>