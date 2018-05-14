<div class="modal-header">
  <h4 class="modal-title">{{mc.modalTitle}}</h4>
</div>
<div class="modal-body">
	<section class="tile-body">
		<form name="formCliente" role="form" novalidate class="form-validation">
		    <div class="row">
	            <div class="form-group col-md-6 col-sm-12" >
					<label for="codigo" class="control-label minotaur-label">Código del Cliente <small class="text-red">(*)</small> </label>
	              	<input type="text" name="codigo" id="codigo" class="form-control" ng-model="mc.fData.codigo" placeholder="Registre Código del Cliente" required>
	            </div>
	            <div class="form-group col-md-6 col-sm-12">
					<label class="control-label minotaur-label">Excursión <small class="text-red">(*)</small> </label>
	              	<select class="form-control" ng-model="mc.fData.excursion" ng-options="item as item.descripcion for item in mc.listaExcursiones" required ng-disabled="mc.modoEdicion"> </select>
	            </div>
	            <div class="form-group col-md-6 col-sm-12" >
					<label for="fecha_excursion" class="control-label minotaur-label">Fecha de Excursión <small class="text-red">(*)</small> </label>
	                <input type="text" class="form-control" id="fecha_excursion" ng-model="mc.fData.fecha_excursion" input-mask mask-options="{alias: 'dd-mm-yyyy'}" required>
	            </div>
	            <div class="form-group col-md-6 col-sm-12" >
					<label for="monedero" class="control-label minotaur-label">Depósito </label>
	                <div touch-spin id="monedero" ng-model="mc.fData.monedero" options="{prefix: '$',verticalButtons: true, max: 100000, step:10}" ></div>
	            </div>
	            <div class="form-group col-sm-12" ng-if="mc.fData.email">
					<label for="email" class="control-label minotaur-label">Email </label>
	              	<input type="email" name="email" id="email" class="form-control" ng-model="mc.fData.email" ng-disabled="mc.modoEdicion">
	            </div>
		    </div>
		    <div class="row">
		    	<div class="form-group col-sm-12" >
					<label for="codigo" class="control-label minotaur-label">Códigos adicionales </label>
					<button class="btn btn-success btn-xs" uib-tooltip="Agregar código" ng-click="mc.btnAgregarCod();" ng-if="mc.fData.editar"><i class="fa fa-plus"></i></button>
			        <table class="table table-hover">
			            <thead>
				            <tr>
				              <th>#</th>
				              <th>Código</th>
				            </tr>
			            </thead>
			            <tbody>
				            <tr ng-repeat="item in mc.listaCodigos" ng-form="rowForm">
				              <td>{{item.i}}</td>
				              <td>
				              	<span ng-show="!item.esEdicion">{{item.codigo}}</span>
				              	<div class="controls" ng-show="item.esEdicion">
				                  <input type="text" name="codigo" ng-model="item.codigo" class="editable-input form-control input-sm" required/>
				                </div>
				              </td>
				              <td align="right" ng-show="mc.fData.editar">
				              	<button class="btn btn-nostyle text-uppercase text-strong text-sm" ng-click="mc.editarCodigo(item); item.esEdicion = false" ng-if="item.esEdicion" ng-disabled="rowForm.$pristine || rowForm.$invalid">Save</button>
                				<button class="btn btn-nostyle text-uppercase text-strong text-sm" ng-click="mc.cargarCodigos()" ng-if="item.esEdicion">Cancel</button>

				              	<button class="btn btn-nostyle text-success text-uppercase text-strong text-sm" ng-click="item.esEdicion = true" ng-if="!item.esEdicion">Edit</button>
				              	<button class="btn btn-nostyle text-danger text-uppercase text-strong text-sm" ng-click="mc.eliminarCodigo(item)" ng-if="!item.esEdicion">Remove</button>
				              </td>
				            </tr>

			            </tbody>
			        </table>
	            </div>

		    </div>
		</form>
	</section>
</div>
<div class="modal-footer">
  <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" ng-click="mc.cancel()"><i class="fa fa-arrow-left"></i> Salir</button>
  <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" ng-disabled="formCliente.$invalid" ng-click="mc.aceptar()" ng-if="mc.fData.editar"><i class="fa fa-arrow-right"></i> Guardar y Salir</button>
</div>