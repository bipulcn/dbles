<h5 class="text-center pb-3">Add Parent problem</h5>
<div class="row">
  <div class="col-4">
    <select class="form-control" ng-model='eless' ng-change="setLesson(eless)">
      <option ng-repeat='(k, v) in problemlist' value="{{k}}" >{{v.title}}</option>
    </select>
    <h5 ng-if="selLesson>=0" class="border-top mt-3">{{problemlist[selLesson].title}}</h5>
    <ul class="list-group">
      <li class="list-group-item" ng-repeat='(k, v) in problemlist[selLesson].prob' ng-click="setProblemToEdit(k)" ng-class="{selected : selProblem==k}">{{v.title}}</li>
    </ul>
  </div>
  <div class="col-8">
    <div class="row">
      <div class="col-12">
        <label class="pt-3 fs-6" for="">Problem Title</label>
      </div>
      <div class="col-12">
        <input type="text" class="form-control" ng-model='pobtitle'>
      </div>
      <div class="col-12">
        <label class="pt-3 fs-6" for="">Problem Description:</label>
      </div>
      <div class="col-12">
        <textarea class="form-control" class="form-control" name="name" rows="8" cols="80" ng-model='pobDesc'></textarea>
      </div>
      <div class="col-12">
        <label class="pt-3 fs-6" for="">Problem Solution:</label>
        <label class="py-3 fs-6 text-primary fw-bolder" for="senbs"><input type="checkbox" class="form-check-input" ng-model='senbs' name='senbs' id="senbs">  Check to show solution</label>
      </div>
      <div class="col-12 d-flex">
        <textarea class="form-control" name="name" rows="4" ng-model='pobSolut' ng-change='analyzeStatement(pobSolut)'></textarea>
        <div class="pt-4 px-3"><button class="btn btn-primary" ng-click="executeQuery(pobSolut)">Run</button></div>
      </div>
      <div class="col-12 output w-100 px-0">
        <h6 class="px-3">Output</h6>
        <div class="outputContent">
          <table class="dbtable">
            <tr>
              <th ng-repeat='dv in outputTab.field'>{{dv}}</th>
            </tr>
            <tr ng-repeat='dv in outputTab.data'>
              <td ng-repeat='df in outputTab.field'>{{dv[df]}}</td>
            </tr>
          </table>
          <div class="error" ng-bind-html="queryError"></div>
        </div>
      </div>
      <div class="col-12">
        <button class="btn btn-primary mt-3 float-end mx-3" ng-click='saveProblemData(pobtitle, pobDesc, pobSolut, senbs, 0)' ng-show='selProblem>=0'>Update</button>
        <button class="btn btn-primary mt-3 float-end" ng-click='saveProblemData(pobtitle, pobDesc, pobSolut, senbs, 1)'>Save</button>
      </div>
    </div>
  </div>
</div>
</div>