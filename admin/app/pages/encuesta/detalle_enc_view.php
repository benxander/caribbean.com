<div class="modal-header">
    <h4 class="modal-title">{{dm.modalTitle}}</h4>
</div>

<div class="modal-body">
    <div class="row">
        <div class="col-md-12 col-md-12">
            <div ui-grid="dm.gridOptionsDetalle" ui-grid-auto-resize ui-grid-pagination class="grid table-responsive clear"></div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" ng-click="dm.cancel();">
        <i class="fa fa-arrow-left"></i> Salir
    </button>
</div>