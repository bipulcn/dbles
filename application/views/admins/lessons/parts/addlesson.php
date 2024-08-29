<h5 class="col">Add Lessons</h5>
<div class="row">
  <div class="col-2">
    <h6 class="col">Lessons</h6>
    <ul class="list-group" ng-init="sellesson=-1">
      <li class="list-group-item" ng-repeat='(k, v) in lessonlist' ng-click="setlessonToEdit(k)">{{v.dt.title}}</li>
    </ul>
  </div>
  <div class="col-10 col">
    <div class="row">
      <div class="col-12 pt-3"><label for="">Lesson Title</label>
        <input class="form-control" type="text" ng-model='lesTitle'>
      </div>
      <div class="col-12 pt-3"><label for="">Lesson Description:</label>
      <textarea class="form-control" name="name" rows="8" ng-model='lesDescription'></textarea></div>
      <div class="col-2 pt-3"><label class="py-2" for="">Level (Complexity)</label></div>
      <div class="col-5 pt-3"><input class="form-control" type="text" ng-model='lesLevel' placeholder="1"></div>
      <div class="col-5 pt-3">
        <button class="btn btn-primary" type="button" name="button" ng-click="saveLessons(lesLevel, lesTitle, lesDescription, -1)">Save New</button>
        <button class="btn btn-primary" type="button" name="button" ng-click="saveLessons(lesLevel, lesTitle, lesDescription, sellesson)">Update Old</button>
      </div>
    </div>
  </div>
</div>