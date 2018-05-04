<div class="modal-header">
  <button class="btn btn-sm btn-default btn-border text-white pull-right" ng-click="mcv.cancel()">X</button>
</div>
<div class="modal-body">
  <div style="text-align: center;">
    <video controls src="{{mcv.fData.src}}" width="720" height="580" poster="{{mcv.fData.src_image}}">
        Tu navegador no admite el elemento <code>video</code>.
    </video>
  </div>
</div>
