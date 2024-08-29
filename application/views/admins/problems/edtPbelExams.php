<div class="row" ng-init="loadExamContents()">
	<div class="col-12">
		<div class="row">
			<div class="col-2">
				<h6 class="xcol">Exam List </h6>
				<ul class="list-group">
					<li class="list-group-item border-0 px-0" ng-repeat='(k, v) in qsets'>
						<b class="px-3">{{k}}</b>
						<ul class="list-group">
							<li class="list-group-item" ng-repeat='sv in v' ng-click="loadExistExam(k, sv.eid)" ng-class="{selected : selExam==sv.eid}">{{sv.title}}</li>
						</ul>
					</li>
				</ul>
			</div>
			<div class="col-7 col">
				<div class="sticky-top" style="z-index: 1">
					<ul ng-init="activeTab=1" class="tab-nav sticky-top">
						<li ng-click="activeTab=1" ng-class='{active: activeTab==1}'>Exam New/Edit</li>
						<li ng-click="activeTab=2" ng-class='{active: activeTab==2}'>Assing Qus</li>
						<li ng-click="activeTab=3" ng-class='{active: activeTab==3}'>Add/Edit Qus</li>
					</ul>
					<div ng-show="activeTab==1">
						<button class="btn btn-primary my-3" ng-click='selExam=0' style="float:right">New</button>
						<h3>Exam Create or Edit </h3>
						<div class="row">
							<div class="col-1 px-0 pt-2">Title:</div>
							<div class="col-9 pb-4"><input class="form-control" type="text" ng-model='qs_title'></div>
							<div class="col-2 px-0 fw-bolder"><label class="form-check-label text-primary pt-2">Enable: <input class="form-check-input px-0" type="checkbox" ng-model='qs_enable' /></label></div>
							<div class="col-3 px-0 pt-2">Student Group:</div>
							<div class="col-4">
								<select class="form-control pb-4" ng-model='qs_sgroup'>
									<option ng-repeat="v in group" ng-value="v.sgid">{{v.groupname}}</option>
								</select>
							</div>
							<div class="col-2 text-end pe-0 pt-2">Marks:</div>
							<div class="col-3"><input class="form-control" type="text" ng-model='qs_marks' /></div>
							<div class="col-12 text-end"><button class="btn btn-primary" ng-click="saveNewExam()">{{selExam? "Update" : "Save"}}</button></div>
						</div>
						<hr>
					</div>
					<div ng-show="activeTab==2">
						<div class="row" ng-if="selProblem!=0 && selExam!=0" style="margin-bottom: 30px;">
							<div class="col-12">
								<h4>Assign question</h4>
							</div>
							<div class="col-2">Exam: </div>
							<div class="col-10">
								<h5 style="padding: 2px 10px 10px 10px;">{{qs_title}}</h5>
							</div>
							<div class="col-2">Question: </div>
							<div class="col-10">
								<h6 style="padding: 2px 10px 10px 10px;">{{pobtitle}}</h6>
							</div>
							<div class="col-2"><label>Marks:</label></div>
							<div class="col-6"><input class="form-control" type="text" ng-model='exmMrk' style="width: 60%"></div>
							<div class="col-2"><button class="btn btn-primary" ng-click="addExamQues(exmMrk)">Add</button></div>
						</div>
						<hr>
						<div>
							<div>
								List Of Questions
							</div>
							<div class="border my-1" ng-repeat="v in eqalist[selExam]">
								<button class="btn btn-danger float-end m-2" ng-click='removeProblem(v.eid, v.pid)'>&#x1F5D1;</button>
								<div class="p-3">{{$index+1}}. {{v.title}}</div>
							</div>
						</div>
					</div>
					<div ng-show="activeTab==3">
						<div class="row">
							<div class="col-12">
								<h4>Add or Edit Problem</h4>
							</div>
							<div class="col-12 pt-3">
								<label for="">Problem Title</label>
								<input class="form-control" type="text" ng-model='pobtitle'>
							</div>
							<div class="col-12 pt-3">
								<label for="">Problem Description:
									<div class="text-primary pt-2 d-inline">Enable: <input class="form-check-input px-0" type="checkbox" ng-model='qs_enb_dtl' />
								</label>
							</div>
							</label>
							<textarea class="form-control" name="name" rows="8" cols="80" ng-model='pobDesc'></textarea>
						</div>
						<div class="col-12 py-3">
							<label for="">Problem Query as reference: </label>
							<textarea class="form-control" name="name" rows="4" ng-model='pobSolut' ng-change='analyzeStatement(pobSolut)'></textarea>
							<button class="btn btn-primary mt-3 float-end" ng-click="executeQuery(pobSolut)">Run</button>
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
						<div class="col-12 pt-3">
							<button class="btn btn-primary" ng-click='saveProblemData(pobtitle, pobDesc, pobSolut, 0)'>Save Problem</button>
							<button class="btn btn-primary" ng-click='saveProblemData(pobtitle, pobDesc, pobSolut, selProblem)' ng-if="selProblem!=0">Update Problem</button>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-3 sticky-top" style="height: 90vh; overflow-y:auto" ng-show="activeTab!=1 && !(activeTab==2 && selExam==0)">
			<h6 class="">Problem list</h6>
			<ul class="list-group">
				<li class="list-group-item p-0 border-0" ng-repeat='(k, v) in eqlist'>
					<h5>{{k}}</h5>
					<ul class="list-group">
						<li class="list-group-item" ng-repeat="(n, sv) in v" ng-click="setProblemToEdit(k, n)" ng-class="{selected : selProblem==sv.pid}">{{$index+1}}. {{sv.title}}</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>
</div>