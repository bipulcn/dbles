<div class="row hf maincontent">
	<div class="col-12 col-lg-8 m-auto col pb-5">
		<h3 class="py-3 text-center">User information Update</h3>

		<div class="accordion" id="accordionExample">
			<div class="accordion-item">
				<h2 class="accordion-header">
					<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						<h5 class='m-0'>Select Session</h5>
					</button>
				</h2>
				<div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
					<div class="accordion-body">
						<div class="row">
							<div class="col-12 m-auto">
								<div class="row">
									<div class="col-12 my-3">
										<h3>Update Semester session</h3>
									</div>
									<div class="col-12 my-3">
										<table class="table" ng-show="mygroup.length>0">
											<tr>
												<th>Group</th>
												<th>Details</th>
												<th>Aproved</th>
												<th></th>
											</tr>
											<tr ng-repeat="v in mygroup">
												<td>{{v.groupname}}</td>
												<td>{{v.description}}</td>
												<td>{{v.aproved}}</td>
												<td><button class="btn btn-outline-danger" ng-click="delGroup(v.gsid)">&#x1F5D1;</button></td>
											</tr>
										</table>
									</div>
									<div class="col-4">Year:
										<select name="" class="form-control" ng-model='sc_year'>
											<option ng-repeat="(k, v) in grpList" value="{{k}}">20{{k}}</option>
										</select>
									</div>
									<div class="col-4">Group:
										<select name="" class="form-control" ng-model='sc_sect'>
											<option ng-repeat="(k, v) in grpList[sc_year] track by $index" value="{{k}}">{{k}}</option>
										</select>
									</div>
									<div class="col-4">Section:
										<select name="" class="form-control" ng-model='sc_grup'>
											<option ng-repeat="v in grpList[sc_year][sc_sect]" value="{{v}}">{{v}}</option>
										</select>
									</div>

									<div class="col-12 mt-3">
										<button class="btn btn-primary float-end" ng-click='updateSession()'>Update</button>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="accordion-item">
				<h2 class="accordion-header">
					<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseImage" aria-expanded="false" aria-controls="collapseImage">
						<h5 class='m-0'>Profile</h5>
					</button>
				</h2>
				<div id="collapseImage" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
					<div class="accordion-body">
						<div class="row">
							<div class="col-12 col-lg-10 m-auto">
								<div class="row">
									<div class="col-12 my-3">
										<h3>Profile Photo</h3>
									</div>
									<div class="col-6">
										<div style="background-image:url('<?= base_url() ?>assets/img/profile/{{rg_imgs}}'); width: 200px; height: 249px;background-repeat: no-repeat;background-size: cover;margin: 0 auto;background-position: center;"></div>
									</div>
									<div class="col-6">
										<img ng-src="{{image_source}}" style="width:300px;" class="img-fluid">
										<div class="alert alert-info" ng-show="savedimg">{{savedimg}}</div>
										<div class="">
											<input type="file" ng-model="imgdata" onchange="angular.element(this).scope().uploadedFile(this)" name='profile' class="form-control timg" accept="image/*">
											<button class="btn btn-primary" ng-click="uploadImg()">Change</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="accordion-item">
				<h2 class="accordion-header">
					<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
						<h5 class='m-0'>Profile</h5>

					</button>
				</h2>
				<div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
					<div class="accordion-body">
						<form action="" method="post">
							<div class="row">
								<div class="col-12 col-md-9 col-lg-7 m-auto">
									<div class="my-3">
										<h3>Update Profile</h3>
									</div>
									<div class="">Name:</div>
									<div class="mb-3"><input type="text" class="form-control" ng-model='rg_name'></div>
									<div class="">Institute: {{rg_intid}}</div>
									<select class="form-control" ng-show="rg_intid=='' || (rg_role!='S' && rg_role!='G')" ng-model="rg_intid">
										<option ng-repeat="rw in instLst" value="{{rw.cod}}">{{rw.name}}</option>
									</select>
									<div class="mb-3" ng-show="rg_intid!='' || rg_role=='S'">
										<b ng-repeat="v in instLst" ng-show="v.cod==rg_intid">{{v.name}}</b>
									</div>
									<div class="mb-3"><label>Department:</label>
										<select class="form-control" ng-model='rg_depar'>
											<option ng-repeat="(k, v) in department" value="{{k}}">{{v}}</option>
										</select>
									</div>
									<div class="mb-3" ng-show="uinfo[0].role!='S'"><label>Designation:</label>
										<select class="form-control" ng-model='rg_desig'>
											<option ng-repeat="(k, v) in designations" value="{{k}}">{{v}}</option>
										</select>
									</div>
									<div class="mb-3"><label>User Type:</label>
										<select class="form-control" ng-model='rg_role'>
											<option value="S">Student</option>
											<option value="T">Teacher</option>
											<option value="G">Other</option>
										</select>
									</div>

									<div class="">Email:</div>
									<div class="mb-3"><input type="text" class="form-control" ng-model='rg_email'></div>
									<div class="">Phone:</div>
									<div class="mb-3"><input type="text" class="form-control" ng-model='rg_phone'></div>
									<div class="mb-3">
										<button class="btn btn-primary float-end" ng-click='updateInfo()'>Update</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="accordion-item">
				<h2 class="accordion-header">
					<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
						<h5 class='m-0'>Password</h5>
					</button>
				</h2>
				<div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
					<div class="accordion-body">
						<div class="row">
							<div class="col-12 col-md-9 col-lg-7 m-auto">
								<div class="row">
									<div class="col-12 my-3">
										<h3>Update Password</h3>
									</div>
									<div class="col-12">Old Password:</div>
									<div class="col-12 mb-3">
										<input type="password" class="form-control" ng-model='rg_opas'>
									</div>
									<div class="col-12">New Password:</div>
									<div class="col-12 mb-3">
										<input type="password" class="form-control" ng-model='rg_pas' ng-change='checkPassComp()'>
										<div class="text-muted"><i ng-show='!passCks[0]'>&#10007;</i><b ng-show='passCks[0]' class='text-success'>&#10003;</b> At least 8 characters</div>
										<div class="text-muted"><i ng-show='!passCks[1]'>&#10007;</i><b ng-show='passCks[1]' class='text-success'>&#10003;</b> At least one lowercase letter</div>
										<div class="text-muted"><i ng-show='!passCks[2]'>&#10007;</i><b ng-show='passCks[2]' class='text-success'>&#10003;</b> At least one uppercase letter</div>
										<div class="text-muted"><i ng-show='!passCks[3]'>&#10007;</i><b ng-show='passCks[3]' class='text-success'>&#10003;</b> At least one number</div>
									</div>
									<div class="col-12">Retype New Password:</div>
									<div class="col-12 mb-3">
										<input type="password" class="form-control" ng-model='rg_repas' ng-change='checkPassComp()' ng-class="{enble:!passOk}">
										<div class="text-muted"><i ng-show='!passCks[4]'>&#10007;</i><b ng-show='passCks[4]' class='text-success'>&#10003;</b> Does not match</div>
									</div>
									<div class="col-12 mb-3">
										<button class="btn btn-primary float-end" ng-click='cngUserPassword()'>Update</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="py-5 my-5"></div>
	</div>
</div>

