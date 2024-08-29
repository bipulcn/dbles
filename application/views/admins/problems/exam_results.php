<div class="row" ng-init="loadProblems()">
	<div class="col-3 col">
		<select class="form-control my-3" ng-model='sect' ng-change="setSection(sect)">
			<option ng-repeat="v in group" ng-value="v.sgid">{{v.groupname}}</option>
		</select>
		<select class="form-control mb-3" ng-model='eless' ng-change="setExam(eless)">
			<option ng-repeat='v in exTitl' value="{{v.eid}}">{{v.title}}</option>
		</select>
	</div>
	<div class="col-9">
		<a href="<?= base_url();?>admin/xslexam/{{selExam}}/{{selSes}}" class="btn btn-primary" style="float:right">Export</a>
		<h4 class="col">Answers: {{prob[selExam].title}}</h4>
	</div>
	<div class="col-12" ng-show="selExam">
			<div class="">
				<table class="table">
					<tr>
						<th>id</th>
						<th>name</th>
						<th ng-repeat="v in selProblms">
							<div class="row">
								<div class="col-1">p:{{v}}</div>
								<div class="col-1" ng-repeat="(sk, sv) in v.sprob">sp:{{sv.spid}}</div>
							</div>
						</th>
						<th>Total</th>
					</tr>
					<tr ng-repeat="(s, u) in user">
						<td class="text-end">{{u.unid}}</td>
						<td class="text-start">&nbsp; {{u.name}}</td>
						<td ng-repeat="v in selProblms">
							<div class="row">
								<div class="col-1">{{result[u.uid][v]}}</div>
							</div>
						</td>
						<td>{{u.total}}</td>
					</tr>
				</table>
			</div>
	</div>
</div>
