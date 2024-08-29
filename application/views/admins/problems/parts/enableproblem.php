<div class="row" ng-init="loadGroup()">
  <div class="col-3">
    <h6 class="py-3">Student Group List </h6>
    <div>
      <div class="border p-2" ng-class="{selected : gky==k}" ng-repeat="(k, v) in group" ng-click='setKey(k)'>{{v.groupname}}</div>
    </div>
  </div>
  <div class="col-3">
      <div ng-if="gky!=-1" >
        <h5 class="px-0 mt-3">{{group[gky].groupname}}</h5>
        <div>{{group[gky].description}}</div>
        <h6>Number of Members: {{group[gky].memb}}</h6>
      </div>
  </div>
  <div class="col-6 col">
    <div ng-if="gky!=-1" >
      <h6 class="xcol">Lab/Lesson List </h6>
      <ul class="list-group" type="I">
        <li class="list-group-item" ng-repeat='(k, v) in problemlist' ng-click="enableList(k)" ng-class="{selected : pbids[k]}">
          {{v.title}}
        </li>
      </ul>
      <button class="btn btn-primary my-3 float-end" ng-click='saveEanbled()'>Save</button>
    </div>
  </div>
</div>
