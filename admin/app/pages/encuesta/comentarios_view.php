<div class="modal-header">
  <h4 class="modal-title">{{mp.modalTitle}}</h4>
</div>
<div class="modal-body">
	<section class="tile">
		<!-- <div class="tile-widget b-b">

          <h5 class="text-strong m-0">Messages <span class="badge bg-lightred pull-right">8</span></h5>

        </div> -->

        <div class="tile-body p-0">
        	<ul class="list-unstyled">
	            <li class="p-10 b-b" ng-repeat="item in mp.listadoComentarios">
	              <div class="media">
	                <div class="media-left">
	                	<i class="fa fa-comment fa-2x text-info pull-left"></i>
	                  <!-- <img class="media-object img-circle thumb thumb-sm" src="assets/images/random-avatar8.jpg" alt=""> -->
	                </div>
	                <div class="media-body">
	                  <h5 class="media-heading mb-0">{{item.codigo}} <span class="pull-right">{{item.fecha}}</span></h5>
	                  <small class="text-muted" ng-bind-html="item.comentarios"></small>
	                </div>
	              </div>
	            </li>
	        </ul>
        </div>
	</section>
</div>
<div class="modal-footer">
  <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" ng-click="mp.cancel()"><i class="fa fa-arrow-left"></i> Salir</button>
</div>