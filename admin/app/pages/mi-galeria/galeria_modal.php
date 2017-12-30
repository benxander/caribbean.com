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
              <img class="img-responsive btn btn-rounded btn-ef btn-ef-2 btn-ef-2-danger btn-ef-2b" ng-src="{{image.src_thumb}}" alt="" ng-click="gm.selectFoto(image)">
              <div class="img-details-static">
                <!-- <h4>{{image.title}}</h4> -->
                <div class="img-controls">
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
  <button class="btn btn-warning btn-ef btn-ef-3 btn-ef-3c" ng-click="gm.aceptar()"><i class="fa fa-arrow-right"></i> Salir</button>
</div>