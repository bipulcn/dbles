<div class="row hf" ng-init="loadLessons()">
	<div class="col_12 col">
		<h1>Problem Base Lessons</h1>
    <div class="" ng-repeat="(k, v) in lessonlist">
      <h4 class="btn btn-danger" style="max-width:200px;">{{v.data.title}}</h4>
      <div class="col_8">{{v.data.details}}</div>
    </div>
    <div class="row">
      <div class="col_2">
        <div class="" ng-repeat="(k, v) in problemlist">
          <h5>{{v.title}}</h5>
        </div>
      </div>
      <div class="col_10">
        <div class="" ng-repeat="(k, v) in schema">
          <h4 class="btn btn-danger">{{k}}</h4><div>{{v.detail}}</div>
          <div class="row">
            <div class="col_1 btn" ng-repeat="(y, s) in v.data" ng-click="loadTabInfo(s.tname)">{{s.tname}}</div>
          </div>
        </div>
    		<h4>Code</h4>
    		<div class="row">
    			<div class="col_8">
    				<textarea name="name" class="sql_cod_box" ng-model='mod_query_code' ng-change='analyzeStatement()'></textarea>
    			</div>
    			<div class="col_4">
    				<ul>
    					<li ng-repeat='(k, v) in queryTypes'>{{v}}</li>
    				</ul>
    				<button class="btn btn-danger" ng-click="executeQuery()">Run</button>
    			</div>
    		</div>
        <div class="row">
      		<div class="col_6 output">
      			<h6>Output</h6>
      			<table width='100%'>
      				<tr>
      					<th ng-repeat='(k, v) in outputTab.field' style="text-align: left;">{{v}}</th>
      				</tr>
      				<tr ng-repeat='(k, v) in outputTab.data'>
      					<td ng-repeat='(sk, f) in outputTab.field'>{{v[f]}}</td>
      				</tr>
      			</table>
      			<div class="error" ng-bind-html="queryError"></div>
      		</div>
      		<div class="col_6 output">
      			<h6>Results</h6>{{}}
      			<table width='100%'>
      				<tr>
      					<th ng-repeat='(k, v) in descTab.field' style="text-align: left;">{{v}}</th>
      				</tr>
      				<tr ng-repeat='(k, v) in descTab.data'>
      					<td ng-repeat='(sk, f) in descTab.field'>{{v[f]}}</td>
      				</tr>
      			</table>
      			<div class="error" ng-bind-html="queryError"></div>
      		</div>
        </div>
      </div>
    </div>
	</div>
</div>
