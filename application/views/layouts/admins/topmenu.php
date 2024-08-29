<div class="row topbar">
 <ul class="col_9 nav justify-content-end">
  <?php $this->load->view('layouts/login'); ?>
  <!-- <li class="" ng-controller="login_controller" ng-init="loginCheck()">
  	<a href='#' ng-click="setLoginVis()" ng-if='!logedIn'>Login</a>
  	<a href='#' ng-click="userLogOut()" ng-if='logedIn'>Log Out</a>
  	<div class="row loginform" ng-show="showLoginForm && !logedIn">
  		<div class="col_12">User id:</div>
  		<div class="col_10"><input type="text" ng-model='userid' ng-keypress='onEnter($event)'></div>
  		<div class="col_12">Password:</div>
  		<div class="col_10"><input type="Password" ng-model='password' ng-keypress='onEnter($event)'></div>
  		<div class="col_6" style="text-align: right;"><button class="btn btn-primary" ng-click="loadRegister()">Register</button></div>
  		<div class="col_6" style="text-align: center;"><button class="btn btn-primary" ng-click="loginUser()">Login</button></div>
  		<div class="col_12" ng-show="loginChecker=='false'" style="color:red">**Check ID or password</div>
  	</div>
  </li> -->
  <?php if($this->session->aduid!="") {
    if($this->session->userrole=='A') {?>
  <li class="parnt"><a href='#'>Edit Contents</a>
    <ul class="submenu">
      <li><a href='<?php echo base_url();?>admin/edles'>Manage Problem</a></li>
      <li><a href='<?php echo base_url();?>admin/edexm'>Manage Exams</a></li>
      <li><a href='<?php echo base_url();?>admin/lesson'>Manage Lesson</a></li>
      <li><a href='<?php echo base_url();?>admin/schema'>Manage Schema</a></li>
      <li><a href='<?php echo base_url();?>auser/umanage'>Manage user</a></li>
      <li><a href='<?php echo base_url();?>auser/mangrup'>Manage Group</a></li>
      <li><a href='<?php echo base_url();?>admin/survey'>Survey Manager</a></li>
    </ul>
  </li><?php }?>
  <li><a href="#">Students</a>
    <ul class="submenu">
      <li><a href="<?php echo base_url();?>admin/pans">Lab Answer</a></li>
      <li><a href="<?php echo base_url();?>admin/result">Lab Results</a></li>
      <li><a href="<?php echo base_url();?>admin/eans">Exam Answer</a></li>
      <li><a href="<?php echo base_url();?>admin/eresult">Exam Results</a></li>
      <li><a href="<?php echo base_url();?>admin/enbexm">Enable Exams</a></li>
      <li><a href="<?php echo base_url();?>admin/surres">Survey Results</a></li>
      <li><a href="<?php echo base_url();?>admin/password">Password Reset</a></li>
    </ul>
  </li>
  <li class="parnt"><a href='#'>Dashboard</a>
    <ul class="submenu">
      <li><a href='<?php echo base_url();?>dashboard'>Home</a></li>
    </ul>
  </li>
<?php } ?>
  <li class=""><a href='<?php echo base_url();?>admin'>Admin Main</a></li>
  <li class=""><a href='<?php echo base_url();?>'>User Page</a></li>
 </ul>
</div>
<hr class="clear">

