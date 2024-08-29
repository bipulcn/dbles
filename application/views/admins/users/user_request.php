<div class="row hf maincontent" ng-init='getUserPerList()'>
	<div class="col-12">
		<h1>User Manage page</h1>

		<div class="accordion" id="accordionSections">
			<div class="accordion-item">
				<h2 class="accordion-header">
					<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						Student Group
					</button>
				</h2>
				<div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionSections">
					<div class="accordion-body">
						<div class="" ng-repeat="(k, inst) in grpStud">
							<h5>{{k}}</h5>
							<div class="" ng-repeat="(i, rw) in inst">

								<div class="accordion" id="groupTables">
									<div class="accordion-item">
										<h2 class="accordion-header">
											<button class="accordion-button text-center text-uppercase" type="button" data-bs-toggle="collapse" data-bs-target="#group{{i}}" aria-expanded="false" aria-controls="group{{i}}">
												{{i}}
											</button>
										</h2>
										<div id="group{{i}}" class="accordion-collapse collapse" data-bs-parent="#groupTables">
											<div class="accordion-body">

												<table class="table table-bordered w-100">
													<tr>
														<th>University ID</th>
														<th>Name</th>
														<th>Departement</th>
														<th>email</th>
														<th>Role</th>
														<th>Approved?</th>
														<th></th>
													</tr>
													<tr ng-repeat="v in rw" ng-show="v.aproved=='N'">
														<td class='bg-danger-subtle'>{{v.unid}}</td>
														<td class='bg-danger-subtle'><b>{{v.name}}</b></td>
														<td>{{v.department}}</td>
														<td>{{v.email}}</td>
														<td>{{v.role}}</td>
														<td class='bg-danger-subtle'><button class="btn btn-blank py-0" ng-click="aproveUser(v.gsid, k, i, $index)">{{v.aproved}}</button></td>
														<td><button class="btn btn-blank py-0" ng-click="delUser(v.gsid, k, i, $index)">&#x1F5D1;</button></td>
													<tr ng-repeat="v in rw" ng-show="v.aproved=='Y'">
														<td class='bg-success-subtle'>{{v.unid}}</td>
														<td class='bg-success-subtle'>{{v.name}}</td>
														<td>{{v.department}}</td>
														<td>{{v.email}}</td>
														<td>{{v.role}}</td>
														<td class='bg-success-subtle'><button class="btn btn-blank py-0" ng-click="aproveUser(v.gsid, k, i, $index)">{{(v.aproved=='N')?'Confirm':'Approved'}}</button></td>
														<td><button class="btn btn-blank py-0" ng-click="delUser(v.gsid, k, i, $index)">&#x1F5D1;</button></td>
												</table>
											</div>
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
						User Migration
					</button>
				</h2>
				<div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionSections">
					<div class="accordion-body">
						<div class="row justify-content-center">
							<div class="col-12 col-md-6 col-lg-4 col-xl-3" ng-repeat="v in perList" ng-show="v.urole!=v.drole && v.drole">
								<div class="card m-2 p-3">
									<div class="card-body">
										<img ng-src="<?= base_url('assets/img/profile/') ?>{{v.imgs}}" class="img-fluid" alt="">
										<h6 mg-if="v.unid">{{v.unid}}</h6>
										<h4>{{v.name}}</h4>
										<h5 ng-if="v.urole=='T'">Teacher</h5>
										<h5 ng-if="v.urole=='A'">Admin</h5>
										<h5 ng-if="v.urole=='G'">Guest</h5>
										<h5 ng-if="v.urole=='S'">Student</h5>
										<h6 ng-if="v.department">Department:</h6>
										<h6 ng-if="v.designation">Designation: {{v.designation}}</h6>
										<h5 ng-if="v.intid">{{v.intid}}, {{v.department}}</h5>
										<h6 ng-if="v.email">email: {{v.email}}</h6>
										<h6 ng-if="v.phoen">Phone: {{v.phoen}}</h6>
										<h6>roll: {{utypes[v.urole]}}->{{utypes[v.drole]}}</h6>
										<h6 ng-if="v.session">Session: {{v.session}}</h6>
										<div ng-if="v.utime">{{v.utime}}</div>
										<button class="btn btn-outline-danger" name="button" ng-click='deleteRequest(v.uid)'>&#x1F5D1;</button>
										<button class="btn btn-outline-primary" name="button" ng-click='approveRequest(v.uid)' ng-show="v.urole!=v.drole && v.drole">Approve</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="accordion-item">
				<h2 class="accordion-header">
					<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
						User Approval
					</button>
				</h2>
				<div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionSections">
					<div class="accordion-body">
						<div class="row justify-content-center">
							<div class="col-12">
								<table class="table table-bordered w-100">
									<tr>
										<th>Image</th>
										<th>University ID</th>
										<th>Name</th>
										<th>role</th>
										<th>Departement</th>
										<th>Role</th>
										<th>Date</th>
										<th>Approved?</th>
										<th></th>
									</tr>
									<tr ng-repeat="v in perList" ng-show="v.valid=='N'">
										<td><img ng-src="<?= base_url('assets/img/profile/') ?>{{v.imgs}}" class="img-fluid" alt="" style="width: 80px;"></td>
										<td>
											<div mg-if="v.unid">{{v.unid}}</div>
										</td>
										<td>
											<h6>{{v.name}}</h6>
										</td>
										<td>
											<b ng-if="v.urole=='T'">Teacher</b>
											<b ng-if="v.urole=='A'">Admin</b>
											<b ng-if="v.urole=='G'">Guest</b>
											<b ng-if="v.urole=='S'">Student</b>
										</td>
										<td>
											<div ng-if="v.intid">{{v.intid}}, {{v.department}}</div>
										</td>
										<td>
											<div ng-if="v.phoen">Phone: {{v.phoen}}</div>
										</td>
										<td>
											<div ng-if="v.utime">{{v.utime}}</div>
										</td>
										<td><button class="btn btn-outline-primary" ng-show="v.valid=='N'" name="button" ng-click='approveRequest(v.uid)'>Validate</button></td>
										<td><button class="btn btn-outline-danger" name="button" ng-click='deleteValid(v.uid)'>&#x1F5D1;</button></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--<div class="accordion-item">
				<h2 class="accordion-header">
					<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
						Approved User
					</button>
				</h2>
				<div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionSections">
					<div class="accordion-body">
						<div class="row justify-content-center">
							<div class="col-12">
								<table class="table table-bordered w-100">
									<tr>
										<th>Image</th>
										<th>University ID</th>
										<th>Name</th>
										<th>role</th>
										<th>Departement</th>
										<th>Role</th>
										<th>Date</th>
										<th>Approved?</th>
										<th></th>
									</tr>
									<tr ng-repeat="v in perList" ng-show="v.valid=='Y'">
										<td><img ng-src="<?= base_url('assets/img/profile/') ?>{{v.imgs}}" class="img-fluid" alt="" style="width: 80px;"></td>
										<td>
											<div mg-if="v.unid">{{v.unid}}</div>
										</td>
										<td>
											<h6>{{v.name}}</h6>
										</td>
										<td>
											<b ng-if="v.urole=='T'">Teacher</b>
											<b ng-if="v.urole=='A'">Admin</b>
											<b ng-if="v.urole=='G'">Guest</b>
											<b ng-if="v.urole=='S'">Student</b>
										</td>
										<td>
											<div ng-if="v.intid">{{v.intid}}, {{v.department}}</div>
										</td>
										<td>
											<div ng-if="v.phoen">Phone: {{v.phoen}}</div>
										</td>
										<td>
											<div ng-if="v.utime">{{v.utime}}</div>
										</td>
										<td><button class="btn btn-outline-primary" ng-show="v.valid=='N'" name="button" ng-click='approveRequest(v.uid)'>Validate</button></td>
										<td><button class="btn btn-outline-danger" name="button" ng-click='deleteValid(v.uid)'>&#x1F5D1;</button></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
-->
		</div>


	</div>
</div>