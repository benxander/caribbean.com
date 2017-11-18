<div class="modal-header">
  <h4 class="modal-title">{{mp.modalTitle}}</h4>
</div>
<div class="modal-body">
	<section class="tile-body">
		<form name="formEmail" role="form" novalidate class="form-validation">
		    <section class="tile">

              <!-- tile header -->
              <div class="tile-header">
                <a href="javascript:;" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Add Image</a>
                <h3 class="tile-heading">Edit Images</h3>
              </div>
              <!-- /tile header -->


              <!-- tile body -->
              <div class="tile-body">

                <div class="table-responsive">
                  <table class="table table-hover table-striped m-0">
                    <thead>
                    <tr>
                      <th style="width: 110px">Image</th>
                      <th>Label</th>
                      <th style="width: 130px">Order</th>
                      <th>Base Image</th>
                      <th>Small Image</th>
                      <th>Thumbnail</th>
                      <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody magnific-popup="{
                        delegate: 'a.img-link',
                        type: 'image',
                        tLoading: 'Loading image #%curr%...',
                        mainClass: 'mfp-img-mobile',
                        gallery: {
                          enabled: true,
                          navigateByImgClick: true,
                          preload: [0,1]
                        }
                       }">
                    <tr>
                      <td>
                        <a href="http://placekitten.com/g/800/600" class="img-link">
                          <img src="http://placekitten.com/g/800/600" alt="" class="thumb thumb-lg">
                        </a>
                      </td>
                      <td><input type="text" class="form-control" placeholder="Image Label" value="Product thumbnail"></td>
                      <td>
                        <div touch-spin ng-model="ctrl.numberVar1" options="{min: 1, max: 100}"></div>
                      </td>
                      <td>
                        <label class="checkbox minotaur-radio minotaur-radio-sm">
                          <input name="product1" type="radio"><div class="input-indicator"></div>
                        </label>
                      </td>
                      <td>
                        <label class="checkbox minotaur-radio minotaur-radio-sm">
                          <input name="product1" type="radio"><div class="input-indicator"></div>
                        </label>
                      </td>
                      <td>
                        <label class="checkbox minotaur-radio minotaur-radio-sm">
                          <input name="product1" type="radio" checked><div class="input-indicator"></div>
                        </label>
                      </td>
                      <td>
                        <a href="javascript:;" class="btn btn-xs btn-lightred"><i class="fa fa-times"></i> Delete</a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <a href="http://placekitten.com/g/800/601" class="img-link">
                          <img src="http://placekitten.com/g/800/601" alt="" class="thumb thumb-lg">
                        </a>
                      </td>
                      <td><input type="text" class="form-control" placeholder="Image Label" value="Product Image 1"></td>
                      <td><div touch-spin ng-model="ctrl.numberVar2" options="{min: 1, max: 100}"></div></td>
                      <td>
                        <label class="checkbox minotaur-radio minotaur-radio-sm">
                          <input name="product2" type="radio" checked><div class="input-indicator"></div>
                        </label>
                      </td>
                      <td>
                        <label class="checkbox minotaur-radio minotaur-radio-sm">
                          <input name="product2" type="radio"><div class="input-indicator"></div>
                        </label>
                      </td>
                      <td>
                        <label class="checkbox minotaur-radio minotaur-radio-sm">
                          <input name="product2" type="radio"><div class="input-indicator"></div>
                        </label>
                      </td>
                      <td>
                        <a href="javascript:;" class="btn btn-xs btn-lightred"><i class="fa fa-times"></i> Delete</a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <a href="http://placekitten.com/g/800/602" class="img-link">
                          <img src="http://placekitten.com/g/800/602" alt="" class="thumb thumb-lg">
                        </a>
                      </td>
                      <td><input type="text" class="form-control" placeholder="Image Label" value="Product Image 2"></td>
                      <td> <div touch-spin ng-model="ctrl.numberVar3" options="{min: 1, max: 100}"></div></td>
                      <td>
                        <label class="checkbox minotaur-radio minotaur-radio-sm">
                          <input name="product3" type="radio"><div class="input-indicator"></div>
                        </label>
                      </td>
                      <td>
                        <label class="checkbox minotaur-radio minotaur-radio-sm">
                          <input name="product3" type="radio" checked><div class="input-indicator"></div>
                        </label>
                      </td>
                      <td>
                        <label class="checkbox minotaur-radio minotaur-radio-sm">
                          <input name="product3" type="radio"><div class="input-indicator"></div>
                        </label>
                      </td>
                      <td>
                        <a href="javascript:;" class="btn btn-xs btn-lightred"><i class="fa fa-times"></i> Delete</a>
                      </td>
                    </tr>
                    </tbody>
                  </table>
                </div>

              </div>
              <!-- /tile body -->

            </section>
		</form>
	</section>
</div>
<div class="modal-footer">
  <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" ng-click="mp.cancel()"><i class="fa fa-arrow-left"></i> Cancel</button>
  <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" ng-disabled="formEmail.$invalid" ng-click="mp.aceptar()"><i class="fa fa-arrow-right"></i> Grabar</button>
</div>