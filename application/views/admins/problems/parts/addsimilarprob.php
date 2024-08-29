<h5 class="text-center pb-3">Add Similar problem</h5>
<div class="row">
  <div class="col-4">
    <div>Lesson Title</div>
    <select class="form-control" ng-model='eless' ng-change="setLesson(eless)">
      <option ng-repeat='(k, v) in problemlist' value="{{k}}">{{v.title}}</option>
    </select>
    <div class="pt-3">Problem Title</div>
    <select class="form-control" ng-model='eprob' ng-click="setProblem(eprob)">
      <option class="link" ng-repeat='(k, v) in problemlist[selLesson].prob' value="{{k}}">{{v.title}}</option>
    </select>
    <h6 class="pt-3">Similar Problem List</h6>
    <ul class="list-group">
      <li class="list-group-item" ng-class="{selected : selSimilar==k}" ng-repeat='(k, v) in pdts.sprob' ng-click='loadSimilarContent(k)'>
        {{v.details | limitTo: 96}} ...
      </li>
      <ul>
  </div>
  <div class="col-8 col">
    <div class="row">
      <div class="col-12"><label class="pt-3 fs-6" for="">Description:</label></div>
      <div class="col-12"><textarea class="form-control" name="name" rows="8" ng-model='spDetail'></textarea></div>
      <div class="col-8"><label class="pt-3 fs-6" for="">Solution:</label>
        <label class="fs-6 fw-bolder py-3 text-primary" for="senbs"><input type="checkbox" class="form-check-input" ng-model='senbs' id='senbs'> Check to show solution</label>
      </div>
      <div class="col-12   d-flex">
        <textarea class="form-control" name="name" rows="4" cols="80" ng-model='spSolution' ng-change='analyzeStatement(spSolution)'></textarea>
        <div class="pt-4 px-3"><button class="btn btn-primary" ng-click="executeQuery(spSolution)">Run</button></div>
      </div>
      <div class="col-12 output px-0 w-100">
        <h6>Output</h6>
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
      <div class="col-12 text-end pt-3"><button class="btn btn-primary" ng-click='saveSimProblemData(spDetail, spSolution, 0, senbs)'>Update</button>
        <button class="btn btn-primary" ng-click='saveSimProblemData(spDetail, spSolution, 1, senbs)'>Save</button>
      </div>
    </div>
  </div>
</div>