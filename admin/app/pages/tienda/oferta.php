<div class="modal-header">
  <h4 class="modal-title">{{mo.modalTitle}}</h4>
</div>
<div class="modal-body">
	<section class="tile-body p-0" >
		<form name="formOf" role="form" novalidate class="form-validation">
			<div class="row">
				<div class="col-sm-12">
					<div ng-bind-html="mo.contenido"></div>
				</div>
			</div>
		    <div class="row">
    			<div class="col-md-6" >
              		<label class="minotaur-label block">{{ 'Text.SELECCIONAR' | translate }}</label>
              		<div class="row">
              			<div class="col-md-6">
    						<a href="" class="icon icon-primary icon-ef-3 icon-ef-3a hover-color" ng-click="mo.selectFotografia();"><i class="fa fa-image"></i></a>
              			</div>
              			<div class="col-md-6" ng-if="mo.fData.isSel">
		                  <img class="img-responsive" ng-src="{{mo.fData.imagen.src}}" alt="" style="width: 100px;">
              			</div>
              		</div>

    			</div>
    			<div class="col-md-6">
		    		<label for="email" class="control-label minotaur-label">E-mail <small class="text-red">(*)</small> </label>
	              	<input type="email" name="email" id="email" class="form-control" ng-model="mo.fData.email" placeholder="Registre email" required>
	              	<div ng-messages="formOf.email.$error" ng-if="formOf.email.$dirty" role="alert" class="help-block text-red">
	                	<div ng-messages-include="app/components/templates/messages_tmpl.html"></div>
	              	</div>
    			</div>
		    </div>
		</form>

	</section>
</div>
<div class="modal-footer">
  <button class="btn btn-warning btn-ef btn-ef-4 btn-ef-4c" ng-click="mo.cancel()"><i class="fa fa-arrow-left"></i> Salir</button>
  <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" ng-disabled="formOf.$invalid" ng-click="mo.aceptar()"><i class="fa fa-arrow-right"></i> Enviar</button>
</div>