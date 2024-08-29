<div class="row" ng-init="loadProblems()">
	<div class="col-3">
		<label for="">Section / Group</label>
		<select class="form-control" ng-model='sect' ng-change="setSection(sect)">
			<option ng-repeat="v in group" ng-value="v.sgid">{{v.groupname}}</option>
		</select>
		<label for="">Lesson List</label>
		<select class="form-control mb-3" ng-model='eless' ng-change="setLesson(eless)">
			<option ng-repeat='(k, v) in prob' value="{{k}}">{{v.title}}</option>
		</select>
		<ul class="list-group">
			<li class="list-group-item" ng-repeat="(k, v) in user" ng-click='loadUserAnswers(v.uid)' ng-class="{selected : selUser==v.uid}">
				<b class="text-primary">{{v.uid}}</b><br><small class="text-secondary" ng-show="v.name">-{{v.name}}</small>
			</li>
		</ul>
	</div>
	<div class="col-9">
		<h4 class="p-0 m-0">Students Lesson Answers</h4><hr>
		<div class="row" ng-repeat="(k, v) in prob[selLesson].prob">
			<div class="col-12">
				<h4 class="d-block">{{$index+1}}| {{v.title}}</h4>
				<div>{{v.details}}</div>
				<h6 class="text-end d-block">{{selUserName}} -</h6>
			</div>
			<div class="col-6">
				<b class="d-block border-bottom">Solution</b>
				<div class="py-3">{{v.solution}}</div>
				<button class="btn btn-primary" ng-click="executeQuery(v.solution, k)">Run</button>
			</div>
			<div class="col-6">
				<h6 class="p-0 m-0 d-block border-bottom">Answer <b>{{uanswer[v.pid][0].utime}}</b></h6>
				<div class="py-3">{{uanswer[v.pid][0].codes}}</div>
				<div class="row" ng-show="uanswer[v.pid][0].codes">
					<div class="col-2"><button class="btn btn-primary" ng-click="loadResults(uanswer[v.pid][0].codes, k)">Run</button></div>
					<div class="col-10 py-1">
						<div class="link marks" ng-repeat="k in [0,1,2,3,4,5,6,7,8,9,10]" ng-click="saveMarks(uanswer[v.pid][0], k)" ng-class='{result:k==uanswer[v.pid][0].marks}'>{{k}}</div>
					</div>
				</div>
			</div>
			<div class="col-6 output px-0">
				<h6>Output</h6>
				<div class="outputContent">
					<table class="dbtable">
						<tr>
							<th ng-repeat='dv in outputTab[k].field'>{{dv}}</th>
						</tr>
						<tr ng-repeat='dv in outputTab[k].data'>
							<td ng-repeat='df in outputTab[k].field'>{{dv[df]}}</td>
						</tr>
					</table>
					<div class="error" ng-bind-html="queryError[k]"></div>
				</div>
			</div>
			<div class="col-6 output px-0">
				<h6>Results</h6>
				<div class="outputContent">
					<table class="dbtable">
						<tr>
							<th ng-repeat='dv in descTab[k].field'>{{dv}}</th>
						</tr>
						<tr ng-repeat='dv in descTab[k].data'>
							<td ng-repeat='df in descTab[k].field'>{{dv[df]}}</td>
						</tr>
					</table>
					<div class="error" ng-bind-html="descError[k]"></div>
				</div>
			</div>
			<div class="col-12 row" ng-repeat="(sk, d) in v.sprob">
				<div class="col-12">
					<h5 class="d-block">{{$index+1}}| {{v.title}}</h5>
					<div>{{v.details}}</div>
					<h6 class="text-end d-block">{{selUserName}} -</h6>
				</div>
				<div class="col-6">
					<b class="d-block border-bottom">Solution</b>
					<div>{{d.solution}}</div>
					<button class="btn btn-primary" ng-click="executeQuery(d.solution, k, sk)">Run</button>
				</div>
				<div class="col-6">
					<h6 class="p-0 m-0 d-block border-bottom">Answer <b>{{uanswer[v.pid][0].utime}}</b></h6>
					<div>{{uanswer[v.pid][d.spid].codes}}</div>
					<div class="row" ng-show="uanswer[v.pid][d.spid].codes">
						<div class="col-2"><button class="btn btn-primary" ng-click="loadResults(uanswer[v.pid][d.spid].codes, k, sk)">Run</button></div>
						<div class="col-10 py-1">
							<div class="link marks" ng-repeat="k in [0,1,2,3,4,5,6,7,8,9,10]" ng-click="saveMarks(uanswer[v.pid][d.spid], k)" ng-class='{result:k==uanswer[v.pid][d.spid].marks}'>{{k}}</div>
						</div>
					</div>
				</div>
				<div class="col-6 output px-0">
					<h6>Output</h6>
					<div class="outputContent">
						<table class="dbtable">
							<tr>
								<th ng-repeat='dv in outputSameTab[k][sk].field'>{{dv}}</th>
							</tr>
							<tr ng-repeat='dv in outputSameTab[k][sk].data'>
								<td ng-repeat='df in outputSameTab[k][sk].field'>{{dv[df]}}</td>
							</tr>
						</table>
						<div class="error" ng-bind-html="querySameError[k][sk]"></div>
					</div>
				</div>
				<div class="col-6 output px-0">
					<h6>Results</h6>
					<div class="outputContent">
						<table class="dbtable">
							<tr>
								<th ng-repeat='dv in descSameTab[k][sk].field'>{{dv}}</th>
							</tr>
							<tr ng-repeat='dv in descSameTab[k][sk].data'>
								<td ng-repeat='df in descSameTab[k][sk].field'>{{dv[df]}}</td>
							</tr>
						</table>
						<div class="error" ng-bind-html="descSameError[k][sk]"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>