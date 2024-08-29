<div class="container-fluid" ng-init="loadLessons();">
	<div class="row justify-content-center">
		<div class="col-12 col-lg-10">
			<div class="jumbotron mb-3 p-3">
				<div class="row">
					<div class="col-4 col-md-3 col-lg-2 py-3"><img src="<?php echo base_url(); ?>assets/img/buet.png"
							class="img-fluid">
					</div>
					<div class="col-12 col-md-9 col-lg-10 py-4">
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
			<label class='input-group'>
				<b class="input-group-text bg-info bg-opacity-25">Exam List: </b>
				<select class="form-control" ng-model='modLess' ng-change='setLesson()' ng-init='modLess=0'>
					<option ng-repeat="(k, v) in exmlist" value="{{k}}">{{v.detail.title}}</option>
				</select>
			</label>
			<h5 ng-if="exmlist[selExam].detail.enable==0" class="text-danger p-2">
				"{{exmlist[selExam].detail.title}}" is Inactive.
			</h5>
		</div>

		<?php $this->load->view('public/problems/spg/schemalst'); ?>

		<div class="col-12 tbp probList" ng-if="exmlist[selExam].detail.aproved=='Y'">
			<?php $this->load->view('public/problems/spg/codeexam');?>
			
		</div>
	</div>
</div>