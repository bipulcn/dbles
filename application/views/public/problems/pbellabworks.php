<div class="container-fluid" ng-init="loadLessons();">
	<div class="row justify-content-center">
		<div class="col-12 col-lg-10">
			<div class="jumbotron mb-3 p-3">
				<div class="row">
					<div class="col-2 py-3"><img src="<?php echo base_url(); ?>assets/img/buet.png" class="img-fluid">
					</div>
					<div class="col-10 py-4">
						<h1 class="display-6 mt-0 pt-0">e-Learning Research and Development Lab</h1>
						<h4 class="">Department of CSE, BUET</h4>
						<p class="lead">
							Database Learning and Evaluation System (DB-LES)<br />
							SQL Learning and Evaluation Module</p>
					</div>
				</div>
			</div>
		</div>

		<div class="col-12 col-md-10 col-lg-8 mb-3">
			<label class="input-group"><b class="input-group-text bg-info bg-opacity-25">Lab Assignments: </b>
				<select class="form-control" ng-model='modLess' ng-change='setLesson()' ng-init='modLess=0'>
					<option ng-repeat="(k, v) in lessonlist" value="{{v.data.lid}}">{{v.data.title}}</option>
				</select>
			</label>
		</div>
		<div class="col-6 lesdetail bg-secondary bg-opacity-10">
			<h4>{{lessonlist[selLesson].data.title}}</h4>
			<div>{{lessonlist[selLesson].data.details}}</div>
			<hr class="hr_mi">
		</div>
		<!-- The objectives are defined againsed each lesson and each lesson belongs some problem list -->
		<div class="col-6 lesobject">
			<h5>Learning outcomes</h5>
			<ul style="margin-left: 30px;">
				<li ng-repeat="ob in lessonlist[selLesson].object" style="list-style: disc;">{{ob.title}}</li>
			</ul>
			<hr class="hr_mi">
		</div>
		<?php $this->load->view('public/problems/spg/schemalst'); ?>
		<div class="col-12 tbp probList">
			<?php $this->load->view('public/problems/spg/codebox');?>
		</div>
	</div>
</div>