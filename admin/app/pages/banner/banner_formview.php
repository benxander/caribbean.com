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


	            <div class="form-group col-md-6">
					<label for="titulo" class="control-label minotaur-label">Título</label>
	              	<input type="text" name="titulo" id="titulo" class="form-control" ng-model="mb.fData.titulo" placeholder="Registre titulo del banner" >

	            	<label class="control-label minotaur-label">Imagen</label>
	            	<div ng-show="mb.fData.canvas">
				        <img src="../images/index/revolution-slider/bg-slide-1.jpg" ng-if="!image" style="width:100%">
						<img ng-if="image" ng-src="{{image}}" alt="" style="width: 100%">
				        <input upload-me type="file" name="upload" accept=".gif, .jpg, .png, .jpeg">
				        <a href="" class="block text-red" style="width: 60px" ng-click="mb.fData.canvas=false;">Cancelar</a>
	            	</div>
	            	<div ng-show="!mb.fData.canvas">
				        <img ng-src="{{mb.rutaImagen}}{{mb.fData.imagen}}" alt="" style="width: 100%">
				        <a href="" ng-click="mb.fData.canvas=true">Cambiar Imagen</a>
	            	</div>

	            	<label class="control-label minotaur-label">Incluye Texto sobre el slide?</label>
	            	<label class="radio ml-lg mt-n" >
						<input type="radio" name="optionsRadios" id="optionsRadios1" value="1" ng-model="mb.fData.acepta_texto">
						Si, con texto.
					</label>

					<label class="radio ml-lg" >
						<input type="radio" name="optionsRadios" id="optionsRadios2" value="0" ng-model="mb.fData.acepta_texto" >
						No, sin texto.
					</label>
	            </div>


	            <div class="form-group col-md-6 pl-0">
					<div class="row">
						<div class="form-group col-sm-8">
			              	<label for="texto1" class="control-label minotaur-label">Texto 1</label>
			              	<input type="text" name="texto1" id="texto1" class="form-control" ng-model="mb.fData.capas[0].texto" placeholder="Ingrese texto" ng-disabled="mb.fData.acepta_texto == '0'" >
						</div>
	              		<div class="form-group col-sm-4 pl-0">
			              	<label class="control-label minotaur-label">Color Texto</label>
			         		<input colorpicker="rgba" colorpicker-position="right" ng-model="mb.fData.capas[0].color" type="text" class="form-control">
			            </div>

					</div>
	              	<div class="row" ng-show="mb.fData.acepta_texto == '1'">
	              		<div class="form-group col-sm-4">
		              		<label class="control-label minotaur-label">Tamaño Letra </label>
		              		<div touch-spin ng-model="mb.fData.capas[0].fontsize" options="{postfix: 'px', verticalButtons: true}" ></div>
	              		</div>
	              		<div class="form-group col-sm-4 pl-0">
		              		<label class="control-label minotaur-label">Interlineado </label>
		              		<div touch-spin ng-model="mb.fData.capas[0].line_height" options="{postfix: 'px', verticalButtons: true}" ></div>
	              		</div>
	              		<div class="form-group col-sm-4 pl-0">
		              		<label class="control-label minotaur-label">Ancho </label>
		              		<div touch-spin ng-model="mb.fData.capas[0].data_width" options="{postfix: 'px', verticalButtons: true, max: 1000, step:10}" ></div>
	              		</div>
	              	</div>
	              	<div class="row" ng-show="mb.fData.acepta_texto == '1'">
	              		<div class="form-group col-sm-6">
		              		<label class="control-label minotaur-label">Posición Vertical </label>
		              		<select class="form-control" ng-model="mb.fData.capas[0].data_y" ng-options="item.id as item.descripcion for item in mb.listaVertical" > </select>
	              		</div>
	              		<div class="form-group col-sm-4 pl-0">
		              		<label class="control-label minotaur-label">V-Offset </label>
		              		<div touch-spin ng-model="mb.fData.capas[0].offset_vertical" options="{postfix: 'px', verticalButtons: true, max: 1000, step:10}" ></div>
	              		</div>
	              	</div>
	              	<div class="row" ng-show="mb.fData.acepta_texto == '1'">
	              		<div class="form-group col-sm-6 mr-0">
			              	<label class="control-label minotaur-label">Posición Horizontal</label>
			         		<select class="form-control" ng-model="mb.fData.capas[0].data_x" ng-options="item.id as item.descripcion for item in mb.listaHorizontal" > </select>
			            </div>
			            <div class="form-group col-sm-4 pl-0">
		              		<label class="control-label minotaur-label">H-Offset </label>
		              		<div touch-spin ng-model="mb.fData.capas[0].offset_horizontal" options="{postfix: 'px', verticalButtons: true, max: 1000, step:10}" ></div>
	              		</div>
	              	</div>


	              	<div class="row">
						<div class="form-group col-sm-8">
			              	<label for="texto2" class="control-label minotaur-label">Texto 2</label>
			              	<input type="text" name="texto2" id="texto2" class="form-control" ng-model="mb.fData.capas[1].texto" placeholder="Ingrese texto" ng-disabled="mb.fData.acepta_texto == '0'" >
						</div>
	              		<div class="form-group col-sm-4 pl-0">
			              	<label class="control-label minotaur-label">Color Texto</label>
			         		<input colorpicker="rgba" colorpicker-position="right" ng-model="mb.fData.capas[1].color" type="text" class="form-control" ng-disabled="mb.fData.acepta_texto == '0'">
			            </div>

					</div>

	              	<div class="row" ng-show="mb.fData.acepta_texto == '1'">
	              		<div class="form-group col-sm-4">
		              		<label class="control-label minotaur-label">Tamaño Letra </label>
		              		<div touch-spin ng-model="mb.fData.capas[1].fontsize" options="{postfix: 'px', verticalButtons: true}" ></div>
	              		</div>
	              		<div class="form-group col-sm-4 pl-0">
		              		<label class="control-label minotaur-label">Interlineado </label>
		              		<div touch-spin ng-model="mb.fData.capas[1].line_height" options="{postfix: 'px', verticalButtons: true}" ></div>
	              		</div>
	              		<div class="form-group col-sm-4 pl-0">
		              		<label class="control-label minotaur-label">Ancho </label>
		              		<div touch-spin ng-model="mb.fData.capas[1].data_width" options="{postfix: 'px', verticalButtons: true, max: 1000, step:10}" ></div>
	              		</div>
	              	</div>
	              	<div class="row" ng-show="mb.fData.acepta_texto == '1'">
	              		<div class="form-group col-sm-6">
		              		<label class="control-label minotaur-label">Posición Vertical </label>
		              		<select class="form-control" ng-model="mb.fData.capas[1].data_y" ng-options="item.id as item.descripcion for item in mb.listaVertical" > </select>
	              		</div>
	              		<div class="form-group col-sm-4 pl-0">
		              		<label class="control-label minotaur-label">V-Offset </label>
		              		<div touch-spin ng-model="mb.fData.capas[1].offset_vertical" options="{postfix: 'px', verticalButtons: true, max: 1000, step:10}" ></div>
	              		</div>
	              	</div>
	              	<div class="row" ng-show="mb.fData.acepta_texto == '1'">
	              		<div class="form-group col-sm-6 mr-0">
			              	<label class="control-label minotaur-label">Posición Horizontal</label>
			         		<select class="form-control" ng-model="mb.fData.capas[1].data_x" ng-options="item.id as item.descripcion for item in mb.listaHorizontal" > </select>
			            </div>
			            <div class="form-group col-sm-4 pl-0">
		              		<label class="control-label minotaur-label">H-Offset </label>
		              		<div touch-spin ng-model="mb.fData.capas[1].offset_horizontal" options="{postfix: 'px', verticalButtons: true, max: 1000, step:10}" ></div>
	              		</div>
	              	</div>

	            </div>
		    </div>

		</form>
	</section>
</div>
<div class="modal-footer">
  <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" ng-click="mb.cancel()"><i class="fa fa-arrow-left"></i> Cancel</button>
  <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" ng-disabled="formBanner.$invalid" ng-click="mb.aceptar()"><i class="fa fa-arrow-right"></i> Grabar</button>
</div>