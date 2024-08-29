<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<div class="" ng-init='loadSurvey()'>
  <h1>Survey Answer</h1>
  <div class="row">
    <div class="col-4">
      <div class="sev_list">
        <div class="" ng-repeat='(k, v) in survey' ng-click="selectSurvey(v.fbkid)">
          <h6>{{$index+1}}. {{v.etitle}}</h6>
          <div ng-if="selSur==v.fbkid">{{v.btitle}}</div>
          <div class="" ng-if="selSur==v.fbkid">
            {{v.detail}}<br>
            <a href="<?= base_url(); ?>admin/xslsurv/{{v.fbkid}}" class="btn btn-primary">Export</a>
          </div>
        </div>
      </div>
      <div class="sev_qus_list" ng-if='serLoad!=-1'>
        <div class="" ng-repeat="(k, v) in ans.qus">
          <h6 ng-if="v.title.e" ng-click="loadGraph(k)">{{$index+1}}. {{v.title.e}}</h6>
        </div>
      </div>
    </div>
    <div class="col-8">
      <div class="" ng-repeat="(k, v) in ans.qus" ng-if="k==selQus">
        <h5 ng-if="v.title.e">{{v.title.e}}</h5>
        <a href="#image_div">Save Image</a>
      </div>
      <div id="chart_div"></div>
      <div id="image_div" style=" border: thin solid gray"></div>
      <h5 class="" style="float: right; font-size: 1.2em;">
        Right click on image and press "Save image as.."
      </h5>
      <div class="" ng-repeat="(k, v) in ans.com">
        <h6 ng-if="v.title.e">{{v.title.e}}</h6>
        <!-- <h6 ng-if="v.title.b">{{v.title.b}}</h6> -->
        <ul class="">
          <li ng-repeat="sv in v.txt" ng-if="sv">{{sv}}</li>
        </ul>
        <!-- <div id="chart_div"></div> -->
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  // Load the Visualization API and the corechart package.
</script>