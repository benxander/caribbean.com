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
					<div class="col-md-4">
		              	<div class="mt">
				    		<label class="control-label minotaur-label">Tipo Medida<small class="text-red">(*)</small></label>
			              	<select class="form-control input-sm" ng-model="mp.temporal.tipo_medida" ng-options="item as item.descripcion for item in mp.listaTipoMedida" required ng-disabled="mp.gridOptions.data.length > 0" ng-change="mp.cargarMedidas();"> </select>
		              	</div>
		              	<div class="mt">
			              	<label class="control-label minotaur-label">Medida</label>
			              	<select class="form-control input-sm" ng-model="mp.temporal.medida" ng-options="item as item.descripcion for item in mp.listaMedida" ng-disabled="!mp.temporal.tipo_medida.id"> </select>
		              	</div>
		              	<div class="mt text-right">
		              		<button type="button" class="btn btn-primary btn-border btn-rounded-20 btn-ef btn-ef-4 btn-ef-4b mb-10" ng-click="mp.agregarItem();">AGREGAR<i class="fa fa-arrow-right"></i></button>
		              	</div>
		              	<div class="mt" ng-if="mp.fData.si_color == 1">
				    		<label for="color" class="control-label minotaur-label block">Color<small class="text-red">(*)</small></label>
			              	<select multiple chosen="{width: '100%'}" class="form-control" ng-model="mp.fData.colores" ng-options="item.id as item.descripcion for item in mp.listaColores" ng-change="mp.cambioColor();" required> </select>
		              	</div>
	    			</div>

		            <div class="col-sm-8">
		            	<uib-tabset class="mt-10 mb-10" justified="true">
		        			<uib-tab heading="Básico" ng-click="mp.temporal.categoria = 1">
		              			<div ui-grid="mp.gridOptions" ui-grid-auto-resize ui-grid-edit class="grid table-responsive" style="height: 200px"></div>

		        			</uib-tab>
		        			<uib-tab heading="Premium" ng-click="mp.temporal.categoria = 2">
		              			<div ui-grid="mp.gridOptionsPremium" ui-grid-auto-resize ui-grid-edit class="grid table-responsive" style="height: 200px"></div>

		        			</uib-tab>
		      			</uib-tabset>
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