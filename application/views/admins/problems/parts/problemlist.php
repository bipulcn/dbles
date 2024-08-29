<div class="row">
  <div class="col-3">
    <h6 class="">Lab/Lesson List </h6>
    <ul class="list-group">
      <li class="list-group-item" ng-repeat='(k, v) in problemlist' ng-click="setLesson(k)" ng-class="{selected : selLesson==k}">
        {{v.title}}
      </li>
    </ul>
  </div>
  <div class="col-3">
    <h6 class="xcol">Problem List </h6>
    <ul class="list-group">
      <li class="list-group-item" ng-repeat='(k, v) in problemlist[selLesson].prob' ng-click="setProblem(k)" ng-class="{selected : selProblem==k}">
        {{v.title}}
      </li>
    </ul>
  </div>
  <div class="col-6 col">
    <h4 class="py-3">{{pdts.title}}</h4>
    <div class="">
      {{pdts.details}}
    </div>
    <div class="">
      {{pdts.solution}}
    </div>
    <button class="btn btn-primary my-3" ng-if='selProblem>=0' ng-click="enableToEdit()">Update</button>
    <button class="btn btn-primary my-3" ng-if='selProblem>=0' ng-click="deleteProblem(pdts.pid, -1)">Delete</button>
    <h5 ng-if='pdts'>Similar Problems</h5>
    <ol type="1">
      <li class="" ng-repeat='(k, v) in pdts.sprob'>
        <div>{{v.details}}</div>
        <div>{{v.solution}}</div>
        <button class="btn btn-primary my-3" ng-if='selProblem>=0' ng-click="deleteProblem(pdts.pid, v.spid)">Delete</button>
      </li>
    </ol>
  </div>
</div>