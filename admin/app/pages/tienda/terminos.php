<div class="modal-header">
  <h4 class="modal-title">{{mt.modalTitle}}</h4>
</div>
<div class="modal-body">
	<section class="tile-body p-0" style="overflow-y: scroll;overflow-x: hidden;">
		<div class="row">
			<div class="col-sm-12" style="height: 400px">
				<div ng-bind-html="mt.contenido"></div>
			</div>
		</div>

	</section>
</div>
<div class="modal-footer">
  <button class="btn btn-warning btn-ef btn-ef-4 btn-ef-4c" ng-click="mt.cancel()"><i class="fa fa-arrow-left"></i> Salir</button>
</div>