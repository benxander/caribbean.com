<div class="modal-header">
  <h4 class="modal-title">{{gm.modalTitle}}</h4>
</div>
<div class="modal-body">
	<section class="tile-body">
    <div class="row" masonry>
        <div class="gallery" ng-mixitup magnific-popup="{
          delegate: 'a.img-preview',
          type: 'image',
          tLoading: 'Loading image #%curr%...',
          mainClass: 'mfp-img-mobile',
          gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0,1]
          }
         }"
        >
          <div class="masonry-brick  m-20" ng-class="{'selected': image.selected}" ng-repeat="image in ga.images">
            <div class="img-container">
              <img class="img-responsive" ng-src="{{image.src_thumb}}" alt="">
              <div class="img-details-static" style="float: left; position: relative; top: 5px;">
                <!-- <h4>{{image.title}}</h4> -->
                <div class="img-controls">
                  <a href="javascript:;" class="img-select" ng-click="gm.selectImage($index)">
                    <i class="fa fa-square-o" ng-show="!image.selected"></i>
                    <i class="fa fa-check-square-o" ng-show="image.selected"></i>
                  </a>

                  <a class="img-preview" href="{{image.src}}" title="{{image.title}}">
                    <i class="fa fa-search"></i>
                  </a>

                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
	</section>
</div>
<div class="modal-footer">
  <button class="btn btn-primary btn-ef btn-ef-3 btn-ef-3c" ng-click="gm.aceptar()"><i class="fa fa-arrow-right"></i> Continuar</button>
</div>