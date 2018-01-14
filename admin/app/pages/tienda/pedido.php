<uib-tabset class="minotaur-tab minotaur-tab-light mt-10 mb-10">
  <uib-tab heading="{{item.descripcion_pm}}" ng-repeat="item in ctrl.listaProductos" ng-click="ctrl.cambiaProducto(item);">
    <div class= "mt-lg" ng-show="!ctrl.productoBool">
      <div class="m" ng-repeat="categoria in item.categorias" style="display: inline-block;">
        <button class="btn btn-cyan btn-border" ng-click="ctrl.selectCat(categoria,item);">
          <div class="text-center p" style="height: 213px;">
            <h4 class="text-info">{{categoria.descripcion_ca}}</h4>

            <span>Desde</span>
            <h1 class="mt-0"><span class="f-18">US $ </span>{{categoria.medidas[0].precio}}</h1>
            <div class="col-md-12" style="width: 80px">
              <img ng-src="{{ ctrl.dirImagesProducto + item.imagen }}" alt="" class="thumb">
            </div>
          </div>

        </button>
      </div>
    </div>
    <div class= "mt-lg" ng-if="ctrl.productoBool">
      <div class="col-md-3" >
        <label class="minotaur-label">{{ctrl.categoriaSel.descripcion_ca}}</label>
        <div>
          <img ng-src="{{ ctrl.dirImagesProducto + ctrl.categoriaSel.imagen_ca }}" alt="" style="width: 100%;">
        </div>
      </div>
      <div class="col-md-3" >
        <label class="minotaur-label block">{{ 'Text.DESCRIPCION' | translate }}</label>
        <p ng-bind-html="ctrl.categoriaSel.texto_ca"></p>
      </div>
      <div class="col-md-3">
        <label class="minotaur-label block" ng-if="item.si_color == 1">{{ 'Text.COLOR' | translate }}</label>
        <ul class="color-list">
          <li ng-repeat="itemColor in item.colores" class="color" ng-class="{ 'white': itemColor.rgba == 'rgba(255,255,255,1)' }" title="{{itemColor.nombre}}" ng-model="ctrl.temporal.idcolor" uib-btn-radio="'{{itemColor.idcolor}}'" ng-click="ctrl.cambiaColor(itemColor);"><div><div style="background-color: {{itemColor.rgba}}; width: 100%;"></div></div>
          </li>
        </ul>
        <div ng-if="item.si_genero == 1">
          <label class="minotaur-label block">{{ 'Text.GENERO' | translate }}</label>
          <label class="checkbox minotaur-radio minotaur-radio-sm"> {{ 'Text.HOMBRE' | translate }}
            <input name="customRadio" type="radio" id="optionsRadios1{{item.idproductomaster}}"  ng-model="ctrl.temporal.genero" value="H">
            <div class="input-indicator"></div>
          </label>
          <label class="checkbox minotaur-radio minotaur-radio-sm"> {{ 'Text.MUJER' | translate }}
            <input name="customRadio" type="radio" id="optionsRadios2{{item.idproductomaster}}"  ng-model="ctrl.temporal.genero" value="M">
            <div class="input-indicator"></div>
          </label>
        </div>
        <label class="minotaur-label block">{{item.tipo_medida}}</label>
        <div class="btn-group mb-5">
          <label ng-repeat="itemSize in ctrl.categoriaSel.medidas" class="btn btn-info" ng-model="ctrl.temporal.idproducto" uib-btn-radio="'{{itemSize.idproducto}}'" ng-click="ctrl.cambiaMedida(itemSize)">{{itemSize.denominacion}}</label>
        </div>
        <label class="minotaur-label block mt">{{ 'Text.CANTIDAD' | translate }}</label>
        <div touch-spin ng-model="ctrl.temporal.cantidad" options="{min: 1, max: 100}" ng-change="ctrl.cambiaCantidad()" class="text-right" style="width: 145px;"></div>
        <label class="minotaur-label block mt">{{ 'Text.PRECIO' | translate }}(US$)</label>
        <div class="input-group" style="min-height: 34px;width: 145px;">
          <span class="input-group-addon">US$</span>
          <input type="text" ng-model="ctrl.temporal.precio" class="text-right" ng-disabled="true" style="width: 100%"> <span class="input-group-addon">.00</span>
        </div>
        <label class="minotaur-label block mt">{{ 'Text.TOTAL' | translate }}(US$)</label>
        <div class="input-group" style="min-height: 34px;width: 145px;">
          <span class="input-group-addon">US$</span>
          <input type="text" ng-model="ctrl.temporal.total_detalle" class="text-right" ng-disabled="true" style="width: 100%"> <span class="input-group-addon">.00</span>
        </div>
      </div>
      <div class="col-md-3" style="min-height: 315px;">
        <label class="minotaur-label block" ng-show="item.tipo_seleccion == '1'">{{ 'Text.SELECCIONAR' | translate }}</label>
        <label class="minotaur-label block" ng-show="item.tipo_seleccion == '2'">{{ 'Text.SELECCIONE' | translate }} {{ctrl.temporal.size.cantidad_fotos}} {{ 'Text.FOTOGRAFIAS' | translate }}</label>
        <a href="" class="icon icon-primary icon-ef-3 icon-ef-3a hover-color" ng-click="ctrl.selectFotografia(item);"><i class="fa fa-image"></i></a>
        <div ng-if="ctrl.temporal.isSel && item.tipo_seleccion == '1'">
          <div>
            <img class="img-responsive" ng-src="{{ctrl.temporal.imagen.src}}" alt="" style="width: 100px;">
          </div>
        </div>
        <div ng-if="ctrl.temporal.isSel && item.tipo_seleccion == '2'">
          <div class="m-xs inline-block" ng-repeat="image in ctrl.images | filter: { selected: true }">
            <img class="img-responsive" ng-src="{{image.src_thumb}}" alt="" style="max-width: 80px;max-height: 53px;">
          </div>
        </div>
      </div>
      <button class="pull-right btn btn-primary btn-ef btn-ef-5 btn-ef-5b mb-10 mr-md" ng-click="ctrl.agregarItem(ctrl.temporal)"><i class="fa fa-shopping-cart"></i> <span>{{ 'Text.CESTA' | translate }}</span></button>
    </div>

  </uib-tab>
</uib-tabset>