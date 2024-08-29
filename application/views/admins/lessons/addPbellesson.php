<div class="container-fluid">
	<div class="row" ng-init="loadLessons()">
		<div class="col-12">
			<h4 class="col">Add Or Edit Lab/Lesson Content</h4>
			<ul ng-init="activePage=1" class="tab-nav">
				<li ng-click="activePage=1" ng-class='{active: activePage==1}'>Lab/Lesson List</li>
				<li ng-click="activePage=2" ng-class='{active: activePage==2}'>Add/Edit Lab/Lesson</li>
				<li ng-click="activePage=3" ng-class='{active: activePage==3}'>Lab/Lesson Objectives</li>
				<li ng-click="activePage=4" ng-class='{active: activePage==4}'>Lab/Lesson Components</li>
			</ul>
		</div>
		<div class="col-12" ng-show='activePage==1'>
			<?php $this->load->view('admins/lessons/parts/lessonlist'); ?>
		</div>
		<div class="col-12" ng-show='activePage==2'>
			<?php $this->load->view('admins/lessons/parts/addlesson'); ?>
		</div>
		<div class="col-12" ng-show='activePage==3'>
			<?php $this->load->view('admins/lessons/parts/addobjective'); ?>
		</div>
		<div class="col-12" ng-show='activePage==4'>
			<?php $this->load->view('admins/lessons/parts/addlessoncomponent'); ?>
		</div>
	</div>
</div>