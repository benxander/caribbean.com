<div class="tile p-15">
  <section class="tile-header pl-0 pr-0">
    <div class="row">
      <div class="col-sm-12">
        <h1 class="heading pull-left">Merchandising</h1>
        <div class="form-group pull-right" >
            <button class="btn btn-warning" style="font-size:14px;color:#fff;" ng-click="ga.btnPedidos()">
              <i class="halcyon-icon-back"></i> Regresar
            </button>
        </div>
      </div>
    </div>
    <div class="row">
      <uib-tabset class="minotaur-tab minotaur-tab-light mt-10 mb-10">
        <uib-tab heading="{{item.descripcion_pm}}" ng-repeat="item in ga.listaProductos" ng-click="ga.cambiaProducto(item);">
          <div class= "mt-lg" ng-show="!ga.productoBool">
            <div class="m" ng-repeat="categoria in item.categorias" style="display: inline-block;">
              <button class="btn btn-cyan btn-border" ng-click="ga.selectCat(categoria,item);">
                <div class="text-center p" style="height: 213px;">
                  <h4 class="text-info">{{categoria.descripcion_ca}}</h4>
                  <p ng-bind-html="categoria.texto_ca"></p>
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
                  <li ng-repeat="itemColor in item.colores" class="color" ng-class="{ 'white': itemColor.rgba == 'rgba(255,255,255,1)' }" title="{{itemColor.nombre}}" ng-model="ga.temporal.idcolor" uib-btn-radio="'{{itemColor.idcolor}}'" ng-click="ga.cambiaColor(itemColor);"><div><div style="background-color: {{itemColor.rgba}}; width: 100%;"></div></div></li>
              </ul>
              <div ng-if="item.si_genero == 1">
                <label class="checkbox minotaur-radio minotaur-radio-sm"> Hombre
                  <input name="customRadio" type="radio" id="optionsRadios1{{item.idproductomaster}}"  ng-model="ga.temporal.genero" value="H">
                  <div class="input-indicator"></div>
                </label>
                <label class="checkbox minotaur-radio minotaur-radio-sm"> Mujer
                  <input name="customRadio" type="radio" id="optionsRadios2{{item.idproductomaster}}"  ng-model="ga.temporal.genero" value="M">
                  <div class="input-indicator"></div>
                </label>
              </div>
            </div>
            <div class="col-md-4">
              <label class="minotaur-label block">{{item.tipo_medida}}</label>
              <div class="btn-group mb-5">
                <label ng-repeat="itemSize in ga.categoriaSel.medidas" class="btn btn-info" ng-model="ga.temporal.idproducto" uib-btn-radio="'{{itemSize.idproducto}}'" ng-click="ga.cambiaMedida(itemSize)">{{itemSize.denominacion}}</label>
              </div>
            </div>
            <div class="col-md-4" style="min-height: 140px;">
              <label class="minotaur-label block">Seleccione una fotografía</label>
              <a href="" class="icon icon-primary icon-ef-3 icon-ef-3a hover-color" ng-click="ga.selectFotografia(item);"><i class="fa fa-image"></i></a>
              <div ng-if="ga.temporal.isSel">
                <img class="img-responsive" ng-src="{{ga.temporal.imagen.src_thumb}}" alt="" style="width: 100px;">
              </div>
            </div>
            <div class="col-md-2">
              <label class="minotaur-label">Cantidad</label>
              <div touch-spin ng-model="ga.temporal.cantidad" options="{min: 1, max: 100}" ng-change="ga.cambiaCantidad()"></div>
            </div>
            <div class="col-md-2">
              <label class="minotaur-label">Precio(US$)</label>
              <div style="min-height: 34px;">
                <span>{{ga.temporal.precio}}</span>
              </div>
            </div>
            <div class="col-md-2">
              <label class="minotaur-label">Total</label>
              <div style="min-height: 34px;">
                <span>{{ga.temporal.total_detalle}}</span>
              </div>
            </div>
            <div class="col-md-2">
              <button class="btn btn-warning btn-ef btn-ef-5 btn-ef-5b mb-10" ng-click="ga.agregarItem(ga.temporal)"><i class="fa fa-shopping-cart"></i> <span>Add to cart</span></button>
            </div>
          </div>

        </uib-tab>
      </uib-tabset>
      <div class="col-md-12 col-sm-12 mt-lg" >
        <div ui-grid="ga.gridOptions" ui-grid-auto-resize class="grid table-responsive clear">
        </div>
      </div>
      <div class="form-inline col-md-12 col-sm-12 mt-lg text-right">
        <label class="control-label mr-xs text-info f-18" style="font-weight: bolder;"> IMPORTE A PAGAR</label>
        <div class="input-group mb-10">
          <span class="input-group-addon">US$</span> <input type="text" class="form-control input-sm pull-right text-right f-18" ng-readonly="true" ng-model="ga.fData.total_a_pagar" style="width: 80px; font-weight: bolder;"/> <span class="input-group-addon">.00</span>
        </div>

      </div>
    </div>
  </section>
</div>