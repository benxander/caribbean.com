<div class="modal-header">
  <h4 class="modal-title">{{mb.modalTitle}}</h4>
</div>
<div class="modal-body">
	<section class="tile-body p-0">
		<form name="formExc" role="form" novalidate class="form-validation">
		    <div class="row">
		    	<div class="form-group col-sm-12 col-md-12 mb-n">
		    		<label for="descripcion" class="control-label minotaur-label">Descripción <small class="text-red">(*)</small> </label>
	              	<input type="text" name="descripcion" id="descripcion" class="form-control" ng-model="mb.fData.descripcion" placeholder="Registre descripcion" required>
	              	<div ng-messages="formExc.descripcion.$error" ng-if="formExc.descripcion.$dirty" role="alert" class="help-block text-red">
	                	<div ng-messages-include="app/components/templates/messages_tmpl.html"></div>
	              	</div>
	            </div>
	            <div class="form-group  col-sm-12 col-md-6" ng-if="false">
	              	<label for="fecha" class="control-label minotaur-label">Fecha <small class="text-red">(*)</small> </label>
	                <div class="input-group">
	                  <input type="text" class="form-control" uib-datepicker-popup="{{mb.format}}" ng-model="mb.fData.fecha" ng-model-options="{ timezone: 'UTC' }" is-open="mb.popup1.opened" datepicker-options="mb.dateOptions" ng-required="true" close-text="Close" ng-click="mb.open1($event)" />
	                  <span class="input-group-btn">
	                      <button type="button" class="btn btn-default" ng-click="mb.open1($event)"><i class="glyphicon glyphicon-calendar"></i></button>
	                    </span>
	                </div>
	                <!-- <span>{{mb.fData.fecha | date:'fullDate':'UTC'}}</span> -->
	            </div>
	            <div class="form-group col-sm-12 col-md-4">
		    		<label for="cantidad" class="control-label minotaur-label">Cantidad de fotos <small class="text-red">(*)</small> </label>
	              	<div touch-spin name="cantidad" id="cantidad" ng-model="mb.fData.cantidad_fotos" placeholder="Cantidad" required options="{verticalButtons: true, max: 100000, step:10}"></div>
	              	<div ng-messages="formExc.cantidad.$error" ng-if="formExc.cantidad.$dirty" role="alert" class="help-block text-red">
	                	<div ng-messages-include="app/components/templates/messages_tmpl.html"></div>
	              	</div>
	            </div>
	            <div class="form-group col-sm-12 col-md-4">
		    		<label for="monto" class="control-label minotaur-label">Precio Total Fotos($) <small class="text-red">(*)</small> </label>
	              	<div touch-spin name="monto" id="monto" ng-model="mb.fData.monto_total" options="{prefix: '$',verticalButtons: true, max: 100000, step:50}" required></div>
	              	<div ng-messages="formExc.monto.$error" ng-if="formExc.monto.$dirty" role="alert" class="help-block text-red">
	                	<div ng-messages-include="app/components/templates/messages_tmpl.html"></div>
	              	</div>
	            </div>
	            <div class="form-group col-sm-12 col-md-4">
		    		<label for="precio_video" class="control-label minotaur-label">Precio Video($) </label>
	              	<div touch-spin name="precio_video" id="precio_video" ng-model="mb.fData.precio_video" options="{prefix: '$',verticalButtons: true, max: 100000, step:50}"></div>
	            </div>
	            <div class="form-group col-sm-12 col-md-12">
		    		<label for="video" class="control-label minotaur-label">Video </label>
	              	<input type="file" name="video" id="video" class="filestyle" ng-model="mb.fData.video" accept=".mp4">
	              	<video controls ng-show="formExc.file.$valid" ngf-src="picFile" ngf-accept="video/*" ></video>
                        <button ng-click="picFile = ''" ng-show="picFile">Remove</button>
                        <div class="progress" ng-show="picFile.progress >= 0">
                            <div style="width:{{picFile.progress}}%;" class="progress-bar">{{picFile.progress}}%</div>
                        </div>
                        <span ng-show="picFile.result">Upload Successful</span>
                        <span class="err" ng-show="errorMsg">{{errorMsg}}</span>
	            </div>

	        </div>






		</form>
	</section>
</div>
<div class="modal-footer">
  <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" ng-click="mb.cancel()"><i class="fa fa-arrow-left"></i> Cancelar</button>
  <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" ng-disabled="formExc.$invalid" ng-click="mb.aceptar()"><i class="fa fa-arrow-right"></i> Guardar</button>
</div>