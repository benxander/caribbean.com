<div class="modal-header">
  <h4 class="modal-title">{{mb.modalTitle}}</h4>
</div>
<div class="modal-body">
	<section class="tile-body p-0">
		<form name="formExc" role="form" novalidate class="form-validation">
		    <div class="row">
		    	<div class="form-group col-sm-12 col-md-12 mb-n">
		    		<label for="descripcion" class="control-label minotaur-label">Título <small class="text-red">(*)</small> </label>
	              	<input type="text" name="descripcion" id="descripcion" class="form-control" ng-model="mb.fData.descripcion" placeholder="Registre titulo" required>
	              	<div ng-messages="formExc.descripcion.$error" ng-if="formExc.descripcion.$dirty" role="alert" class="help-block text-red">
	                	<div ng-messages-include="app/components/templates/messages_tmpl.html"></div>
	              	</div>
	            </div>

	            <div class="form-group col-sm-12 col-md-6">
		    		<label for="monto" class="control-label minotaur-label">All Inclusive ($) <small class="text-red">(*)</small> </label>
	              	<div touch-spin name="monto" id="monto" ng-model="mb.fData.precio_all" options="{prefix: '$',verticalButtons: true, max: 100000, step:10}" required ></div>
	            </div>
	            <div class="form-group col-sm-12 col-md-6">
		    		<label for="monto" class="control-label minotaur-label">Digital Fun Pass($) <small class="text-red">(*)</small> </label>
	              	<div touch-spin name="monto" id="monto" ng-model="mb.fData.precio_pack" options="{prefix: '$',verticalButtons: true, max: 100000, step:10}" required></div>
	            </div>
	            <div class="form-group col-sm-12 col-md-6">
		    		<label for="precio_primera" class="control-label minotaur-label">Single Photo 1ª ($) <small class="text-red">(*)</small> </label>
	              	<div touch-spin name="precio_primera" id="precio_primera" ng-model="mb.fData.precio_primera" options="{prefix: '$',verticalButtons: true, max: 100000, step:10}" required></div>
	            </div>
	            <div class="form-group col-sm-12 col-md-6">
		    		<label for="precio_adicional" class="control-label minotaur-label">Single Photo Adicional($) <small class="text-red">(*)</small> </label>
	              	<div touch-spin name="precio_adicional" id="precio_adicional" ng-model="mb.fData.precio_adicional" options="{prefix: '$',verticalButtons: true, max: 100000, step:5}" required></div>
	            </div>
	            <!-- <div class="form-group col-sm-12 col-md-6">
		    		<label for="precio_video" class="control-label minotaur-label">Precio Video($) </label>
	              	<div touch-spin name="precio_video" id="precio_video" ng-model="mb.fData.precio_video" options="{prefix: '$',verticalButtons: true, max: 100000, step:50}"></div>
	            </div> -->

	        </div>






		</form>
	</section>
</div>
<div class="modal-footer">
  <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" ng-click="mb.cancel()"><i class="fa fa-arrow-left"></i> Cancelar</button>
  <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" ng-disabled="formExc.$invalid" ng-click="mb.aceptar()"><i class="fa fa-arrow-right"></i> Guardar y Salir</button>
</div>