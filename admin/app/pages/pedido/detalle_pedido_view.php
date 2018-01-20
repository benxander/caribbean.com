<div class="modal-header">
  <h4 class="modal-title">{{mp.modalTitle}}</h4>
</div>
<div class="modal-body">
	<section class="tile-body p-0 row">
		<div class="col-md-6 col-sm-12">
	        <fieldset class="row" style="padding-right: 10px;">
				<legend class="col-md-12"> Datos del Cliente </legend>
				<div class="form-group mb-md col-md-2 col-sm-6">
		            <label class="control-label minotaur-label"> Código:</label>
		            <p>{{mp.fData.codigo}}</p>
		        </div>
		        <div class="form-group mb-md col-md-10 col-sm-6">
		            <label class="control-label minotaur-label"> Nombres y Apellidos:</label>
		            <p>{{mp.fData.nombres}} {{mp.fData.apellidos}}</p>
		        </div>
		        <div class="form-group mb-md col-md-2 col-sm-6">
		            <label class="control-label minotaur-label"> Idioma:</label>
		            <p>{{mp.fData.ididioma}}</p>
		        </div>
		        <div class="form-group mb-md col-md-8 col-sm-6">
		            <label class="control-label minotaur-label"> Hotel:</label>
		            <p>{{mp.fData.hotel}}</p>
		        </div>
		        <div class="form-group mb-md col-md-2 col-sm-6">
		            <label class="control-label minotaur-label"> Habitación:</label>
		            <p>{{mp.fData.habitacion}}</p>
		        </div>

			</fieldset>
		</div>
		<div class="col-md-6 col-sm-12">
	        <fieldset class="row" style="padding-right: 10px;">
				<legend class="col-md-12"> Datos de la Excursión </legend>
		        <div class="form-group mb-md col-md-8 col-sm-6">
		            <label class="control-label minotaur-label"> Nombre: </label>
		            <p>{{mp.fData.excursion}}</p>
		        </div>
				<div class="form-group mb-md col-md-4 col-sm-6">
		            <label class="control-label minotaur-label"> Fecha: </label>
		            <p>{{mp.fData.fecha_excursion}}</p>
		        </div>


			</fieldset>
		</div>
		<div class="col-sm-12">
	        <fieldset class="row" style="padding-right: 10px;">
				<legend class="col-md-12"> Datos del Pedido </legend>
				<div class="form-group mb-md col-md-2 col-sm-6">
		          <img ng-src="{{ mp.dirImagesProducto + mp.fData.imagen_producto }}" alt="" style="width: 100%;">
		        </div>
		        <div class="form-group mb-md col-md-8 col-sm-6">
		            <label class="control-label minotaur-label"> Producto: </label>
		            <p>{{mp.fData.producto}}</p>
		        </div>
				<div class="form-group mb-md col-md-4 col-sm-6">
		            <label class="control-label minotaur-label"> Color: </label>
		            <p>{{mp.fData.color}}</p>
		        </div>


			</fieldset>
		</div>
	</section>
</div>
<div class="modal-footer">
  <button class="btn btn-warning btn-ef btn-ef-4 btn-ef-4c" ng-click="mp.cancel()"><i class="fa fa-arrow-left"></i> Salir</button>
</div>