<div class="modal-header">
  <h4 class="modal-title">{{mf.modalTitle}}</h4>
</div>
<div class="modal-body">
	<section class="tile-body p-0">
		<form name="formSeccionFicha" role="form" novalidate class="form-validation">
		    <div class="row">
	            <div class="form-group col-md-6">
	              <label for="titulo" class="control-label minotaur-label">Título <small class="text-red">(*)</small> </label>
	              <input type="text" name="titulo" id="titulo" class="form-control" ng-model="mf.fData.titulo_fi" placeholder="Registre titulo" required>
	              <div ng-messages="formSeccionFicha.titulo.$error" ng-if="formSeccionFicha.titulo.$dirty" role="alert" class="help-block text-red">
	                <div ng-messages-include="app/components/templates/messages_tmpl.html"></div>
	              </div>
	            </div>
	            <div class="form-group col-md-3">
	            	<label class="control-label minotaur-label">Tipo de Icono  </label>
	            	<select class="form-control" ng-model="mf.fData.tipoIcono" ng-options="item as item.descripcion for item in mf.listaTiposIconos" ng-change="mf.fData.icono = null" required > </select>
	            </div>

	            <!-- <div class="form-group col-md-3">
	            	<label class="control-label minotaur-label"> Icono  </label> -->

	            	<!-- <input type="text" ng-model="mf.fData.icono" placeholder="Tipea para buscar"
	            		uib-typeahead="item as item.descripcion for item in mf.listarIconos($viewValue,mf.fData.tipoIcono)"

	            		typeahead-loading="loadingLocations"
	            		typeahead-no-results="noResultsLI"
	            		query="query"
	            		class="form-control">
			        <i ng-show="loadingLocations" class="glyphicon glyphicon-refresh"></i>
			        <div ng-show="noResultsLI">
			          <i class="glyphicon glyphicon-remove"></i> No Results Found
			        </div> -->
	            <!-- </div> -->
	            <div class="form-group col-md-3">
		            <label class="control-label minotaur-label">Icono</label>
	                <select chosen="{width: '100%'}" ng-model="mf.fData.icono" ng-options="item as item.descripcion for item in mf.listaIconos">
	                </select>

		        </div>

	    		<div class="form-group col-md-12">
		            <label class="control-label minotaur-label">Contenido <small class="text-red">(*)</small> </label>
		            <textarea class="form-control" ng-model="mf.fData.descripcion_fi"></textarea>
	            </div>

		    </div>

		</form>
	</section>
</div>
<div class="modal-footer">
  <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" ng-click="mf.cancel()"><i class="fa fa-arrow-left"></i> Cancelar</button>
  <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" ng-disabled="formSeccionFicha.$invalid" ng-click="mf.aceptar()"><i class="fa fa-arrow-right"></i> Guardar</button>
</div>