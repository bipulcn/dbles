<nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo base_url(); ?>">DB-LES</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
            <div class="d-flex justify-content-end w-100">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="<?php echo base_url(); ?>">&#127968;</a>
                    </li>
                    <?php if ($this->session->aduid != "") {
                        if ($this->session->userrole == 'A') { ?>
                            <li class="nav-item"><a class="nav-link" href='<?php echo base_url(); ?>admin'>Admin Main</a></li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Edit Contents</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href='<?php echo base_url(); ?>admin/edles'>Manage Problem</a></li>
                                    <li><a class="dropdown-item" href='<?php echo base_url(); ?>admin/edexm'>Manage Exams</a></li>
                                    <li><a class="dropdown-item" href='<?php echo base_url(); ?>admin/lesson'>Manage Lesson</a></li>
                                    <li><a class="dropdown-item" href='<?php echo base_url(); ?>admin/schema'>Manage Schema</a></li>
                                    <li><a class="dropdown-item" href='<?php echo base_url(); ?>auser/mangrup'>Manage Group</a></li>
                                    <li><a class="dropdown-item" href='<?php echo base_url(); ?>admin/survey'>Survey Manager</a></li>
                                    <li><a class="dropdown-item" href="<?php echo base_url(); ?>admin/password">Password Reset</a></li>
                                </ul>
                            </li><?php } ?>
                        <?php if ($this->session->userrole == 'A' || $this->session->userrole == 'T') { ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Answers</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href='<?php echo base_url(); ?>auser/umanage'>Manage user</a></li>
                                    <li><a class="dropdown-item" href="<?php echo base_url(); ?>admin/pans">Lab Answer</a></li>
                                    <li><a class="dropdown-item" href="<?php echo base_url(); ?>admin/result">Lab Results</a></li>
                                    <li><a class="dropdown-item" href="<?php echo base_url(); ?>admin/eans">Exam Answer</a></li>
                                    <li><a class="dropdown-item" href="<?php echo base_url(); ?>admin/eresult">Exam Results</a></li>
                                    <li><a class="dropdown-item" href="<?php echo base_url(); ?>admin/enbexm">Enable Exams</a></li>
                                    <li><a class="dropdown-item" href="<?php echo base_url(); ?>admin/surres">Survey Results</a></li>
                                </ul>
                            </li> <?php } ?>
                            <?php if ($this->session->userrole != 'A') { ?>
                        <li class="nav-item"><a class="nav-link" href='<?php echo base_url(); ?>pdrill/labs'>Practice </a></li>
                        <li class="nav-item"><a class="nav-link" href='<?php echo base_url(); ?>pdrill/exam'>Lab Exam</a></li> <?php }?>
                    <?php } ?>
                    <?php $this->load->view('layouts/login'); ?>
                    
                </ul>
            </div>
        </div>
    </div>
</nav>