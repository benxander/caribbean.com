<div class="modal-header">
  <h4 class="modal-title">{{mp.modalTitle}}</h4>
</div>
<div class="modal-body">
	<section class="tile-body p-0">
		<form name="formBlog" role="form" novalidate class="form-validation">
		    <div class="row">
		    	<div class="form-group col-md-8">
		    		<div class="row">
		    			<div class="col-md-12">
				    		<label for="descripcion_pm" class="control-label minotaur-label">Denominación <small class="text-red">(*)</small> </label>
			              	<input type="text" name="descripcion_pm" id="descripcion_pm" class="form-control" ng-model="mp.fData.descripcion_pm" placeholder="Registre descripcion_pm" required>
			              	<div ng-messages="formBlog.descripcion_pm.$error" ng-if="formBlog.descripcion_pm.$dirty" role="alert" class="help-block text-red">
			                	<div ng-messages-include="app/components/templates/messages_tmpl.html"></div>
			              	</div>
		    			</div>

		    		</div>
		    		<div class="row mt">
						<div class="col-md-3">
		                	<label class="control-label minotaur-label">Género</label>
			            	<label class="radio ml-lg mt-n" >
								<input type="radio" name="optionsRadios" id="optionsRadios1" value="1" ng-model="mp.fData.si_genero">
								Si.
							</label>
							<label class="radio ml-lg" >
								<input type="radio" name="optionsRadios" id="optionsRadios2" value="2" ng-model="mp.fData.si_genero" >
								No.
							</label>
						</div>
						<div class="col-md-3">
		                	<label class="control-label minotaur-label">Colores</label>
			            	<label class="radio ml-lg mt-n" >
								<input type="radio" name="optionsRadioColor" id="optionsRadioColor1" value="1" ng-model="mp.fData.si_color">
								Si.
							</label>

							<label class="radio ml-lg" >
								<input type="radio" name="optionsRadioColor" id="optionsRadioColor2" value="2" ng-model="mp.fData.si_color" >
								No.
							</label>
						</div>
						<div class="col-md-6">
		                	<label class="control-label minotaur-label">Selección de Fotografías</label>
			            	<label class="radio ml-lg mt-n" >
								<input type="radio" name="optionsRadioFot" id="optionsRadioFot1" value="1" ng-model="mp.fData.tipo_seleccion">
								Única.
							</label>

							<label class="radio ml-lg" >
								<input type="radio" name="optionsRadioFot" id="optionsRadioFot2" value="2" ng-model="mp.fData.tipo_seleccion" >
								Múltiple.
							</label>
						</div>
					</div>

	            </div>
	            <div class="form-group col-sm-4">
	            	<div class="row">
						<div class="col-md-12">
							<label class="control-label minotaur-label">Imagen<small class="text-red">(*)</small></label>
			            	<div ng-show="mp.fData.canvas">
						        <img src="../images/logos/logo-1.png" class="mb-md" ng-if="!image" style="height: 80px">
								<img ng-if="image" ng-src="{{image}}" class="mb-md" style="height: 80px">
						        <input upload-me type="file" name="upload" accept=".gif, .jpg, .png, .jpeg">
						        <a href="" class="block text-red" style="width: 60px" ng-click="mp.fData.canvas=false;" ng-if="mp.modoEdicion">Cancelar</a>
			            	</div>
			            	<div ng-show="!mp.fData.canvas">
						        <img ng-src="{{mp.rutaImagen}}{{mp.fData.imagen}}" alt="" style="height: 80px">
						        <a href="" ng-click="mp.fData.canvas=true">Cambiar Imagen</a>
			            	</div>
						</div>
					</div>
	            </div>
	        </div>
		    <div class="row">

				<uib-tabset class="mt-10 mb-10" justified="true">
        			<uib-tab heading="Básico">
						<div class="form-group col-md-8 mt">
				            <label class="control-label minotaur-label">Descripción Básico </label>
				            <text-angular ng-model="mp.fData.descripcion_basico"
				            ta-toolbar="[
					            ['h1','h2','h3'],
					            ['bold','italics','underline'],
					            ['justifyLeft','justifyCenter','justifyRight'],
				            ]"></text-angular>
			            </div>
						<div class="form-group col-md-4 mt">
		                	<label class="control-label minotaur-label">Imagen Básico<small class="text-red">(*)</small></label>
			            	<div ng-show="mp.fData.canvas_bas">
						        <img src="../images/logos/logo-1.png" class="mb-md" ng-show="!image2" style="height: 150px">
								<img ng-show="image2" ng-src="{{image2}}" class="mb-md" style="height: 150px">
						        <input upload-me2 type="file" name="upload2" accept=".gif, .jpg, .png, .jpeg" >
						        <a href="" class="block text-red" style="width: 60px" ng-click="mp.fData.canvas_bas=false;" ng-if="mp.modoEdicion">Cancelar</a>
			            	</div>
			            	<div ng-show="!mp.fData.canvas_bas">
						        <img ng-src="{{mp.rutaImagen}}{{mp.fData.imagen_bas}}" alt="" style="height: 150px">
						        <a href="" ng-click="mp.fData.canvas_bas=true">Cambiar Imagen</a>
			            	</div>
			            	<div ng-if="image2" style="display: none;">
				            	{{mp.file2 = file2.name; mp.image2 = image2}}
				            </div>

						</div>

        			</uib-tab>
        			<uib-tab heading="Premium">
						<div class="form-group col-md-8 mt">
				            <label class="control-label minotaur-label">Descripción Premium </label>
				            <text-angular ng-model="mp.fData.descripcion_premium"
				            ta-toolbar="[
					            ['h1','h2','h3'],
					            ['bold','italics','underline'],
					            ['justifyLeft','justifyCenter','justifyRight'],
				            ]"></text-angular>
			            </div>
			            <div class="form-group col-md-4 mt">
		                	<label class="control-label minotaur-label">Imagen Premium<small class="text-red">(*)</small></label>
			            	<div ng-show="mp.fData.canvas_pre">
						        <img src="../images/logos/logo-1.png" class="mb-md" ng-if="!image3" style="height: 150px">
								<img ng-if="image3" ng-src="{{image3}}" class="mb-md" style="height: 150px">
						        <input upload-me3 type="file" name="upload3" accept=".gif, .jpg, .png, .jpeg">
						        <a href="" class="block text-red" style="width: 60px" ng-click="mp.fData.canvas_pre=false;" ng-if="mp.modoEdicion">Cancelar</a>
			            	</div>
			            	<div ng-show="!mp.fData.canvas_pre">
						        <img ng-src="{{mp.rutaImagen}}{{mp.fData.imagen_pre}}" alt="" style="height: 150px">
						        <a href="" ng-click="mp.fData.canvas_pre=true">Cambiar Imagen</a>
			            	</div>
			            	<div ng-if="image3" style="display: none;">
				            	{{mp.file3 = file3.name; mp.image3 = image3}}
				            </div>
						</div>
        			</uib-tab>
      			</uib-tabset>

		    </div>
		</form>
	</section>
</div>
<div class="modal-footer">
  <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" ng-click="mp.cancel()"><i class="fa fa-arrow-left"></i> Cancelar</button>
  <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" ng-disabled="formBlog.$invalid" ng-click="mp.aceptar()"><i class="fa fa-arrow-right"></i> Guardar</button>
</div>