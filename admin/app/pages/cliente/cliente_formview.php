<div class="modal-header">
  <h4 class="modal-title">{{mc.modalTitle}}</h4>
</div>
<div class="modal-body">
	<section class="tile-body">
		<form name="formCliente" role="form" novalidate class="form-validation">
		    <div class="row">
	            <div class="form-group col-md-6" >
					<label for="codigo" class="control-label minotaur-label">Código del Cliente <small class="text-red">(*)</small> </label>
	              	<input type="text" name="codigo" id="codigo" class="form-control" ng-model="mc.fData.codigo" placeholder="Registre Código del Cliente" required>
	            </div>

	           <!--  <div class="form-group col-md-6">
					<label for="nombres" class="control-label minotaur-label">Nombre </label>
	              	<input type="text" name="nombres" id="nombres" class="form-control" ng-model="mc.fData.nombres" placeholder="Registre nombre">
	            </div> -->
	           <!--  <div class="form-group col-md-6">
					<label for="apellidos" class="control-label minotaur-label">Apellidos </label>
	              	<input type="text" name="apellidos" id="apellidos" class="form-control" ng-model="mc.fData.apellidos" placeholder="Registre apellidos" >
	            </div>
	            <div class="form-group col-md-6">
					<label for="email" class="control-label minotaur-label">Correo <small class="text-red">(*)</small> </label>
	              	<input type="text" name="email" id="email" class="form-control" ng-model="mc.fData.email" placeholder="example@email.com" ng-pattern="/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/" required>
	            </div> -->
	            <!-- <div class="form-group col-md-3">
					<label for="whatsapp" class="control-label minotaur-label">Whatsapp</label>
	              	<input type="text" name="whatsapp" id="whatsapp" class="form-control" ng-model="mc.fData.whatsapp" placeholder="Whatsapp" >
	            </div> -->
	            <div class="form-group col-md-6">
					<label class="control-label minotaur-label">Excursión <small class="text-red">(*)</small> </label>
	              	<select class="form-control" ng-model="mc.fData.idactividad" ng-options="item.id as item.descripcion for item in mc.listaExcursiones" required ng-disabled="mc.modoEdicion"> </select>
	            </div>




	            <!-- <div class="form-group col-md-3">
					<label for="hotel" class="control-label minotaur-label">Hotel</label>
	              	<input type="text" name="hotel" id="hotel" class="form-control" ng-model="mc.fData.hotel" placeholder="Registre Hotel" >
	            </div>
	            <div class="form-group col-md-3">
					<label for="habitacion" class="control-label minotaur-label">Habitación</label>
	              	<input type="text" name="habitacion" id="habitacion" class="form-control" ng-model="mc.fData.habitacion" placeholder="Registre Habitación" >
	            </div> -->
	            <div class="form-group col-md-6" >
					<label for="fecha_excursion" class="control-label minotaur-label">Fecha de Excursión <small class="text-red">(*)</small> </label>
	                <input type="text" class="form-control" id="fecha_excursion" ng-model="mc.fData.fecha_excursion" input-mask mask-options="{alias: 'dd-mm-yyyy'}" required>
	            </div>
	            <!-- <div class="form-group col-md-3" >
					<label for="fecha" class="control-label minotaur-label">Fecha de Salida <small class="text-red">(*)</small> </label>
	                <input type="text" class="form-control" id="fecha" ng-model="mc.fData.fecha_salida" input-mask mask-options="{alias: 'dd-mm-yyyy'}" required>
	            </div>
	            <div class="form-group col-md-6">
					<label for="idioma" class="control-label minotaur-label">Idioma <small class="text-red">(*)</small> </label>
	              	<select class="form-control" ng-model="mc.fData.ididioma" ng-options="item.id as item.descripcion for item in mc.listaIdiomas" required > </select>
	            </div> -->
	            <div class="form-group col-md-6" >
					<label for="monedero" class="control-label minotaur-label">Depósito </label>
	                <div touch-spin id="monedero" ng-model="mc.fData.monedero" options="{prefix: '$',verticalButtons: true, max: 100000, step:50}" ></div>
	            </div>
	           <!--  <div class="form-group col-md-3">
					<label for="telefono" class="control-label minotaur-label">Teléfono</label>
	              	<input type="text" name="codigo" id="telefono" class="form-control" ng-model="mc.fData.telefono" placeholder="999999999">
	            </div> -->
		    </div>
		</form>
	</section>
</div>
<div class="modal-footer">
  <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" ng-click="mc.cancel()"><i class="fa fa-arrow-left"></i> Cancel</button>
  <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" ng-disabled="formCliente.$invalid" ng-click="mc.aceptar()"><i class="fa fa-arrow-right"></i> Grabar</button>
</div>