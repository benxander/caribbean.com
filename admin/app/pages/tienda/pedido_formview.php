<div class="modal-header">
  <h4 class="modal-title">{{mp.modalTitle}}</h4>
</div>
<div class="modal-body">
	<section class="tile-body">
		<form name="formPedido" role="form" novalidate class="form-validation">
		  <section class="tile">
        <div class="tile-header pb-0">
          <div class="row">
            <div class="form-group col-sm-6">
              <label for="cantidad" class="control-label minotaur-label">Fotografía seleccionada: </label>
              <img class="img-responsive" ng-src="{{mp.fData.imagen.src_thumb}}" alt="" style="width: 100px;">
            </div>
          </div>
        </div>
        <div class="tile-body pt-0">
          <div class="table-responsive">
            <table class="table table-hover table-striped m-0">
              <thead>
              <tr>
                <th style="width: 80px">Image</th>
                <th>Color</th>
                <th>Talla</th>
                <th style="width: 130px">Cantidad</th>
                <th>Precio Unitario</th>
                <th>Total</th>
                <th>Actions</th>
              </tr>
              </thead>
              <tbody >
              <tr ng-repeat="item in mp.listaProductos">
                <td style="width: 80px">
                  <img ng-src="{{ mp.dirImagesProducto + item.imagen }}" alt="" class="thumb thumb">
                </td>
                <td>
                  <ul class="color-list">
                      <li ng-repeat="itemColor in item.colores" class="color" ng-class="{ 'white': itemColor.rgba == 'rgba(255,255,255,1)' }" title="{{itemColor.nombre}}" ng-model="mp.producto[item.idproductomaster].idcolor" uib-btn-radio="'{{itemColor.idcolor}}'" ng-click="mp.cambiaColor(itemColor,item.idproductomaster);"><div><div style="background-color: {{itemColor.rgba}}; width: 100%;"></div></div></li>

                  </ul>
                </td>
                <td>
                 <div class="btn-group mb-5">
                  <label ng-repeat="itemSize in item.categorias[1].medidas" class="btn btn-info" ng-model="mp.producto[item.idproductomaster].idproducto" uib-btn-radio="'{{itemSize.idproducto}}'" ng-click="mp.cambiaProducto(itemSize, item.idproductomaster)">{{itemSize.denominacion}}</label>
                </div>
                </td>
                <td>
                  <div touch-spin ng-model="mp.producto[item.idproductomaster].cantidad" options="{min: 1, max: 100}" ng-change="mp.cambiaCantidad(item.idproductomaster)"></div>

                  <!-- <div>
                    <label class="checkbox minotaur-radio minotaur-radio-sm"> Básico
                      <input name="customRadio" type="radio" id="optionsRadios1"  ng-model="mp.producto[item.idproductomaster].categoria" value="1">
                      <div class="input-indicator"></div>
                    </label>
                    <label class="checkbox minotaur-radio minotaur-radio-sm"> Premium
                      <input name="customRadio" type="radio" id="optionsRadios2"  ng-model="mp.producto[item.idproductomaster].categoria" value="2">
                      <div class="input-indicator"></div>
                    </label>
                  </div> -->
                </td>
                <td>
                  <div style="min-height: 34px;">
                    <span>{{mp.producto[item.idproductomaster].precio}}</span>
                  </div>
                  <div ng-if="item.si_genero == 1">
                    <label class="checkbox minotaur-radio minotaur-radio-sm"> Hombre
                      <input name="customRadio" type="radio" id="optionsRadios1{{item.idproductomaster}}"  ng-model="mp.producto[item.idproductomaster].genero" value="'H'">
                      <div class="input-indicator"></div>
                    </label>
                    <label class="checkbox minotaur-radio minotaur-radio-sm"> Mujer
                      <input name="customRadio" type="radio" id="optionsRadios2{{item.idproductomaster}}"  ng-model="mp.producto[item.idproductomaster].genero" value="'M'">
                      <div class="input-indicator"></div>
                    </label>
                  </div>
                </td>
                <td>
                  <span>{{mp.producto[item.idproductomaster].total_detalle}}</span>
                </td>
                <td>
                  <div class="onoffswitch labeled blue inline-block">
                    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="switch{{item.idproductomaster}}" ng-model="mp.producto[item.idproductomaster].activo" checked="" ng-change="mp.desactivar(item.idproductomaster);">
                    <label class="onoffswitch-label" for="switch{{item.idproductomaster}}">
                      <span class="onoffswitch-inner"></span>
                      <span class="onoffswitch-switch"></span>
                    </label>
                  </div>
                </td>
              </tr>

              </tbody>
            </table>
          </div>
        </div>
      </section>
		</form>
	</section>
</div>
<div class="modal-footer">
  <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" ng-click="mp.cancel()"><i class="fa fa-arrow-left"></i> Cancel</button>
  <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" ng-disabled="formPedido.$invalid" ng-click="mp.aceptar()"><i class="fa fa-arrow-right"></i> Guardar</button>
</div>