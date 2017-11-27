<div class="modal-header">
  <h4 class="modal-title">{{mb.modalTitle}}</h4>
</div>
<div class="modal-body">
	<section class="tile-body p-0">
		<form name="formBlog" role="form" novalidate class="form-validation">
		    <div class="row">
		    	<div class="form-group col-md-12">
		    		<label for="titulo" class="control-label minotaur-label">Título <small class="text-red">(*)</small> </label>
	              	<input type="text" name="titulo" id="titulo" class="form-control" ng-model="mb.fData.titulo" placeholder="Registre titulo" required>
	              	<div ng-messages="formBlog.titulo.$error" ng-if="formBlog.titulo.$dirty" role="alert" class="help-block text-red">
	                	<div ng-messages-include="app/components/templates/messages_tmpl.html"></div>
	              	</div>
	            </div>
	        </div>
			<div class="row">
				<div class="form-group col-md-7">
                	<label class="control-label minotaur-label">Imagen</label>
	            	<div ng-show="mb.fData.canvas">
				        <img src="../images/blog/image-10.jpg" ng-if="!image" style="width:100%">
						<img ng-if="image" ng-src="{{image}}" alt="" style="width: 100%">
				        <input upload-me type="file" name="upload" accept=".gif, .jpg, .png, .jpeg">
				        <a href="" class="block text-red" style="width: 60px" ng-click="mb.fData.canvas=false;">Cancelar</a>
	            	</div>
	            	<div ng-show="!mb.fData.canvas">
				        <img ng-src="{{mb.rutaImagen}}{{mb.fData.imagen}}" alt="" style="width: 100%">
				        <a href="" ng-click="mb.fData.canvas=true">Cambiar Imagen</a>
	            	</div>
                </div>
                <div class="form-group col-md-5">
                	<div class="row">
	                	<div class="form-group col-md-12">
			              	<label for="autor" class="control-label minotaur-label">Autor <small class="text-red">(*)</small> </label>
			              	<input type="text" name="autor" id="autor" class="form-control" ng-model="mb.fData.autor" placeholder="Registre autor" required>
			              	<div ng-messages="formBlog.autor.$error" ng-if="formBlog.autor.$dirty" role="alert" class="help-block text-red">
			                	<div ng-messages-include="app/components/templates/messages_tmpl.html"></div>
			              	</div>
			            </div>
			            <div class="form-group col-md-12">
			              	<label for="fecha" class="control-label minotaur-label">Fecha <small class="text-red">(*)</small> </label>
			                <div class="input-group w-md">
			                  <input type="text" class="form-control" uib-datepicker-popup="{{mb.format}}" ng-model="mb.fData.fecha" ng-model-options="{ timezone: 'UTC' }" is-open="mb.popup1.opened" datepicker-options="mb.dateOptions" ng-required="true" close-text="Close" ng-click="mb.open1($event)" />
			                  <span class="input-group-btn">
			                      <button type="button" class="btn btn-default" ng-click="mb.open1($event)"><i class="glyphicon glyphicon-calendar"></i></button>
			                    </span>
			                </div>
			                <!-- <span>{{mb.fData.fecha | date:'fullDate':'UTC'}}</span> -->
			            </div>
			            <div class="form-group col-md-12">
			              	<label for="enlace_video" class="control-label minotaur-label">Enlace Youtube </label>
			              	<input type="text" name="enlace_video" id="enlace_video" class="form-control" ng-model="mb.fData.enlace_video" placeholder="Enlace youtube" >

			            </div>
                	</div>
                </div>
			</div>

		    <div class="row">
	    		<div class="form-group col-md-12">
		            <label class="control-label minotaur-label">Contenido</label>
		            <text-angular ng-model="mb.fData.descripcion"
		            ta-toolbar="[
			            ['h1','h2','h3'],
			            ['bold','italics','underline'],
			            ['justifyLeft','justifyCenter','justifyRight'],
			            ['ul','ol'], ['redo', 'undo'],['wordcount', 'charcount']
		            ]"></text-angular>
	            </div>
	    	</div>



		</form>
	</section>
</div>
<div class="modal-footer">
  <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" ng-click="mb.cancel()"><i class="fa fa-arrow-left"></i> Cancelar</button>
  <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" ng-disabled="formBlog.$invalid" ng-click="mb.aceptar()"><i class="fa fa-arrow-right"></i> Guardar</button>
</div>