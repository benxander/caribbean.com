<div class="modal-header">
  <button class="btn btn-sm btn-default btn-border text-white pull-right" ng-click="mv.cancel()">X</button>
</div>
<div class="modal-body">

  <div style="text-align: center;">
    <video controls src="{{mv.fData.video}}" width="720" height="580" poster="{{mv.fData.video}}">
        Tu navegador no admite el elemento <code>video</code>.
    </video>
  </div>
</div>