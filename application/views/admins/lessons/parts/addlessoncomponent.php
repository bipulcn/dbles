<h5 class="col">Lesson Components Manage</h5>
<div class="row">
  <div class="col-2">
    <h6 class="col">List Lessons</h6>
    <ul class="list-group" ng-init="sellesson=-1">
      <li class="list-group-item" ng-repeat='(k, v) in lessonlist' ng-click="setlesson(k)">{{v.dt.title}}</li>
    </ul>
  </div>
  <div class="col-5">
    <h6 class="col">Lesson Components List</h6>
    <ul class="list-group">
      <li class="list-group-item" ng-click="setComponent(-1)">New</li>
      <li class="list-group-item" ng-repeat="v in lessonlist[sellesson].cont" ng-click="setComponent(v.ltid)"><b>{{v.type}}</b>
        <div class="">
          {{v.detail}}
        </div>
      </li>
    </ul>
  </div>
  <div class="col-5 col"><div class="row" ng-show="sellesson!=-1">
    <h4 class="col-12" for="">Lession title</h4>
    <div class="col-6 pt-3">
      <label for="">Type of content:</label>
      <select class="form-control" ng-model="comType">
        <option value="text">Text</option>
        <option value="heading">Heading</option>
        <option value="list">List</option>
      </select>
    </div><div class="col-6 pt-3">
      <label for="">Order</label>
      <input class="form-control" type="number" ng-model="comOrder" size="5"><br>
    </div><div class="col-12 pt-3" ng-show="comType=='heading'">
      <label for="">Heading</label>
      <input class="form-control" type="text" ng-model="comCont">
    </div><div class="col-12 pt-3" ng-show="comType=='text'">
      <label for="">Description:</label>
      <textarea class="form-control" name="name" rows="8" cols="80" ng-model="comCont"></textarea>
    </div><div class="col-12 pt-3" ng-show="comType=='list'">
      <label for="">List:</label>
      <input class="form-control" type="text" ng-model="comCont">
    </div><div class="col-12 pt-3">
      <button class="btn btn-primary" type="button" ng-click="addLesCompnt(comType, comCont, comOrder, sellesson, selcomp)">Save</button>
    </div>
  </div></div>
</div>
