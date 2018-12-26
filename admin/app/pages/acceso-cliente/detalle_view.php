<div class="modal-header">
  <h4 class="modal-title">{{mc.modalTitle}}</h4>
</div>
<div class="modal-body">
	<section class="tile-body" style="min-height: 120px">
		<div class="col-xs-12">
          <div class="form-group pull-right" style="position: relative;z-index: 10" ng-show="mc.gridOptionsDetalle.data.length > 0">
            <button class="btn btn-default" ng-click='mc.btnExportarListaPdf()' title="Exportar a PDF">
              <i class="fa fa-file-pdf-o text-danger f-24" ></i>
            </button>
          </div>
          <div class="form-group pull-right" style="position: relative;z-index: 10" ng-show="mc.gridOptionsDetalle.data.length > 0">
            <button class="btn btn-default" ng-click='mc.btnExportarListaExcel()' title="Exportar a Excel">
              <i class="fa fa-file-excel-o text-success f-24" ></i>
            </button>
          </div>
        </div>
		<div class="col-md-12 col-sm-12 mb-md">
          <!-- <p ui-t="groupPanel.description"></p> -->
	        <div
	          	class="grid table-responsive"
	          	ng-style="mc.getTableHeight();"
	          	style = "max-height: 350px"
	          	ui-grid="mc.gridOptionsDetalle"
	          	ui-grid-resize-columns
	          	ui-grid-auto-resize
	          	ng-show="mc.gridOptionsDetalle.data.length"
	        >
          	</div>
          	<div class="waterMarkEmptyData" ng-show="!mc.gridOptionsDetalle.data.length" style="top:30px">{{mc.mensaje}}</div>
        </div>
	</section>
</div>
<div class="modal-footer">
  <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" ng-click="mc.cancel()"><i class="fa fa-arrow-left"></i> Salir</button>
</div>