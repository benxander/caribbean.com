<ul data-ng-style="{'max-width':'5120px'}">
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
      width="5120"
      height="1280"
      data-bgposition="center center"
      data-bgfit="cover"

      data-bgrepeat="no-repeat"
      data-kenburns="on"
      data-duration="10000" data-scalestart="100" data-scaleend="102"
      data-offsetstart = "-200 100"
      data-offsetend = "200 100"

      data-ease="Power4.easeInOut"
      data-bgparallax="10"
      class="rev-slidebg"
      data-no-retina>

    <!-- LAYER NR. 1 -->
    <a ng-if="slide.acepta_texto == 1 " class="tp-caption News-Title tp-resizeme rs-parallaxlevel-0"
      data-ui-sref=""
      id="slide-{{slide.idbanner}}-layer-1"
      data-x="['{{slide.capas[0].data_x}}','{{slide.capas[0].data_x}}','{{slide.capas[0].data_x}}','{{slide.capas[0].data_x}}']"
      data-hoffset="['{{slide.capas[0].offset_horizontal}}','{{slide.capas[0].offset_horizontal}}','{{slide.capas[0].offset_horizontal}}','{{slide.capas[0].offset_horizontal}}']"
      data-y="['{{slide.capas[0].data_y}}','{{slide.capas[0].data_y}}','{{slide.capas[0].data_y}}','{{slide.capas[0].data_y}}']"
      data-voffset="['{{slide.capas[0].offset_vertical}}','{{slide.capas[0].offset_vertical2}}','{{slide.capas[0].offset_vertical3}}','{{slide.capas[0].offset_vertical4}}']"
      data-width="['{{slide.capas[0].data_width}}px','{{slide.capas[0].data_width2}}px','{{slide.capas[0].data_width3}}px','{{slide.capas[0].data_width4}}px']"
      data-height="['auto']"
      data-whitespace="normal"
      data-fontsize="['{{slide.capas[0].fontsize}}', '{{slide.capas[0].fontsize2}}', '{{slide.capas[0].fontsize3}}', '{{slide.capas[0].fontsize4}}']"
      data-lineheight="['{{slide.capas[0].line_height}}', '{{slide.capas[0].line_height2}}', '{{slide.capas[0].line_height3}}', '{{slide.capas[0].line_height4}}']"
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
      'min-width':'auto',
      'min-height':'auto',
      'white-space':'normal',
      'max-width':'auto',
      'max-height':'auto',

      'line-height':'{{slide.capas[0].line_height}}px',
      'font-weight':'400',
      'color':'{{slide.capas[0].color}}',
      'font-family':'Roboto Slab',
      'padding':'0 0 0 0',
      'border-radius':'0 0 0 0'
      }">
      {{slide.capas[0].texto}}
    </a>

    <!-- LAYER NR. 2 -->


    <!-- LAYER NR. 3 -->
    <a ng-if="slide.acepta_texto == 1 " class="tp-caption News-Subtitle tp-resizeme rs-parallaxlevel-0"
      data-ui-sref=""
      id="slide-{{slide.idbanner}}-layer-3"
      data-x="['{{slide.capas[1].data_x}}','{{slide.capas[1].data_x}}','{{slide.capas[1].data_x}}','{{slide.capas[1].data_x}}']"
      data-hoffset="[{{slide.capas[1].offset_horizontal}}]"
      data-y="['{{slide.capas[1].data_y}}','{{slide.capas[1].data_y}}','{{slide.capas[1].data_y}}','{{slide.capas[1].data_y}}']"
      data-voffset="['{{slide.capas[1].offset_vertical}}','{{slide.capas[1].offset_vertical2}}','{{slide.capas[1].offset_vertical3}}','{{slide.capas[1].offset_vertical4}}']"
      data-width="['{{slide.capas[1].data_width}}px','{{slide.capas[1].data_width2}}px','{{slide.capas[1].data_width3}}px','{{slide.capas[1].data_width4}}px']"
      data-height="none"
      data-whitespace="normal"
      data-fontsize="['{{slide.capas[1].fontsize}}', '{{slide.capas[1].fontsize2}}', '{{slide.capas[1].fontsize3}}', '{{slide.capas[1].fontsize4}}']"
      data-lineheight="['{{slide.capas[1].line_height}}', '{{slide.capas[1].line_height2}}', '{{slide.capas[1].line_height3}}', '{{slide.capas[1].line_height4}}']"
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
      'white-space':'normal',
      'max-width':'auto',
      'max-height':'auto',
      'font-size':'{{slide.capas[1].fontsize}}px',
      'line-height':'{{slide.capas[1].line_height}}px',
      'font-weight':'300',
      'color':'{{slide.capas[1].color}}',
      'font-family':'Roboto Slab',
      'background-color':'rgba(255, 255, 255, 0)',
      'padding':'0 0 0 0',
      'border-radius':'0 0 0 0'
      }">
      {{slide.capas[1].texto}}
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