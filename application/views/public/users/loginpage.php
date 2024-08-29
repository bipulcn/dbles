<div class="row hf maincontent" ng-init='loadBasicData()'>
	<div class="col-12 col-md-10 col-lg-8 col-xl-6 mx-auto mb-5">

		<div class="my-5 pb-5">
			<div class="card mb-5">
				<div class="card-header">
					<h1 class='text-center my-3'>User Login page</h1>
				</div>
				<div class="card-body">
					<div class="p-3">

						<div class="">userid:</div>
						<div class="mb-3">
							<input type="text" class="form-control" ng-model='userid' ng-blur='checkUserId()' ng-class='{enble:greens}'>
						</div>
						<div class="">Password:</div>
						<div class="mb-3"><input type="password" class="form-control" ng-model='password' ng-blur='checkPassComp()'></div>
						<div class="mb-3 text-danger" ng-show='!logedIn'>ID and password does not match</div>
						<div class="my-5">
							<b style="color:gray; font-size:0.8em;">Don not have an account? <a class="btn btn-outline-primary" href="{{base_url}}puser/register">Register</a></b>
							<button class="btn btn-primary float-end" ng-click='loginUser()'>Login</button>
							<div class="pt-1 mt-3 text-center border-top"><a class="btn btn-blank" href="<?=base_url()?>puser/reqpass">Forgot password?</a></div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>