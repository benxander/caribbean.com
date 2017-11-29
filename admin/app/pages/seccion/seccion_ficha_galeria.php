<style>
	#icono .dropdown-menu{
		height: 190px!important;
		overflow: auto!important;
	}
</style>
<div class="modal-header">
  <h4 class="modal-title">{{mf.modalTitle}}</h4>
</div>
<div class="modal-body">
	<section class="tile-body">
          <div class="row">
            <div class="col-md-12 col-sm-12">
              <div class="form-group">
                <h4 class="heading mt-n col-md-6">FICHA: {{mf.fDataUpload.codigo}}</h4>

              </div>
              <div class="form-group mt-lg" style="position: relative;z-index: 10">
                <div class="form-group" >
                  <label class="col-md-12 control-label minotaur-label">Seleccione</label>
                  <div class="form-group col-md-3">
                    <input type="file" nv-file-select="" uploader="uploader" multiple class="filestyle" filestyle="{ buttonText: 'Select file', iconName: 'fa fa-inbox' }" accept=".jpeg, .jpg, .mp4, .mkv, .avi, .dvd, .mov"/><br/>
                  </div>
                  <div class="form-group col-md-9" style="text-align: right;">
                    <span >Tamaño maximo para Imagenes es de 10MB</span> <br/>
                    <span>Tamaño maximo para Videos es de 100Mb</span>
                  </div>

                  <div class="col-md-12" style="margin-bottom: 40px;background-color: #fbfbf2;padding: 35px 20px;">

                    <p>Cantidad de archivos en cola: {{ uploader.queue.length }}</p>

                    <table class="table">
                        <thead>
                            <tr>
                                <th width="50%">Nombre</th>
                                <th ng-show="uploader.isHTML5">Tamaño</th>
                                <th ng-show="uploader.isHTML5">Progreso</th>
                                <th>Estatus</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="item in uploader.queue">
                                <td><strong>{{ item.file.name }}</strong></td>
                                <td ng-show="uploader.isHTML5" nowrap>{{ item.file.size/1024/1024|number:2 }} MB</td>
                                <td ng-show="uploader.isHTML5">
                                    <div class="progress" style="margin-bottom: 0;">
                                        <div class="progress-bar" role="progressbar" ng-style="{ 'width': item.progress + '%' }"></div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span ng-show="item.isSuccess"><i class="glyphicon glyphicon-ok"></i></span>
                                    <span ng-show="item.isCancel"><i class="glyphicon glyphicon-ban-circle"></i></span>
                                    <span ng-show="item.isError"><i class="glyphicon glyphicon-remove"></i></span>
                                </td>
                                <td nowrap>
                                    <button type="button" class="btn btn-success btn-xs" ng-click="item.upload()" ng-disabled="item.isReady || item.isUploading || item.isSuccess">
                                        <span class="glyphicon glyphicon-upload"></span> Subir
                                    </button>
                                    <button type="button" class="btn btn-warning btn-xs" ng-click="item.cancel()" ng-disabled="!item.isUploading">
                                        <span class="glyphicon glyphicon-ban-circle"></span> Cancelar
                                    </button>
                                    <button type="button" class="btn btn-danger btn-xs" ng-click="item.remove()">
                                        <span class="glyphicon glyphicon-trash"></span> Eliminar
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div>
                        <div>
                            <div class="progress" style="">
                                <div class="progress-bar" role="progressbar" ng-style="{ 'width': uploader.progress + '%' }"></div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success btn-s" ng-click="mf.subirTodo();" ng-disabled="!uploader.getNotUploadedItems().length">
                            <span class="glyphicon glyphicon-upload"></span> Subir Todo
                        </button>
                        <button type="button" class="btn btn-warning btn-s" ng-click="uploader.cancelAll()" ng-disabled="!uploader.isUploading">
                            <span class="glyphicon glyphicon-ban-circle"></span> Cancelar Todo
                        </button>
                        <button type="button" class="btn btn-danger btn-s" ng-click="uploader.clearQueue()" ng-disabled="!uploader.queue.length">
                            <span class="glyphicon glyphicon-trash"></span> Eliminar Todo
                        </button>
                    </div>

                  </div>
                </div>
                <div class="form-group col-md-12">
                  <div class="form-group" ng-if="mf.length_images > 0">
                    <ul class="mix-controls">
                      <li class="select-all">
                        <label class="checkbox minotaur-checkbox inline-block m-0">Seleccionar Todo
                          <input type="checkbox" ng-model="selectedAll" ng-click="mf.selectAll()"><div class="input-indicator"></div>
                        </label>
                      </li>
                      <li class="btn" ng-class="{'disabled': !mf.isSelected}">
                        <a href="javascript:;" ng-click="mf.btnDeleteArchivoSelect()"><i class="fa fa-trash-o"></i> Eliminar</a>
                      </li>
                    </ul>
                  </div>
                  <div class="row mix-grid">
                    <div class="gallery" ng-mixitup magnific-popup="{
                      delegate: 'a.img-preview',
                      type: 'image',
                      tLoading: 'Loading image #%curr%...',
                      mainClass: 'mfp-img-mobile',
                      gallery: {
                        enabled: true,
                        navigateByImgClick: true,
                        preload: [0,1]
                      }}" >

                      <div class="col-md-3 col-sm-4 mb-20 mix {{image.category}}" ng-class="{'selected': image.selected}" ng-repeat="image in mf.images">
                      <div class="img-container">
                        <img class="img-responsive" ng-src="{{image.src}}" alt="" ng-if="image.idtipoproducto == 1">
                        <img class="img-responsive" ng-src="{{image.src_image}}" alt="" ng-if="image.idtipoproducto == 2">
                        <div class="img-details">
                          <h4>{{image.title}}</h4>
                          <div class="img-controls">
                            <a href="javascript:;" class="img-select" ng-click="mf.selectImage($index)">
                              <i class="fa fa-circle-o" ng-show="!image.selected"></i>
                              <i class="fa fa-circle" ng-show="image.selected"></i>
                            </a>
                            <a href="javascript:;" class="img-link" ng-click="mf.btnAnularArchivo(image)">
                              <i class="fa fa-trash"></i>
                            </a>
                            <a class="img-preview" href="{{image.src}}" title="{{image.title}}" ng-if="image.idtipoproducto == 1">
                              <i class="fa fa-search"></i>
                            </a>
                            <a href="javascript:;" class="img-link" ng-if="image.idtipoproducto == 2" ng-click="mf.videosView(image)">
                              <i class="fa fa-search"></i>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>

                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </section>
</div>
<div class="modal-footer">
  <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" ng-click="mf.cancel()"><i class="fa fa-arrow-left"></i> Cancelar</button>
  <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" ng-disabled="formSeccionFicha.$invalid" ng-click="mf.aceptar()"><i class="fa fa-arrow-right"></i> Guardar</button>
</div>