<h5 class="col">Add Lesson Objectives</h5>
<div class="row">
  <div class="col-2">
    <h6 class="col">List Lessons</h6>
    <ul class="list-group" ng-init="sellesson=-1">
      <li class="list-group-item" ng-repeat='(k, v) in lessonlist' ng-click="setlesson(k)">{{v.dt.title}}</li>
    </ul>
  </div>
  <div class="col-5">
    <h6 class="col">Objective for Problem <b>{{lessonlist[sellesson].dt.title}}</b></h6>
    <div class="">
      <ul class="list-group">
        <li class="list-group-item" ng-click="setObjective(-1)">New</li>
        <li class="list-group-item" ng-repeat="v in lessonlist[sellesson].objc" ng-click="setObjective(v.obid)">{{v.title}}</li>
      </ul>
    </div>
  </div>
  <div class="col-5 col">
    <div class="row" ng-show="sellesson!=-1">
    <div class="col-12 pt-3"><label for="">Objective</label>
    <input class="form-control" type="text" ng-model="lesObjective"></div>
    <div class="col-2 pt-3"><label class="pt-2" for="">Order</label></div>
    <div class="col-6 pt-3"><input class="form-control" type="number" ng-model="lesObOrder"></div>
    <div class="col-4 pt-3 text-end"><button class="btn btn-primary" type="button" ng-click="addObjective(lesObjective, lesObOrder, sellesson, selObject)">Save</button></div>
  </div></div>
</div>
