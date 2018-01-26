<div class="tile p-15" ng-show="!ga.modoDescargaCompleta">
  <section class="tile-header pl-0 pr-0">
    <div class="row">
      <div class="col-sm-12">
        <h1 class="heading pull-left">{{ 'Text.MERCHANDISING' | translate }}</h1>
        <div class="form-group pull-right" >
            <button class="btn btn-warning" style="font-size:14px;color:#fff;" ng-click="ga.btnPedidos()">
              <i class="halcyon-icon-back"></i> {{ 'Text.REGRESAR' | translate }}
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
            <div class="col-md-3" >
              <label class="minotaur-label">{{ga.categoriaSel.descripcion_ca}}</label>
              <div>
                <img ng-src="{{ ga.dirImagesProducto + ga.categoriaSel.imagen_ca }}" alt="" style="width: 100%;">
              </div>
            </div>
            <div class="col-md-3" >
              <label class="minotaur-label block">{{ 'Text.DESCRIPCION' | translate }}</label>
              <p ng-bind-html="ga.categoriaSel.texto_ca"></p>
            </div>
            <div class="col-md-3">
              <label class="minotaur-label block" ng-if="item.si_color == 1">{{ 'Text.COLOR' | translate }}</label>
              <ul class="color-list">
                <li ng-repeat="itemColor in item.colores" class="color" ng-class="{ 'white': itemColor.rgba == 'rgba(255,255,255,1)' }" title="{{itemColor.nombre}}" ng-model="ga.temporal.idcolor" uib-btn-radio="'{{itemColor.idcolor}}'" ng-click="ga.cambiaColor(itemColor);"><div><div style="background-color: {{itemColor.rgba}}; width: 100%;"></div></div>
                </li>
              </ul>
              <div ng-if="item.si_genero == 1">
                <label class="minotaur-label block">{{ 'Text.GENERO' | translate }}</label>
                <label class="checkbox minotaur-radio minotaur-radio-sm"> {{ 'Text.HOMBRE' | translate }}
                  <input name="customRadio" type="radio" id="optionsRadios1{{item.idproductomaster}}"  ng-model="ga.temporal.genero" value="H">
                  <div class="input-indicator"></div>
                </label>
                <label class="checkbox minotaur-radio minotaur-radio-sm"> {{ 'Text.MUJER' | translate }}
                  <input name="customRadio" type="radio" id="optionsRadios2{{item.idproductomaster}}"  ng-model="ga.temporal.genero" value="M">
                  <div class="input-indicator"></div>
                </label>
              </div>
              <label class="minotaur-label block">{{item.tipo_medida}}</label>
              <div class="btn-group mb-5">
                <label ng-repeat="itemSize in ga.categoriaSel.medidas" class="btn btn-info" ng-model="ga.temporal.idproducto" uib-btn-radio="'{{itemSize.idproducto}}'" ng-click="ga.cambiaMedida(itemSize)">{{itemSize.denominacion}}</label>
              </div>
              <label class="minotaur-label block mt">{{ 'Text.CANTIDAD' | translate }}</label>
              <div touch-spin ng-model="ga.temporal.cantidad" options="{min: 1, max: 100}" ng-change="ga.cambiaCantidad()" class="text-right" style="width: 145px;"></div>
              <label class="minotaur-label block mt">{{ 'Text.PRECIO' | translate }}(US$)</label>
              <div class="input-group" style="min-height: 34px;width: 145px;">
                <span class="input-group-addon">US$</span>
                <input type="text" ng-model="ga.temporal.precio" class="text-right" ng-disabled="true" style="width: 100%"> <span class="input-group-addon">.00</span>
              </div>
              <label class="minotaur-label block mt">{{ 'Text.TOTAL' | translate }}(US$)</label>
              <div class="input-group" style="min-height: 34px;width: 145px;">
                <span class="input-group-addon">US$</span>
                <input type="text" ng-model="ga.temporal.total_detalle" class="text-right" ng-disabled="true" style="width: 100%"> <span class="input-group-addon">.00</span>
              </div>
            </div>
            <div class="col-md-3" style="min-height: 315px;">
              <label class="minotaur-label block" ng-show="item.tipo_seleccion == '1'">{{ 'Text.SELECCIONAR' | translate }}</label>
              <label class="minotaur-label block" ng-show="item.tipo_seleccion == '2'">{{ 'Text.SELECCIONE' | translate }} {{ga.temporal.size.cantidad_fotos}} {{ 'Text.FOTOGRAFIAS' | translate }}</label>
              <a href="" class="icon icon-primary icon-ef-3 icon-ef-3a hover-color" ng-click="ga.selectFotografia(item);"><i class="fa fa-image"></i></a>
              <div ng-if="ga.temporal.isSel && item.tipo_seleccion == '1'">
                <div>
                  <img class="img-responsive" ng-src="{{ga.temporal.imagen.src_thumb}}" alt="" style="width: 100px;">
                </div>
              </div>
              <div ng-if="ga.temporal.isSel && item.tipo_seleccion == '2'">
                <div class="m-xs inline-block" ng-repeat="image in ga.images | filter: { selected: true }">
                  <img class="img-responsive" ng-src="{{image.src_thumb}}" alt="" style="max-width: 80px;max-height: 53px;">
                </div>
              </div>
            </div>
            <button class="pull-right btn btn-primary btn-ef btn-ef-5 btn-ef-5b mb-10 mr-md" ng-click="ga.agregarItem(ga.temporal)"><i class="fa fa-shopping-cart"></i> <span>{{ 'Text.CESTA' | translate }}</span></button>
          </div>

        </uib-tab>
      </uib-tabset>
      <div class="col-md-12 col-sm-12 mt-lg" >
        <div ui-grid="ga.gridOptions" ui-grid-auto-resize class="grid table-responsive clear">
        </div>
      </div>
      <div class="form-inline col-md-12 col-sm-12 mt-lg text-right">
        <label class="control-label mr-xs text-info f-18" style="font-weight: bolder;"> {{ 'Text.IMPORTE' | translate }}</label>
        <div class="input-group mb-10">
          <span class="input-group-addon">US$</span> <input type="text" class="pull-right text-right f-18" ng-disabled="true" ng-model="ga.fData.total_pedido" style="width: 80px; font-weight: bolder;"/> <span class="input-group-addon">.00</span>
        </div>
      </div>
      <div class="form-inline col-md-12 col-sm-12 mt-xs text-right">
        <label class="control-label mr-xs text-info f-18" style="font-weight: bolder;"> {{ 'Text.SALDO_INICIAL' | translate }}</label>
        <div class="input-group mb-10">
          <span class="input-group-addon">US$</span> <input type="text" class="pull-right text-right f-18" ng-disabled="true" ng-model="ga.fData.saldo_inicial" style="width: 80px; font-weight: bolder;"/> <span class="input-group-addon">.00</span>
        </div>
      </div>
      <div class="form-inline col-md-12 col-sm-12 mt-xs text-right">
        <label class="control-label mr-xs text-info f-18" style="font-weight: bolder;">{{ 'Text.SALDO_FINAL' | translate }}</label>
        <div class="input-group mb-10">
          <span class="input-group-addon">US$</span> <input type="text" class="pull-right text-right f-18" ng-disabled="true" ng-model="ga.fData.saldo_final" style="width: 80px; font-weight: bolder;"/> <span class="input-group-addon">.00</span>
        </div>
      </div>
      <div class="form-inline col-md-12 col-sm-12 mt-xs text-right" ng-show="ga.fData.total_a_pagar > 0">
        <label class="control-label mr-xs text-info f-18" style="font-weight: bolder;"> {{ 'Text.TOTAL_PAGAR' | translate }}</label>
        <div class="input-group mb-10">
          <span class="input-group-addon">US$</span> <input type="text" class="pull-right text-right f-18" ng-disabled="true" ng-model="ga.fData.total_a_pagar" style="width: 80px; font-weight: bolder;"/> <span class="input-group-addon">.00</span>
        </div>
      </div>
      <div class="col-md-12 mt">
        <label class="checkbox minotaur-checkbox inline-block m-0 pull-right">He leído y acepto los <a href="javascript:;" ng-click="ga.btnTerminosCondiciones();" >Términos y Condiciones</a>
          <input type="checkbox" ng-model="ga.selectedTerminos"><div class="input-indicator"></div>
        </label>
      </div>
      <div class="col-md-12 mt">
        <button class="btn btn-success btn-ef btn-ef-5 btn-ef-5b mb-10 pull-right" ng-click="ga.btnPagar()"><i class="fa fa-dollar"></i> <span>{{ 'Text.PAGAR' | translate }}</span></button>
      </div>
    </div>
    <div class="row" ng-if="ga.pasarela" ng-include="'app/pages/mi-galeria/pasarela.php'"> </div>

  </section>
</div>
<div class="tile p-15" style="min-height: 400px;" ng-show="ga.modoDescargaCompleta">
  <section class="tile-header pl-0">
    <h1 class="heading">{{ 'Text.COMPRA_EXITOSA' | translate }}</h1>
  </section>
  <div class="row">
    <div class="col-md-12 col-sm-12">
      <h2 class="text-custom text-center mb-5">{{ 'Text.GRACIAS' | translate }}</h2>
      <h3 ng-if="!ga.modoCalificacionOk" class="text-custom text-center text-cyan mt-0">{{ 'Text.CALIFICA' | translate }}</h3>
      <h3 ng-if="ga.modoCalificacionOk" class="text-custom text-center text-cyan mt-0">{{ 'Text.GRACIAS_CALIFICA' | translate }}</h3>
      <div class="rating-stars" ng-if="!ga.modoCalificacionOk" >
        <span ng-click="ga.calificar(5);" >☆</span>
        <span ng-click="ga.calificar(4);">☆</span>
        <span ng-click="ga.calificar(3);">☆</span>
        <span ng-click="ga.calificar(2);">☆</span>
        <span ng-click="ga.calificar(1);">☆</span>
      </div>
      <div class="rating-stars-calificado" ng-if="ga.modoCalificacionOk" >
        <span ng-class="{'califica': 1 <= ga.calificacion}">★</span>
        <span ng-class="{'califica': 2 <= ga.calificacion}">★</span>
        <span ng-class="{'califica': 3 <= ga.calificacion}">★</span>
        <span ng-class="{'califica': 4 <= ga.calificacion}">★</span>
        <span ng-class="{'califica': 5 == ga.calificacion}">★</span>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="rating-stars-calificado" style="width: 260px">
        <div class="row m">
          <div class="col-sm-6 text-lg text-orange dk b-a b-cyan br-10">★★★★★</div><label class="col-sm-6 text-left bold mt-xs">{{ 'Text.EXCELENTE' | translate }}</label>
        </div>
        <div class="row m">
          <div class="col-sm-6 text-lg text-orange dk b-a b-cyan br-10">★★★★</div><label class="col-sm-6 text-left bold mt-xs">{{ 'Text.BUENO' | translate }}</label>
        </div>
        <div class="row m">
          <div class="col-sm-6 text-lg text-orange dk b-a b-cyan br-10">★★★</div><label class="col-sm-6 text-left bold mt-xs">{{ 'Text.REGULAR' | translate }}</label>
        </div>
        <div class="row m">
          <div class="col-sm-6 text-lg text-orange dk b-a b-cyan br-10">★★</div><label class="col-sm-6 text-left bold mt-xs">{{ 'Text.MALO' | translate }}</label>
        </div>
        <div class="row m">
          <div class="col-sm-6 text-lg text-orange dk b-a b-cyan br-10">★</div><label class="col-sm-6 text-left bold mt-xs">{{ 'Text.MUY_MALO' | translate }}</label>
        </div>
    </div>
  </div>
</div>