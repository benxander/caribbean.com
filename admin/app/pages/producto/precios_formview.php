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

			<fieldset ng-if="true">
				<legend class="f-16 text-left">Características y precios</legend>
				<div class="row">
					<div class="form-group col-sm-4" ng-if="mp.fData.si_color == 1">
			    		<label for="color" class="control-label minotaur-label block">Color</label>
		              	<select multiple chosen="{width: '100%'}" class="form-control" ng-model="mp.fData.colores" ng-options="item.id as item.descripcion for item in mp.listaColores" required> </select>
		            </div>
				</div>

				<div class="row">
		            <div class="col-md-6 col-sm-12">
		              <div ui-grid="mp.gridOptions" ui-grid-auto-resize ui-grid-edit class="grid table-responsive" style="height: 150px"></div>
		            </div>
		            <div class="col-md-6 col-sm-12">
		              <div ui-grid="mp.gridOptionsPremium" ui-grid-auto-resize ui-grid-edit class="grid table-responsive" style="height: 150px"></div>
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