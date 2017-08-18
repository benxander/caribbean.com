<div class="modal-header">
  <h4 class="modal-title">{{mb.modalTitle}}</h4>
</div>
<div class="modal-body">
	<section class="tile-body">
		<form name="formBanner" role="form" novalidate class="form-validation">
		    <div class="row">
				<!-- <div class="form-group col-md-6">
	                <label for="seccion" class="control-label minotaur-label"> Sección <small class="text-red">(*)</small> </label>
	                <select class="form-control" id="seccion" ng-model="mb.fData.seccion" ng-options="item as item.descripcion for item in mb.listaSeccion" required >
	                </select>
	                <div ng-messages="formBanner.seccion.$error" ng-if="formBanner.seccion.$dirty" role="alert" class="help-block text-red">
	                 	<div ng-messages-include="app/components/templates/messages_tmpl.html"></div>
	                </div>
        		</div>
        		<div class="form-group col-md-6">
	                <label for="tipoBanner" class="control-label minotaur-label"> Tipo de Banner <small class="text-red">(*)</small> </label>
	                <select class="form-control" id="tipoBanner" ng-model="mb.fData.tipoBanner" ng-options="item as item.descripcion for item in mb.listaTipoBanner" required >
	                </select>
	                <div ng-messages="formBanner.tipoBanner.$error" ng-if="formBanner.tipoBanner.$dirty" role="alert" class="help-block text-red">
	                 	<div ng-messages-include="app/components/templates/messages_tmpl.html"></div>
	                </div>
        		</div> -->

	            <div class="form-group col-md-12">
	              	<label for="titulo" class="control-label minotaur-label">Título </label>
	              	<input type="text" name="titulo" id="titulo" class="form-control" ng-model="mb.fData.titulo" placeholder="Registre titulo del banner" >
	              	<div ng-messages="formBanner.titulo.$error" ng-if="formBanner.titulo.$dirty" role="alert" class="help-block text-red">
	                	<div ng-messages-include="app/components/templates/messages_tmpl.html"></div>
	              	</div>
	            </div>
	            <div class="form-group col-md-12" ng-show="mb.fData.canvas">
	            	<label class="control-label minotaur-label">Imagen</label>
			        <input upload-me type="file" name="upload" accept=".gif, .jpg, .png, .jpeg">
					<img ng-if="image" ng-src="{{image}}" alt="" style="width: 100%">
	            </div>
	            <div class="form-group col-md-12" ng-show="!mb.fData.canvas">
	            	<label class="control-label minotaur-label">Imagen</label>
			        <img ng-src="{{mb.rutaImagen}}{{mb.fData.imagen}}" alt="" style="width: 100%">
			        <a href="" ng-click="mb.fData.canvas=true">Cambiar Imagen</a>
	            </div>
		    </div>

		</form>
	</section>
</div>
<div class="modal-footer">
  <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" ng-click="mb.cancel()"><i class="fa fa-arrow-left"></i> Cancel</button>
  <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" ng-disabled="formBanner.$invalid" ng-click="mb.aceptar()"><i class="fa fa-arrow-right"></i> Grabar</button>
</div>