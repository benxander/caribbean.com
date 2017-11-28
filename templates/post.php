<div id="page-content">
	<div class="container">
        <div class="row">
			<div class="col-md-offset-1 col-md-10">
                <div class="blog-article">
					<div class="blog-article-thumbnail">
						<img ng-src="{{bp.fData.imagen}}" alt="">
					</div><!-- blog-article-thumbnail -->
					<a class="date" href="#">{{bp.fData.dia}} <small>{{bp.fData.mes}}</small></a>
					<h6 class="blog-article-subtitle" ng-show="false"><a href="#">Lifestyle &amp; Travel</a></h6>
					<h4 class="blog-article-title">{{bp.fData.titulo}}</h4>
					<div class="blog-article-details">
						by <a class="author" href="#">{{bp.fData.autor}}</a>
						<!-- in <a class="category" href="#">Uncategorized</a> -->
						<a class="comments" href="#">{{bp.fData.posts.length}} comentario(s)</a>
					</div>
					<div class="blog-article-content" ng-bind-html="bp.fData.descripcion"></div>
					<div class="blog-article-content" ng-if="bp.slides.length>0" >
			            <div uib-carousel active="bp.active" interval="bp.myInterval" no-wrap="bp.noWrapSlides">
			              <div uib-slide ng-repeat="slide in bp.slides track by slide.idblogimagen" index="slide.idblogimagen">
			                <img ng-src="{{slide.src_image_web}}" style="margin:20px;">
			                <!-- <div class="carousel-caption">
			                  <h4 class="text-white">Slide {{slide.id}}</h4>
			                  <p>{{slide.text}}</p>
			                </div> -->
			              </div>
			            </div>
			        </div>
					<div class="blog-article-content" ng-if="bp.fData.enlace">
	                	<youtube-video video-url="bp.fData.enlace"></youtube-video>
					</div>
				</div><!-- blog-article -->

				<h6 class="commentlist-title">Comentarios ({{bp.fData.posts.length}})</h6>
				<ul class="commentlist">
                	<li class="comment depth-1" ng-repeat="item in bp.fData.posts">
                    	<div class="comment-body">
                            <div class="comment-meta">
                                <div class="comment-author">
                                    <img class="avatar" src="images/blog/blog-post/author-comment-1.jpg" alt="">
                                    <a class="fn" href="#">{{item.autor_post}}</a>
                                </div><!-- comment-author -->

                                 <div class="comment-metadata">
                                    <a href="#">{{item.fecha_post}}</a>
                                </div><!-- comment-metadata -->
                            </div><!-- comment-meta -->

                            <div class="comment-content">
                            	{{item.comentario}}
                            </div><!--  comment-content -->

							<div class="reply" ng-if="false">
                            	<a class="comment-reply-link" href="#">Reply</a>
                            </div><!-- reply -->

                        </div><!-- comment-body -->
					</li>

				</ul>

				<h6 class="commentform-title">Déjanos un Comentario</h6>

				<form id="commentform" class="col-sm-10" name="commentform" novalidate method="post" action="#">
                    <fieldset>

                        <p class="commentform-author">
                            <input id="name" class="col-xs-12" type="text" name="name" placeholder="" required>
							<label for="name">Nombre</label>
                        </p>

                        <p class="commentform-email">
                            <input id="email" class="col-xs-12" type="text" name="email" placeholder="" required>
							<label for="email">E-mail</label>
                        </p>


						<p class="commentform-comment">
                            <textarea id="comment" class="col-xs-12" name="comment" rows="6" cols="25" placeholder="" required></textarea>
							<label for="comment">Comentario</label>
                        </p>

                        <p class="commentform-submit">
                            <button class="btn btn-default-1 waves" id="submit" type="submit" name="submit" value="">Enviar</button>
                        </p>

                    </fieldset>
                </form>

            </div><!-- col -->
        </div><!-- row -->
    </div><!-- container -->
	<section class="full-section dark-section" id="section-64">
		<div class="full-section-container">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<div class="portfolio-navigation">
							<a class="prev" href="#"><i class="fa fa-angle-left"></i> Previous post</a>
							<a class="next" href="#">Next post <i class="fa fa-angle-right"></i></a>
						</div><!-- portfolio-navigation -->
					</div><!-- col -->
				</div><!-- row -->
			</div><!-- container -->
		</div><!-- full-section-container -->
	</section><!-- full-section -->
</div>