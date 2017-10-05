<div class="modal-header">
  <h4 class="modal-title">{{mc.modalTitle}}</h4>
</div>
<div class="modal-body">
	<section class="tile-body">
		<form name="formCliente" role="form" novalidate class="form-validation">
		    <div class="row">

	            <div class="form-group col-md-6">
					<label for="nombres" class="control-label minotaur-label">Nombres </label>
	              	<input type="text" name="nombres" id="nombres" class="form-control" ng-model="mc.fData.nombres" placeholder="Registre nombres" required>
	            </div>
	            <div class="form-group col-md-6">
					<label for="apellidos" class="control-label minotaur-label">Apellidos </label>
	              	<input type="text" name="apellidos" id="apellidos" class="form-control" ng-model="mc.fData.apellidos" placeholder="Registre apellidos" required>
	            </div>
	            <div class="form-group col-md-6">
					<label for="email" class="control-label minotaur-label">Correo <small class="text-red">(*)</small> </label>
	              	<input type="text" name="email" id="email" class="form-control" ng-model="mc.fData.email" placeholder="example@email.com" ng-pattern="/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/" required>
	            </div>
	            <div class="form-group col-md-6">
					<label for="whatsapp" class="control-label minotaur-label">Whatsapp</label>
	              	<input type="text" name="whatsapp" id="whatsapp" class="form-control" ng-model="mc.fData.whatsapp" placeholder="Registre Whatsapp" >
	            </div>
	            <div class="form-group col-md-6">
					<label for="idioma" class="control-label minotaur-label">Idioma</label>
	              	<select class="form-control" ng-model="mc.fData.ididioma" ng-options="item.id as item.descripcion for item in mc.listaIdiomas" > </select>
	            </div>
	            <div class="form-group col-md-6" >
					<label for="codigo" class="control-label minotaur-label">Codigo del Cliente <small class="text-red">(*)</small> </label>
	              	<input type="text" name="codigo" id="codigo" class="form-control" ng-model="mc.fData.codigo" placeholder="Registre Codigo del Cliente" required>
	            </div>
	            <div class="form-group col-md-6" >
					<label for="fecha" class="control-label minotaur-label">Fecha de Estadia <small class="text-red">(*)</small> </label>
	                <input type="text" class="form-control" id="fecha" ng-model="mc.fData.fecha" input-mask mask-options="{alias: 'dd-mm-yyyy'}" required>
	            </div>
		    </div>
		</form>
	</section>
</div>
<div class="modal-footer">
  <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" ng-click="mc.cancel()"><i class="fa fa-arrow-left"></i> Cancel</button>
  <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" ng-disabled="formCliente.$invalid" ng-click="mc.aceptar()"><i class="fa fa-arrow-right"></i> Grabar</button>
</div>