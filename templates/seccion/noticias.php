<section class="full-section ">
  <div class="full-section-container">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="title text-center" style="margin-bottom:15px;">
            <h3>Noticias</h3>
          </div><!-- headline -->
        </div><!-- col -->
      </div><!-- row -->
    </div><!-- container -->

    <div class="homepage-community-wrapper parallax"  data-stellar-background-ratio="0.1" ng-if="seccionWeb" style="background-image: url(uploads/banners/FONDO/{{seccionWeb[3].contenedor[0].imagen_bg}});">
      <div class="homepage-community-items-wrapper home-toggle-area-active" id="js-home-blog-wrapper">
        <div class="row homepage-community-items-interior mt-xl">
          <div class="col-sm-4 homepage-community-item" ng-repeat="item in vm.listaNoticiasSec">
            <div class="homepage-community-item-interior">
              <div class="homepage-community-item-interior-top">
                <div class="homepage-community-item-date">
                    {{item.fecha}}
                </div>
                <a href="" class="homepage-community-item-title"><h4>{{item.titulo}}</h4></a>

                <div ng-bind-html="item.descripcion">

                </div>

              </div>
              <a href="{{dirWeb}}post?id={{item.idblog}}" class="homepage-community-item-more-link">Leer más >> </a>
            </div>
          </div>
        </div>
        <div class="homepage-community-items-footer">
          <p><a class="btn btn-default-1 waves" ng-href="{{dirWeb}}blog" >Ver todas las Noticias</a></p>
        </div>
      </div>
    </div>
  </div>
</section>