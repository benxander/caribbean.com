<ul data-ng-style="{'max-width':'1920px'}">
  <!-- SLIDE  -->
  <li ng-repeat="slide in slides"
    data-index="rs-{{slide.idbanner}}"
    data-transition="fade"
    data-easein="default"
    data-easeout="default"
    data-thumb=""
    data-title="{{slide.titulo}}"
    data-description="">

    <!-- MAIN IMAGE -->
    <img
      ng-src="{{slide.imagen}}"
      alt=""
      width="1920"
      height="1280"
      data-bgposition="center top"
      data-bgfit="cover"
      data-bgrepeat="no-repeat"
      data-kenburns="on"
      data-duration="10000" data-scalestart="100" data-scaleend="120"
      data-ease="Power4.easeInOut"
      data-bgparallax="10"
      class="rev-slidebg"
      data-no-retina>

    <!-- LAYER NR. 1 -->
    <a class="tp-caption News-Title tp-resizeme rs-parallaxlevel-0"
      data-ui-sref=""
      id="slide-{{slide.idbanner}}-layer-1"
      data-x="['left','left','left','left']"
      data-hoffset="['80','80','40','40']"
      data-y="['top','top','top','top']"
      data-voffset="['450','450','250','150']"
      data-width="564"
      data-height="133"
      data-whitespace="normal"
      data-transform_idle="o:1;"
      data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1500;e:Power3.easeInOut;"
      data-transform_out="y:[100%];s:1000;s:1000;"
      data-mask_in="x:0px;y:0px;s:inherit;e:inherit;"
      data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;"
      data-start="500"
      data-splitin="none"
      data-splitout="none"
      data-responsive_offset="on"
      data-ng-style="{
      'z-index':'5',
      'min-width':'364px',
      'min-height':'133px',
      'white-space':'normal',
      'max-width':'564px',
      'max-height':'133px',
      'font-size':'{{slide.size_titulo}}px',
      'line-height':'60px',
      'font-weight':'400',
      'color':'{{slide.color_titulo}}',
      'font-family':'Roboto Slab',
      'padding':'0 0 0 0',
      'border-radius':'0 0 0 0'
      }">
      {{slide.titulo}}
    </a>

    <!-- LAYER NR. 2 -->


    <!-- LAYER NR. 3 -->
    <a class="tp-caption News-Subtitle tp-resizeme rs-parallaxlevel-0"
      data-ui-sref="frontPage.services.spc"
      id="slide-{{slide.idbanner}}-layer-3"
      data-x="['left','left','left','left']"
      data-hoffset="['81','81','41','41']"
      data-y="['top','top','top','top']"
      data-voffset="['605','605','401','301']"
      data-width="none"
      data-height="none"
      data-whitespace="nowrap"
      data-transform_idle="o:1;"
      data-transform_hover="o:1;rX:0;rY:0;rZ:0;z:0;s:300;e:Power3.easeInOut;"
      data-style_hover="c:rgba(255, 255, 255, 0.65);br:0 0 0px 0;cursor:pointer;"
      data-transform_in="y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1500;e:Power3.easeInOut;"
      data-transform_out="y:[100%];s:1000;s:1000;"
      data-mask_in="x:0px;y:0px;"
      data-mask_out="x:inherit;y:inherit;"
      data-start="500"
      data-splitin="none"
      data-splitout="none"
      data-responsive_offset="on"
      data-ng-style="{
      'z-index':'7',
      'min-width':'auto',
      'min-height':'auto',
      'white-space':'nowrap',
      'max-width':'auto',
      'max-height':'auto',
      'font-size':'{{slide.size_subtitulo}}px',
      'line-height':'24px',
      'font-weight':'300',
      'color':'{{slide.color_subtitulo}}',
      'font-family':'Roboto Slab',
      'background-color':'rgba(255, 255, 255, 0)',
      'padding':'0 0 0 0',
      'border-radius':'0 0 0 0'
      }">
      {{slide.subtitulo}}
    </a>

    <!-- LAYER NR. 4 -->
    <div ng-show="false" class="tp-caption - tp-resizeme rs-parallaxlevel-0"
      id="slide-{{slide.idbanner}}-layer-4"
      data-x="['left','left','left','left']"
      data-hoffset="['463','463','443','443']"
      data-y="['top','top','top','top']"
      data-voffset="['607','607','403','303']"
      data-width="none"
      data-height="none"
      data-whitespace="nowrap"
      data-transform_idle="o:1;"
      data-transform_in="x:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1500;e:Power3.easeInOut;"
      data-transform_out="x:[100%];s:1000;e:Power3.easeInOut;s:1000;e:Power3.easeInOut;"
      data-mask_in="x:0px;y:0px;s:inherit;e:inherit;"
      data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;"
      data-start="500"
      data-splitin="none"
      data-splitout="none"
      data-responsive_offset="on"
      data-ng-style="{
      'z-index':'8',
      'min-width':'auto',
      'min-height':'auto',
      'white-space':'nowrap',
      'max-width':'auto',
      'max-height':'auto',
      'font-size':'20px',
      'line-height':'22px',
      'font-weight':'400',
      'color':'rgba(0, 210, 255, 1.00)',
      'padding':'0 0 0 0',
      'border-radius':'0 0 0 0'
      }">
      <i class="fa fa-caret-right"></i>
    </div>
  </li>


</ul>
<div class="tp-bannertimer tp-bottom" style="visibility: hidden !important;"></div>