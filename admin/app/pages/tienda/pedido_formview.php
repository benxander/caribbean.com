<div class="modal-header">
  <h4 class="modal-title">{{mp.modalTitle}}</h4>
</div>
<div class="modal-body">
	<section class="tile-body">
		<form name="formEmail" role="form" novalidate class="form-validation">
		    <section class="tile">

              <!-- tile header -->
              <div class="tile-header">
                <a href="javascript:;" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Add Image</a>
                <h3 class="tile-heading">Elegir Producto</h3>
              </div>
              <!-- /tile header -->


              <!-- tile body -->

              <!-- /tile body -->

            </section>
		</form>
	</section>
</div>
<div class="modal-footer">
  <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" ng-click="mp.cancel()"><i class="fa fa-arrow-left"></i> Cancel</button>
  <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" ng-disabled="formEmail.$invalid" ng-click="mp.aceptar()"><i class="fa fa-arrow-right"></i> Grabar</button>
</div>