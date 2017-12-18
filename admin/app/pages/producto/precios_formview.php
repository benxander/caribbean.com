<div class="modal-header">
  <h4 class="modal-title">{{mp.modalTitle}}</h4>
</div>
<div class="modal-body">
	<section class="tile-body p-0">
		<form name="formPP" role="form" novalidate class="form-validation">
			<div class="row">
				<div class="form-group col-sm-6">
					<label for="cantidad" class="control-label minotaur-label">Producto: </label>
					<span>{{mp.fData.descripcion_pm}}</span>
				</div>

			</div>

			<fieldset ng-if="false">
				<legend class="f-16 text-left">Tallas</legend>
				<div class="row">
					<div class="form-group col-sm-4">
			    		<label for="titulo" class="control-label minotaur-label">Titulo</label>
		              	<input type="text" name="titulo" id="titulo" class="form-control" ng-model="mp.fData.temporal.titulo_pq" tabindex="1" ng-focus="true" >
		            </div>
					<div class="form-group col-sm-2">
			    		<label for="porc_cantidad" class="control-label minotaur-label">Porc. cant. % </label>
		              	<div touch-spin name="porc_cantidad" id="porc_cantidad" ng-model="mp.fData.temporal.porc_cantidad"  ng-disabled="!mp.fData.cantidad_fotos" ng-change="mp.calcularCantidad()" options="{postfix: '%',verticalButtons: true, max: 100, step:5}" tabindex="2"></div>
		            </div>
		            <div class="form-group col-sm-1 pl-0">
			    		<label for="cantidad" class="control-label minotaur-label">Cantidad</label>
		              	<input  type="text" name="cantidad" id="cantidad" class="form-control" ng-model="mp.fData.temporal.cantidad" ng-disabled="true">
		            </div>
		            <div class="form-group col-sm-2">
			    		<label for="porc_monto" class="control-label minotaur-label">Porc. Monto. % </label>
		              	<div  touch-spin name="porc_monto" id="porc_monto" ng-model="mp.fData.temporal.porc_monto" ng-disabled="!mp.fData.monto_total" ng-change="mp.calcularMonto()" options="{postfix: '%',verticalButtons: true, max: 100, step:5}" tabindex="3"></div>
		            </div>
		            <div class="form-group col-sm-1 pl-0">
			    		<label for="monto" class="control-label minotaur-label">Monto $ </label>
		              	<input type="text" name="monto" id="monto" class="form-control" ng-model="mp.fData.temporal.monto" ng-disabled="true">
		            </div>
		            <div class="form-group mb-sm mt-lg col-sm-2">
			            <div class="btn-group" style="min-width: 100%">
			                <a href="" class="btn btn-info" ng-click="mp.agregarItem(); $event.preventDefault();" style="min-width: 100%;"  tabindex="4">Agregar</a>
			            </div>
			        </div>
		            <div class="col-md-12 col-sm-12">
		              <div ui-grid="mp.gridOptions" ui-grid-auto-resize ui-grid-edit class="grid table-responsive" style="height: 150px"></div>
		            </div>
				</div>
			</fieldset>
		</form>
	</section>
</div>
<div class="modal-footer">
  <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" ng-click="mp.cancel()"><i class="fa fa-arrow-left"></i> Cancelar</button>
  <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" ng-disabled="formPP.$invalid" ng-click="mp.aceptar()"><i class="fa fa-arrow-right"></i> Guardar</button>
</div>