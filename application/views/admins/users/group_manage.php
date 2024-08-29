<div class="row hf maincontent">
	<div class="col-12">
		<h1>Group Manage page</h1>
		<div class="row">
			<div class="col-3">
				<div>
					<h6 class="btn btn-outline-secondary d-block text-start" ng-repeat="(k, v) in perList" ng-click='setKey(v.sgid)'>{{v.groupname}}</h6>
				</div>
			</div>
			<div class="col-4">
				<div ng-if="gky!=-1">
					<h3>{{perList[gky].groupname}}</h3>
					<div>{{perList[gky].description}}</div>
					<h5>Number of Members: {{perList[gky].members}}</h5>
					<button class="btn btn-primary" ng-click='setEdit()'>Update</button>
				</div>
			</div>
			<div class="col-5">
				<div class="card">
					<div class="card-body">
						<h4 class="pb-3">Student Group: <button class="btn btn-primary float-end" ng-click="newGroup()">New</button></h4>
						<div class="row">
							<div class="col pb-3 pe-2">
								<label for="">Year</label>
								<select ng-model='gr_year' class="form-select">
									<option ng-repeat="v in years" value="{{v}}">{{v}}</option>
								</select>

							</div>
							<div class="col pb-3 ps-2">
								<label for="">Group</label>
								<input type="text" class="form-control" ng-model='gr_sects'>
							</div>
							<div class="col pb-3 ps-2" ng-show="editGroup!=0">
								<label for="">Sequence</label>
								<input type="text" class="form-control" ng-model='gr_seque'>
							</div>
						</div>
						<div class="pb-3">
							<label for="">Group Details</label>
							<textarea class="form-control" ng-model='gr_detail'></textarea>
						</div>
						<div class="pb-3">
							<button class="btn btn-primary" ng-click='saveGroup()'>{{(editGroup==0)?'Create':'Update'}}</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-6">

	</div>
</div>