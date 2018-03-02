<div class="modal-header">
  <h4 class="modal-title">{{mc.modalTitle}}</h4>
</div>
<div class="modal-body">
	<section class="tile-body">
		<form name="formCliente" role="form" novalidate class="form-validation">
		    <div class="row">
	            <div class="form-group col-md-6" >
					<label for="codigo" class="control-label minotaur-label">Código del Cliente <small class="text-red">(*)</small> </label>
	              	<input type="text" name="codigo" id="codigo" class="form-control" ng-model="mc.fData.codigo" placeholder="Registre Código del Cliente" required>
	            </div>
	            <div class="form-group col-md-6">
					<label class="control-label minotaur-label">Excursión <small class="text-red">(*)</small> </label>
	              	<select class="form-control" ng-model="mc.fData.excursion" ng-options="item as item.descripcion for item in mc.listaExcursiones" required ng-disabled="mc.modoEdicion"> </select>
	            </div>
	            <div class="form-group col-md-6" >
					<label for="fecha_excursion" class="control-label minotaur-label">Fecha de Excursión <small class="text-red">(*)</small> </label>
	                <input type="text" class="form-control" id="fecha_excursion" ng-model="mc.fData.fecha_excursion" input-mask mask-options="{alias: 'dd-mm-yyyy'}" required>
	            </div>
	            <div class="form-group col-md-6" >
					<label for="monedero" class="control-label minotaur-label">Depósito </label>
	                <div touch-spin id="monedero" ng-model="mc.fData.monedero" options="{prefix: '$',verticalButtons: true, max: 100000, step:10}" ></div>
	            </div>
		    </div>
		</form>
	</section>
</div>
<div class="modal-footer">
  <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" ng-click="mc.cancel()"><i class="fa fa-arrow-left"></i> Cancel</button>
  <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" ng-disabled="formCliente.$invalid" ng-click="mc.aceptar()"><i class="fa fa-arrow-right"></i> Guardar y Salir</button>
</div>