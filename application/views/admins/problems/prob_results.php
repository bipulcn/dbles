<div class="row" >
	<div class="col-3">
		<label for="">Section</label>
		<select class="form-control mb-3" ng-model='sect' ng-change="setSection(sect)">
			<option ng-repeat="v in group" ng-value="v.sgid">{{v.groupname}}</option>
		</select>
		<label for="">Prolemb set</label>
		<select class="form-control mb-3" ng-model='eless' ng-change="setLesson(eless)" style="width:100%; padding: 9px 0.5%; font-size: 1em;">
			<option ng-repeat='(k, v) in prob' value="{{k}}">{{v.title}}</option>
		</select>
	</div>
	<div class="col-9">
		<a href="<?= base_url(); ?>admin/xslexp/{{eless}}/{{selSes}}" class="btn btn-primary" style="float:right">Export</a>
		<h4 class="">Answers: {{prob[selLesson].title}}</h4>
	</div>
	<div class="col-12" ng-show="selLesson">
		<div class="">
			<table class="table border-top">
				<tr>
					<th>id</th>
					<th>name</th>
					<th ng-repeat="(k, v) in prob[selLesson].prob">
						<div class="row">
							<div class="col-1">p:{{v.pid}}</div>
							<div class="col-1" ng-repeat="(sk, sv) in v.sprob">sp:{{sv.spid}}</div>
						</div>
					</th>
					<th>Total</th>
				</tr>
				<tr ng-repeat="(s, u) in user">
					<th class="text-end">{{u.uid}}</th>
					<td class="text-start">&nbsp; {{u.name}}</td>
					<td ng-repeat="(k, v) in prob[selLesson].prob">
						<div class="row">
							<div class="col-1">{{result[selLesson][v.pid][0][u.uid].mark}}</div>
							<div class="col-1" ng-repeat="(sk, sv) in v.sprob">{{result[selLesson][v.pid][sv.spid][u.uid].mark}}</div>
						</div>
					</td>
					<td>{{result[selLesson][u.uid]['total']}}</td>
				</tr>
			</table>
		</div>
	</div>
</div>