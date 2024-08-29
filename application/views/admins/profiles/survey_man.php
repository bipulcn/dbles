<div class="" ng-init='loadSurvey()'>
  <h1>Survey Manager</h1>
  <div class="row">
    <div class="col-6">
      <div class="sev_list">
        <h3>Survey List</h3>
        <div class="" ng-repeat='(k, v) in survey' ng-click="selectSurvey(v.fbkid)" ng-if="selSur=='' || selSur==v.fbkid">
          <h6>{{$index+1}}. {{v.etitle}}</h6>
          <div ng-if="selSur==v.fbkid">{{v.btitle}}</div>
          <div class="" ng-if="selSur==v.fbkid">
            {{v.detail}}
          </div>
        </div>
      </div>
      <div class="qus_list" ng-if="selSur">
        <h3>Survey Questions</h3>
        <div class='que_styl' ng-class="{selected:selQus==v.fbqid}" ng-repeat='(k, v) in qus[selSur]' ng-click="selectQuestion(v.fbqid)">
          <h6>{{$index+1}}. {{v.etitle}}</h6>
          <div>{{v.btitle}}</div>
          <div class="">
            {{v.detail}}
          </div>
        </div>
      </div>
      <!-- <div class="">
        <h3>Survey Question answers</h3>
        <div class="" ng-repeat='(k, v) in ans'>
          <h5>{{$index+1}}</h5>
          <div class="">
            {{v.uid}}
          </div>
        </div>
      </div> -->
    </div>
    <div class="col-6">
      <div class="form_set">
        <h4>Forms</h4>
        <div class="py-3">
          <button class="btn btn-primary" ng-click="selectSurvey('')">Add Survey</button>
          <button class="btn btn-primary" ng-click="selectQuestion(0)" ng-if="selSur">Add Question</button>
        </div>
        <div class="SurveyName" ng-if="enbAE">
          <h5 class="mb-3">Survey Details</h5>
          <label class="mt-1">Survey Title in English</label><br>
          <input type="text" class="form-control" name='etitle' value="etitle" placeholder="Input text" ng-model='sv_etitle'><br>
          <label class="mt-1">Survey Title in Bangla</label><br>
          <input type="text" class="form-control" name='btitle' value="btitle" placeholder="Input text" ng-model='sv_btitle'><br>
          <label class="mt-1">Survey Details</label><br>
          <textarea class="form-control" for='sv_enable' ng-model='sv_detail'></textarea><br>
          <label class="my-1" for="sv_enable"><input type="checkbox" ng-model='sv_enable' id="sv_enable"> Enable </label><br>
          <button class='btn btn-primary mt-3' ng-click='saveSurvey(0, sv_etitle, sv_btitle, sv_detail, sv_enable)'>Save</button>
          <button class='btn btn-primary mt-3' ng-click='saveSurvey(1, sv_etitle, sv_btitle, sv_detail, sv_enable)' ng-if="selSur">Update</button>
        </div>
        <div class="surveyQues" ng-if="selSur &&  !enbAE">
          <div class="srv_info">
            <h3>{{sv_etitle}}</h3>
            <h6>{{sv_btitle}}</h6>
            <div>{{sv_detail}}</div>
          </div>
          <h5 class="mb-3">Questions:</h5>
          <label class="mt-1">Question Title in English</label><br>
          <input type="text" class="form-control" name='etitle' value="etitle" placeholder="Input text" ng-model='qs_etitle'><br>
          <label class="mt-1">Question Title in Bangla</label><br>
          <input type="text" class="form-control" name='btitle' value="btitle" placeholder="Input text" ng-model='qs_btitle'><br>
          <label class="mt-1">Question details</label><br>
          <input type="text" class="form-control" name='detail' value="detail" placeholder="Input text" ng-model='qs_detail'><br>
          <label class="my-1" for="sv_enable" for='qs_enable'><input type="checkbox" class="form-check-input" ng-model='qs_enable' id="qs_enable"> Enable to get comment from user.</label><br>
          <!-- <input type="checkbox" ng-model='qs_coment'> -->
          <button class='btn btn-primary mt-3' ng-click='saveSurveyQuestions(0, qs_etitle, qs_btitle, qs_detail, qs_enable)'> Save </button>
          <button class='btn btn-primary mt-3' ng-click='saveSurveyQuestions(1, qs_etitle, qs_btitle, qs_detail, qs_enable)' ng-if="selQus"> Update </button>
        </div>
      </div>
    </div>
  </div>

</div>
