<div class="row topbar justify-content-end">
  <ul class="col_9 nav justify-content-end">
    <li class=""><a href='<?php echo base_url(); ?>puser/cnginfo'>profile</a></li>
    <li class=""><a href='<?php echo base_url(); ?>'>Home</a></li>
    <?php if ($this->session->userid != "") { ?>
      <li class="parnt"><a href='<?php echo base_url(); ?>pdrill/labs'>Practice </a></li>
      <li class="parnt"><a href='<?php echo base_url(); ?>pdrill/exam'>Lab Exam</a></li>
    <?php } ?>
    <?php if ($this->session->userrole == "A" || $this->session->userrole == "T") { ?>
      <li class="parnt">
        <a href='<?php echo base_url(); ?>admin'>Admin</a>
      </li>
    <?php } ?>
    <?php $this->load->view('layouts/login'); ?>
  </ul>
</div>
<hr class="clear">