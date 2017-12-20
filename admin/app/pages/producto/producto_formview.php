<div class="modal-header">
  <h4 class="modal-title">{{mp.modalTitle}}</h4>
</div>
<div class="modal-body">
	<section class="tile-body p-0">
		<form name="formBlog" role="form" novalidate class="form-validation">
		    <div class="row">
		    	<div class="form-group col-md-12">
		    		<label for="descripcion_pm" class="control-label minotaur-label">Denominación <small class="text-red">(*)</small> </label>
	              	<input type="text" name="descripcion_pm" id="descripcion_pm" class="form-control" ng-model="mp.fData.descripcion_pm" placeholder="Registre descripcion_pm" required>
	              	<div ng-messages="formBlog.descripcion_pm.$error" ng-if="formBlog.descripcion_pm.$dirty" role="alert" class="help-block text-red">
	                	<div ng-messages-include="app/components/templates/messages_tmpl.html"></div>
	              	</div>
	            </div>
	        </div>
			<div class="row">
				<div class="form-group col-md-6">
                	<label class="control-label minotaur-label">Imagen<small class="text-red">(*)</small></label>
	            	<div ng-show="mp.fData.canvas">
				        <img src="../images/logos/logo-1.png" class="mb-md" ng-if="!image">
						<img ng-if="image" ng-src="{{image}}" class="mb-md" style="width: 100%">
				        <input upload-me type="file" name="upload" accept=".gif, .jpg, .png, .jpeg">
				        <a href="" class="block text-red" style="width: 60px" ng-click="mp.fData.canvas=false;" ng-if="mp.modoEdicion">Cancelar</a>
	            	</div>
	            	<div ng-show="!mp.fData.canvas">
				        <img ng-src="{{mp.rutaImagen}}{{mp.fData.imagen}}" alt="" style="width: 100%">
				        <a href="" ng-click="mp.fData.canvas=true">Cambiar Imagen</a>
	            	</div>
                </div>
				<div class="form-group col-md-6">
					<div class="row">
						<div class="form-group col-sm-12">
				    		<label for="color" class="control-label minotaur-label">Tipo Medida<small class="text-red">(*)</small></label>
			              	<select class="form-control input-sm" ng-model="mp.fData.tipo_medida" ng-options="item as item.descripcion for item in mp.listaTipoMedida" required> </select>
			            </div>
					</div>
					<div>
	                	<label class="control-label minotaur-label">¿Por género? (Hombre/Mujer)</label>
		            	<label class="radio ml-lg mt-n" >
							<input type="radio" name="optionsRadios" id="optionsRadios1" value="1" ng-model="mp.fData.si_genero">
							Si.
						</label>

						<label class="radio ml-lg" >
							<input type="radio" name="optionsRadios" id="optionsRadios2" value="2" ng-model="mp.fData.si_genero" >
							No.
						</label>
					</div>
					<div>
	                	<label class="control-label minotaur-label">¿Acepta colores?</label>
		            	<label class="radio ml-lg mt-n" >
							<input type="radio" name="optionsRadioColor" id="optionsRadioColor1" value="1" ng-model="mp.fData.si_color">
							Si.
						</label>

						<label class="radio ml-lg" >
							<input type="radio" name="optionsRadioColor" id="optionsRadioColor2" value="2" ng-model="mp.fData.si_color" >
							No.
						</label>
					</div>
                </div>

			</div>





		</form>
	</section>
</div>
<div class="modal-footer">
  <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" ng-click="mp.cancel()"><i class="fa fa-arrow-left"></i> Cancelar</button>
  <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" ng-disabled="formBlog.$invalid" ng-click="mp.aceptar()"><i class="fa fa-arrow-right"></i> Guardar</button>
</div>