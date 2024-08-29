<div class="" ng-init='sid=<?=$sid;?>'>
  <!-- <h1>Survey Manager</h1> -->
  <div class="s_title" ng-repeat="(k, v) in survey" ng-if="v.fbkid==sid">
    <h4>{{v.etitle}}</h4><div>{{v.btitle}}</div><div>{{v.detail}}</div>
  </div>
  <div class="row">
    <div class="col_12">
      <div class="qlist">
        <div class="numq" ng-class="{curnt : n+0<=curent+0}" ng-repeat="n in nques" ng-click="setCurrent(n)">
          <i>{{n}}</i>
        </div>
      </div>
    </div>
    <div class="col_12 col">
      <div class="ques" ng-repeat="(k, v) in ques" ng-if="$index==curent-1">
        <h4>{{$index+1}}. {{v.etitle}}</h4>
        <div ng-if="v.btitle">{{v.btitle}}</div><div ng-if='v.detail'>{{v.detail}}</div>
        <div class="" ng-if="v.cenble=='T'">
          <textarea name="name" rows="8" cols="80" ng-model="comment[k]"></textarea>
        </div>
        <div class="" ng-repeat="(sk, o) in opts" ng-if="v.cenble=='F'">
          <label><input type="radio" name="options_{{k}}" value="{{sk+1}}" ng-model='options[k]'> {{o}}</label>
        </div>
        <br>
        <button ng-click="saveChoice(k)" class="btn btn-primary nxt">Next</button>
      </div>
      <div class="thnks" ng-if="curent>numques">
        <h1>Thank you</h1>
      </div>
    </div>
  </div>
</div>
