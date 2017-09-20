	<div id="page-content"  ng-controller="BlogController as vm">



		<div class="container" id="blog">
            <div class="row">
                <div class="col-sm-12">

                    <div class="blog-article" ng-repeat="item in vm.listaNoticias">

						<div class="blog-article-thumbnail">

							<a href=""><img ng-src="{{item.imagen}}" alt=""></a>

						</div><!-- blog-article-thumbnail -->

						<a class="date" href="#">{{item.dia}} <small>{{item.mes}}</small></a>

						<h6 class="blog-article-subtitle" ng-show="false"><a href="#">Lifestyle &amp; Travel</a></h6>

						<h4 class="blog-article-title"><a href="blog-post-right-sidebar.html">{{item.titulo}}</a></h4>

						<div class="blog-article-details">
							by <a class="author" href="#">{{item.autor}} </a>

							<a class="comments" href="#">0 comments</a>
						</div>

						<div class="blog-article-content">
							<div ng-bind-html="item.descripcion"></div>

							<a href="">Leer Mas</a>

						</div><!-- blog-article-content -->

					</div><!-- blog-article -->

                </div><!-- col -->

            </div><!-- row -->
        </div><!-- container -->

		<div class="container" ng-show="false">
            <div class="row">
                <div class="col-sm-12">

                    <ul class="pagination">
						<li class="active"><a href="#">1.</a></li>
						<li><a href="#">2.</a></li>
						<li><a href="#">3.</a></li>
					</ul>

                </div><!-- col -->
            </div><!-- row -->
        </div><!-- container -->

	</div><!-- PAGE CONTENT