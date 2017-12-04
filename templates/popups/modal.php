<div class="modal-header">
	<h4 class="modal-title"> {{item.titulo}}  </h4>
</div>
<div class="modal-body">
	<div class="row">
		<div class="col-md-12" ng-bind-html="item.descripcion">	</div>
	</div>
	<div ng-if="item.ficha_galeria == 'SI' && item.imagenes.length > 0">
		<ng-gallery images="item.imagenes"></ng-gallery>
	</div>
	<div ng-if="item.ficha_galeria == 'SI'">
		<div class="blog-article-content embed-responsive embed-responsive-16by9" ng-if="item.codigo_youtube">
        	<youtube-video video-id="item.codigo_youtube"></youtube-video>
		</div>

		<div class="blog-article-content" ng-if="item.codigo_vimeo">
			<div class="embed-responsive embed-responsive-16by9" ng-bind-html="item.htmlVimeo">

			</div>
		</div>
	</div>

	<div class="login" ng-show="item.ficha_galeria == 'NO'">
		<a class="btn btn-mini btn-default-2 waves" ng-href="{{dirWeb}}admin" target="_blank" style="margin-bottom: 0px;margin-top: 12px;">ACCESO A TU CUENTA!</a>
	</div>
</div>
