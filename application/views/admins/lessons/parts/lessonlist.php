<h5 class="col">Lesson Manage</h5>
<div class="row">
  <div class="col-2">
    <h6 class="col">List Lessons</h6>
    <ul class="list-group" ng-init="sellesson=-1">
      <li class="list-group-item" ng-repeat='(k, v) in lessonlist' ng-click="setlesson(k)">{{v.dt.title}}</li>
    </ul>
  </div>
  <div class="col-10 col">
    <div class="" ng-if="sellesson!=-1">
      <h4>{{lessonlist[sellesson].dt.title}}</h4>
      <div>{{lessonlist[sellesson].dt.details}}</div> 
      <button class="btn btn-primary my-3" ng-click="setlessonToEdit(sellesson)">Update</button>
      <div class="row">
        <div class="col-12 col-md-6">
          <h5>Objectives</h5>
          <div class="">
            <ul class="list-group">
              <li class="list-group-item" ng-repeat="v in lessonlist[sellesson].objc">{{v.title}}</li>
            </ul>
          </div>
        </div>
        <div class="col-12 col-md-6">
          <h5>Lesson Details</h5>
          <div class="">
            {{lessonlist[sellesson].dt.details}}
            <ul class="list-group">
              <li class="list-group-item" ng-repeat="v in lessonlist[sellesson].cont"><b>{{v.Type}}</b>
                <div class="">
                  {{v.detail}}
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>