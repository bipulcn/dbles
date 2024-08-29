<div class="container-fluid">
	<div class="row" ng-init="loadProblems()">
		<div class="col-12">
			<h4 class="col">Edit Problem Content</h4>
			<ul ng-init="activePage=1" class="tab-nav">
				<li ng-click="activePage=1" ng-class='{active: activePage==1}'>Problem List</li>
				<li ng-click="activePage=2" ng-class='{active: activePage==2}'>Add/Edit Problem</li>
				<li ng-click="activePage=3" ng-class='{active: activePage==3}'>Relative Problem</li>
				<li ng-click="activePage=4" ng-class='{active: activePage==4}'>Enable Problem</li>
			</ul>
		</div>
		<div class="col-12" ng-show='activePage==1'>
			<?php $this->load->view('admins/problems/parts/problemlist'); ?>
		</div>
		<div class="col-12" ng-show='activePage==2'>
			<?php $this->load->view('admins/problems/parts/addproblem'); ?>
		</div>
		<div class="col-12" ng-show='activePage==3'>
			<?php $this->load->view('admins/problems/parts/addsimilarprob'); ?>
		</div>
		<div class="col-12" ng-show='activePage==4'>
			<?php $this->load->view('admins/problems/parts/enableproblem'); ?>
		</div>
	</div>
</div>