<li class="nav-item dropdown" ng-controller="login_controller">
    <a class="nav-link dropdown-toggle" href='#' ng-if='logedIn' role="button" data-bs-toggle="dropdown" aria-expanded="false">User</a>
    <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href='<?php echo base_url(); ?>puser/cnginfo'>profile</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a  ng-click="userLogOut()" class="dropdown-item" href='#'>Log Out</a></li>
        </ul>
    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" ng-if='!logedIn'>Login</a>
    <div class="dropdown-menu dropdown-menu-end p-3" style="min-width: 250px">
        <div class="">User id:</div>
        <div class=""><input type="text" class="form-control" ng-model='userid' ng-keypress='onEnter($event)'></div>
        <div class="">Password:</div>
        <div class=""><input type="Password" class="form-control" ng-model='password' ng-keypress='onEnter($event)'></div>
        <div class="row py-2">
            <div class="col-6" style="text-align: right;"><button class="btn btn-primary" ng-click="loadRegister()">Register</button></div>
            <div class="col-6" style="text-align: center;"><button class="btn btn-primary" ng-click="loginUser()">Login</button></div>
        </div>
        <div class="" ng-show="loginChecker=='false'" style="color:red">**Check ID or password</div>
        <div class="pt-1 mt-3 text-center border-top"><a class="btn btn-blank" href="<?=base_url()?>puser/reqpass">Forgot password?</a></div>
    </div>
</li>