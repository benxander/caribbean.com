<div class="tile p-15">
  <section class="tile-header pl-0 pr-0">
    <div class="row">
      <div class="col-sm-12">
        <h1 class="heading pull-left">Merchandising</h1>
        <div class="form-group pull-right" >
            <button class="btn btn-warning" style="font-size:14px;color:#fff;" ng-click="ga.selectPedido()">
              <i class="halcyon-icon-back"></i> Regresar
            </button>
        </div>
      </div>
    </div>
    <div class="row">
      <uib-tabset class="minotaur-tab minotaur-tab-light mt-10 mb-10">
        <uib-tab heading="{{item.descripcion_pm}}" ng-repeat="item in ga.listaProductos" ng-click="ga.cambiaProducto(item.idproductomaster);">
          <div class= "mt-lg" ng-show="!ga.productoBool">
            <div class="m" ng-repeat="categoria in item.categorias" style="display: inline-block;">
              <button class="btn btn-ef btn-ef-1 btn-ef-1f mb-10" ng-click="ga.selectSize(categoria);">
                <div class="text-center p" style="height: 213px;">
                  <h4 class="text-info">{{categoria.descripcion_ca}}</h4>
                  <span>Desde</span>
                  <h1 class="mt-0"><span class="f-18">US $ </span>{{categoria.medidas[0].precio}}</h1>
                  <div class="col-md-12" style="width: 80px">
                    <img ng-src="{{ ga.dirImagesProducto + item.imagen }}" alt="" class="thumb">
                  </div>
                </div>

              </button>
            </div>
          </div>
          <div class= "mt-lg" ng-if="ga.productoBool">
            <div class="col-md-1" style="width: 80px">
              <label class="minotaur-label">{{ga.categoriaSel.descripcion_ca}}</label>
              <img ng-src="{{ ga.dirImagesProducto + item.imagen }}" alt="" class="thumb">
            </div>
            <div class="col-md-3">
              <label class="minotaur-label">Color</label>
              <ul class="color-list">
                  <li ng-repeat="itemColor in item.colores" class="color" ng-class="{ 'white': itemColor.rgba == 'rgba(255,255,255,1)' }" title="{{itemColor.nombre}}" ng-model="ga.producto[item.idproductomaster].idcolor" uib-btn-radio="'{{itemColor.idcolor}}'" ng-click="ga.cambiaColor(itemColor,item.idproductomaster);"><div><div style="background-color: {{itemColor.rgba}}; width: 100%;"></div></div></li>
              </ul>
              <div ng-if="item.si_genero == 1">
                <label class="checkbox minotaur-radio minotaur-radio-sm"> Hombre
                  <input name="customRadio" type="radio" id="optionsRadios1{{item.idproductomaster}}"  ng-model="ga.producto[item.idproductomaster].genero" value="'H'">
                  <div class="input-indicator"></div>
                </label>
                <label class="checkbox minotaur-radio minotaur-radio-sm"> Mujer
                  <input name="customRadio" type="radio" id="optionsRadios2{{item.idproductomaster}}"  ng-model="ga.producto[item.idproductomaster].genero" value="'M'">
                  <div class="input-indicator"></div>
                </label>
              </div>
            </div>
            <div class="col-md-4">
              <label class="minotaur-label block">{{item.tipo_medida}}</label>
              <div class="btn-group mb-5">
                <label ng-repeat="itemSize in ga.categoriaSel.medidas" class="btn btn-info" ng-model="ga.producto[item.idproductomaster].idproducto" uib-btn-radio="'{{itemSize.idproducto}}'" ng-click="ga.cambiaMedida(itemSize, item.idproductomaster)">{{itemSize.denominacion}}</label>
              </div>
            </div>
            <div class="col-md-4" style="min-height: 120px;">
              <label class="minotaur-label block">Seleccione una fotografía</label>
              <a href="" class="icon icon-primary icon-ef-3 icon-ef-3a hover-color" ng-click="ga.selectFotografia();"><i class="fa fa-image"></i></a>
            </div>
            <div class="col-md-2">
              <label class="minotaur-label">Cantidad</label>
              <div touch-spin ng-model="ga.producto[item.idproductomaster].cantidad" options="{min: 1, max: 100}" ng-change="ga.cambiaCantidad(item.idproductomaster)"></div>
            </div>
            <div class="col-md-2">
              <label class="minotaur-label">Precio(US$)</label>
              <div style="min-height: 34px;">
                <span>{{ga.producto[item.idproductomaster].precio}}</span>
              </div>
            </div>
            <div class="col-md-2">
              <label class="minotaur-label">Total</label>
              <div style="min-height: 34px;">
                <span>{{ga.producto[item.idproductomaster].total_detalle}}</span>
              </div>
            </div>
            <div class="col-md-2">
              <button class="btn btn-warning btn-ef btn-ef-5 btn-ef-5b mb-10"><i class="fa fa-shopping-cart"></i> <span>Add to cart</span></button>
            </div>
          </div>

        </uib-tab>
        <!-- <uib-tab heading="Tab 2 title">
          Tab 2 content
        </uib-tab>
        <uib-tab heading="Tab 3 title">
          Tab 3 content
        </uib-tab> -->
      </uib-tabset>
    </div>
  </section>
</div>