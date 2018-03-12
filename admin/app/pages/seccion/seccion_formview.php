<div class="modal-header">
  <h4 class="modal-title">{{ms.modalTitle}}</h4>
</div>
<div class="modal-body">
	<section class="tile-body p-0">
		<form name="formSeccion" role="form" novalidate class="form-validation">
		    <div class="row">
		    	<div class="form-group col-md-12">
					<div class="row">
			            <div class="form-group col-md-12">
			              <label for="titulo" class="control-label minotaur-label">Título <small class="text-red">(*)</small> </label>
			              <input type="text" name="titulo" id="titulo" class="form-control" ng-model="ms.fData.titulo" placeholder="Registre titulo" required>
			              <div ng-messages="formSeccion.titulo.$error" ng-if="formSeccion.titulo.$dirty" role="alert" class="help-block text-red">
			                <div ng-messages-include="app/components/templates/messages_tmpl.html"></div>
			              </div>
			            </div>

			        </div>
			        <!--  -->
					<div class="row">
			            <div class="form-group col-md-12" ng-if="{{ms.fData.tipo_contenido != 'BG'}}">
			              <label for="subtitulo" class="control-label minotaur-label">Subtítulo </label>
			              <input type="text" name="subtitulo" id="subtitulo" class="form-control" ng-model="ms.fData.subtitulo" placeholder="Registre subtitulo" >
			            </div>
			    	</div>
			    	<div class="row" ng-if="ms.fData.acepta_imagen">
			    		<div class="form-group col-md-9">
				            <label class="control-label minotaur-label">Contenido</label>
				            <text-angular ng-model="ms.fData.contenido"></text-angular>
			            </div>

			    		<div class="form-group col-md-3">
	                    	<label class="control-label minotaur-label">Imagen (260 x 400)<span class="text-red">*</span>: </label>
		                    <div ng-show="ms.fData.imagen && !ms.fData.cImagen" >
		                        <img class="mt-md" ng-src="../uploads/banners/LATERAL/{{ms.fData.imagen}}" alt="logo" style="width: 100%">
		                         <a href="" class="block" style="width: 110px" ng-click="ms.fData.cImagen=true">Cambiar Imagen</a>
		                    </div>
		                    <div ng-show="ms.fData.cImagen">
		                        <img src="../images/index/image-22.jpg" ng-if="!ms.fData.newImagen.url" style="width:100%">
		                        <img class="mt-md" ng-if="ms.fData.newImagen.url" ng-src="{{ms.fData.newImagen.dataURL}}" alt="logo" style="width:100%">
		                        <input type="file" image="ms.fData.newImagen" accept=".gif, .jpg, .png, .jpeg">
		                        <a href="" class="block text-red" style="width: 60px" ng-click="ms.fData.cImagen=false;">Cancelar</a>
		                    </div>
	                    </div>
			    	</div>
			    	<div class="row" ng-if="ms.fData.acepta_background">
			    		<div class="form-group col-md-12" ng-if="{{ms.fData.tipo_contenido != 'BG'}}">
				            <label class="control-label minotaur-label">Contenido</label>
				            <text-angular ng-model="ms.fData.contenido"></text-angular>
			            </div>
			            <div class="form-group col-md-12">
	                    	<label class="control-label minotaur-label">Imagen (1920 x 1080)<span class="text-red">*</span>: </label>
		                    <div ng-show="ms.fData.imagen_bg && !ms.fData.cImagen" >
		                        <img class="mt-md" ng-src="../uploads/banners/FONDO/{{ms.fData.imagen_bg}}" alt="logo" style="width: 100%">
		                         <a href="" class="block" style="width: 110px" ng-click="ms.fData.cImagen=true">Cambiar Imagen</a>
		                    </div>
		                    <div ng-show="ms.fData.cImagen">
		                        <img src="../images/backgrounds/bg-1.jpg" ng-if="!ms.fData.newImagenBg.url" style="width:100%">
		                        <img class="mt-md" ng-if="ms.fData.newImagenBg.url" ng-src="{{ms.fData.newImagenBg.dataURL}}" alt="logo" style="width:100%">
		                        <input type="file" image="ms.fData.newImagenBg" accept=".gif, .jpg, .png, .jpeg">
		                        <a href="" class="block text-red" style="width: 60px" ng-click="ms.fData.cImagen=false;">Cancelar</a>
		                    </div>
	                    </div>
			    	</div>
			    	<div class="row" ng-if="!ms.fData.acepta_background && !ms.fData.acepta_imagen ">
			    		<div class="form-group col-md-12">
				            <label class="control-label minotaur-label">Contenido</label>
				            <text-angular ng-model="ms.fData.contenido"></text-angular>
			            </div>
			        </div>
		    	</div>

		    </div>

		</form>
	</section>
</div>
<div class="modal-footer">
  <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" ng-click="ms.cancel()"><i class="fa fa-arrow-left"></i> Cancelar</button>
  <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" ng-disabled="formSeccion.$invalid" ng-click="ms.aceptar()"><i class="fa fa-arrow-right"></i> Guardar</button>
</div>