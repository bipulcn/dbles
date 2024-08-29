<div class="row hf maincontent" ng-init='loadBasicData()'>
	<div class="col-12 col-md-10 col-lg-8 col-xl-6 mx-auto">
		<div class="my-5">
			<div class="btn-group" style="width: inherit;">
				<div class="btn" ng-click="utype='S'" ng-class='{"btn-warning":utype=="S", "btn-secondary":utype!="S"}'>Student</div>
				<div class="btn" ng-click="utype='T'" ng-class='{"btn-warning":utype=="T", "btn-secondary":utype!="T"}'>Teacher</div>
				<div class="btn" ng-click="utype='G'" ng-class='{"btn-warning":utype=="G", "btn-secondary":utype!="G"}'>Other</div>
			</div>
		</div>
		<div class="my-5 pb-5">
			<div class="card">
				<div class="card-header">
					<h1 class='text-center m-2'>
						<b ng-show="utype=='S'">Student</b>
						<b ng-show="utype=='T'">Teacher</b>
						<b ng-show="utype=='G'">Other</b>
						<span class="text-muted fw-light">registration form</span>
					</h1>
				</div>
				<div class="card-body">
					<div class="px-5 py-3">
						<div class="mb-3">
							<label>Institute Name:</label>
							<select class="form-control" ng-model='rg_insti'>
								<option ng-repeat="rw in instLst" value="{{rw.cod}}">{{rw.name}}</option>
							</select>
						</div>
						<div class="mb-3">
							<label>Department:</label>
							<select class="form-control" ng-model='rg_depar'>
								<option ng-repeat="(k, v) in department" value="{{k}}">{{v}}</option>
							</select>
						</div>
						<!--<div class="mb-3" ng-show='utype=="S"'>
							<div class="row">
								<div class="col">
									<label>Year:</label>
									<select class="form-control" ng-model='rg_year'>
										<option value="17">2017</option>
										<option value="18">2018</option>
										<option value="19">2019</option>
										<option value="20">2020</option>
										<option value="21">2021</option>
										<option value="22">2022</option>
										<option value="23">2023</option>
										<option value="24">2024</option>
										<option value="25">2025</option>
										<option value="26">2026</option>
									</select>
								</div>
								<div class="col">
									<label>Semester:</label>
									<select class="form-control" ng-model='rg_semis'>
										<option value="term1">Term-1</option>
										<option value="term2">Term-2</option>
										<option value="spring">Spring semester</option>
										<option value="summer">Summer semester</option>
										<option value="fall">Fall Semester</option>
									</select>
								</div>
							</div>
						</div> -->
						<div class="mb-3">
							<label>Name:</label>
							<input type="text" class="form-control" ng-model='rg_name'>
						</div>
						<div class="mb-3" ng-show='utype!="S"'>
							<label>Designation:</label>
							<select class="form-control" ng-model='rg_desig'>
								<option ng-repeat="(k, v) in designations" value="{{k}}">{{v}}</option>
							</select>
						</div>
						<div class="mb-3">
							<label>Phone:</label>
							<input type="text" class="form-control" ng-model='rg_phone'>
						</div>
						<div class="mb-3">
							<label>Email:</label>
							<input type="text" class="form-control" ng-model='rg_email'>
						</div>
						<div class="mb-3" ng-show='utype!="S"'>
							<label>userid:</label>
							<input type="text" class="form-control" ng-model='rg_uid' ng-blur='checkUserId(rg_uid)' ng-class='{enble:greens==1}'>
							<div class="text-danger fl-sm" ng-show="greens==1">User id is not available</div>
							<div class="text-danger fl-sm" ng-show="greens==2">Please use a valid ID (at least 6 characters)</div>
						</div>
						<div class="mb-3" ng-show='utype=="S"'>
							<label>Student ID (or Roll):</label>
							<input type="text" class="form-control" ng-model='rg_unid' ng-blur='checkUserId(rg_insti+rg_unid)' ng-class='{enble:greens==1}'>
							<div class="text-danger fl-sm" ng-show="greens==1">User id is not available</div>
							<div class="text-danger fl-sm" ng-show="greens==2">Please use a valid ID (at least 6 characters)</div>
							<div class="mt-3">User ID</div>
							<h6 class="text-primary border m-0 p-2">{{rg_insti+rg_unid}}</h6>
						</div>
						<!-- <div class="mb-3">
							<label>Session:</label>
							<input type="text" class="form-control" ng-model='rg_sess' list="session">
							<datalist id="session">
								<option ng-repeat='v in session' value="{{v.session}}">
							</datalist>
						</div> -->
						<div class="mb-3">
							<label>Password:</label>
							<input type="password" class="form-control" ng-model='rg_pas' ng-change='checkPassComp()'>
							<div class="text-muted"><i ng-show='!passCks[0]'>&#10007;</i><b ng-show='passCks[0]' class='text-success'>&#10003;</b> At least 8 characters</div>
							<div class="text-muted"><i ng-show='!passCks[1]'>&#10007;</i><b ng-show='passCks[1]' class='text-success'>&#10003;</b> At least one lowercase letter</div>
							<div class="text-muted"><i ng-show='!passCks[2]'>&#10007;</i><b ng-show='passCks[2]' class='text-success'>&#10003;</b> At least one uppercase letter</div>
							<div class="text-muted"><i ng-show='!passCks[3]'>&#10007;</i><b ng-show='passCks[3]' class='text-success'>&#10003;</b> At least one number</div>
						</div>
						<div class="mb-3">
							<label>Retype Password:</label>
							<input type="password" class="form-control" ng-model='rg_repas' ng-change='checkPassComp()'>
							<div class="text-muted"><span ng-show='!passCks[4]'>&#10007; Does not match</span><b ng-show='passCks[4]' class='text-success'>&#10003; matched</b></div>
						</div>
						<div class="col-12 my-3 text-end">
							<button class="btn btn-primary" ng-click='registerUser()'>Register</button>
						</div>
						<div class="col-12 my-3">

						<hr class="clear">
							<b style="color:gray; font-size:0.8em;">Already have an account? please <a class="btn btn-outline-primary" href="{{base_url}}puser/login">Login</a></b>
						</div>
					</div>
				</div>
			</div>

		</div>
		<!-- <?php echo $page; ?> -->
	</div>
</div>

