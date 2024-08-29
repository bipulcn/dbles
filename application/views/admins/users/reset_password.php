<div class="row hf maincontent">
	<div class="col-4">
		<h4 class="p-0 mb-3">User Management</h4>
		<div class="input-group mb-3">
			<input type="text" class="form-control" ng-model='search' placeholder="Search By information"  ng-keydown="$event.keyCode === 13 && searchUser()" />
			<span class="input-group-text" ng-click="searchUser()">&#x1F50D;</span>
		</div>
		<ul class="list-group">
			<li class="list-group-item" style="border-bottom: thin solid #8888;" ng-repeat="us in userlst" ng-click='selectUser(us)'>{{us.name}}</li>
		</ul>
	</div>
	<div class="col-8 col">
		<div class="register_form">
			<div class="row">
				<h5 class="col-12">{{selUser.name}}</h5>
				<div class="col-12" ng-show="selUser.email">{{selUser.email}}</div>
				<div class="col-12" ng-show="selUser.phone">{{selUser.phone}}</div>
				<div class="col-12" ng-show="selUser.roll">{{selUser.roll}}</div>
				<div class="col-12" ng-show="selUser.department">{{selUser.department}}</div>
				<div class="col-12">{{selUser.groupname}}</div>
				<div class="col-12">{{selUser.description}}</div>
				<div class="col-12">{{selUser.utime}}</div>
				<div class="col-12" ng-show="actInfo">
					<b>Number of Login: </b>{{actInfo.num}}
					<div style="margin-left: 20px;" ng-if="actInfo.num > 0">
						<b>Active Time: </b>{{actInfo.sec / 60 | number:0}}
						<div>{{actInfo.let}}, <br>{{actInfo.sta}}</div>
					</div>
				</div>
				<div class="col-12" ng-show="ansInfo">
					<b>Number of Answers: </b>{{ansInfo.num}}
					<div style="margin-left: 20px;" ng-if="ansInfo.num > 0">
						<b>Total Marks: </b>{{ansInfo.sec / 60 | number:0}}
						<div>{{ansInfo.let}}, <br>{{ansInfo.sta}}</div>
					</div>
				</div>

				<div class="col-6" ng-show="selUser">
					<div class="row">
						<div class="col-12"><b>Reset Password: </b></div>
						<div class="input-group">
							<input class="form-control" type="password" ng-model='rg_pas' ng-blur='checkPassComp()'>
							<button class="input-group-text" ng-click='resetPassword()'>Reset</button>
						</div>
					</div>
				</div>
				<div class="col-6" ng-show="selUser">
					<div class="row">
						<div class="col-12"><b>Test Password: </b></div>
						<div class="input-group"><input class="form-control" type="password" ng-model='ck_pas' ng-blur='checkPassComp()'>
						<button class="input-group-text" ng-click='checkPassword()'>Check</button></div>
					</div>
				</div>
				<div class="col-6" style="margin-top: 20px;" ng-show="selUser">
					<div class="d-flex justify-content-center"><b style="color:red; margin-bottom: 5px; display: block;">Delete User </b>
					<button class="btn btn-danger" ng-click='deleteUser()' style="margin: 0 auto; display: inline-block;">Delete</button></div>
				</div>
			</div>
		</div>
	</div>
</div>