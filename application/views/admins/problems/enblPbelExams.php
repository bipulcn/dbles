<div class="row" ng-init="loadExamContents()">
	<div class="col-12">
		<h4 class="col">Manage Exam</h4>
	</div>
	<div class="col-12">
		<div class="row">
			<div class="col-4">
				<ul class="list-group">
					<li class="list-group-item px-0" ng-repeat='(k, v) in qsets'>
						<b class="px-3">{{k}}</b>
						<ul class="list-group">
							<li class="list-group-item" ng-repeat='sv in v' ng-click="loadExistExam(k, sv.eid)" ng-class="{selected : selExam==sv.eid}">{{sv.title}}</li>
						</ul>
					</li>
				</ul>
			</div>
			<div class="col-8 col">
				<div class="sticky-top py-5" style="z-index: 0;">
					<button class="btn btn-primary" ng-click='selExam=0' style="float:right">New</button>
					<h3>Exam Define </h3>
					<div class="row">
						<div class="col-2 py-2">Exam Title:</div>
						<div class="col-9">
							<input class="form-control mb-4" type="text" ng-model='qs_title' disabled>
						</div>
						<div class="col-1">Enable: <Br><input type="checkbox" ng-model='qs_enable' /></div>
						<div class="col-3">For Student Group:</div>
						<div class="col-5">
							<select class="form-control" ng-model='qs_sgroup'>
								<option ng-repeat="v in group" ng-value="v.sgid">{{v.groupname}}</option>
							</select>
							<!-- <select ng-model='qs_sgroup' disabled>
								<option ng-repeat="v in group" value="{{v.session}}">{{v.session}}</option>
							</select> -->
						</div>
						<div class="col-1">Marks:</div>
						<div class="col-3"><input class="form-control" type="text" ng-model='qs_marks' disabled /></div>
						<div class="col-12 pt-3 text-end"><button class="btn btn-primary" ng-click="saveNewExam()">{{selExam? "Update" : "Save"}}</button></div>
					</div>
					<hr>
				</div>
			</div>
		</div>
	</div>
</div>