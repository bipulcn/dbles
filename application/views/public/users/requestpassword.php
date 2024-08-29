<div class="container-fluid">
  <div class="row justify-content-center py-5 my-5">
    <div id="user_form" class="col-12 col-sm-8 col-md-6 col-xl-5">
      <div class="jumbotron">
        <h4 class="h4 text-center mb-3 pb-3">Request for password change</h4>
        <div class="row">
          <div class="col-12">
            <div class="text-center" ng-show='errors==1 && enablepass==false'>
              <h6 class="h6 text-center pb-3 mb-3 pt-3 mt-3">আমরা আপনার নিবন্ধিত ফোন নম্বর <span class="text-info">{{phoneidea}}</span> তে একটি OTP পাঠিয়েছি।</h6>
              <h5 class="h5 text-center pb-3 mb-3 pt-3 mt-3">আপনার OTP পূরণ করুন</h5>
              <input type="text" class="form-control text-center text-uppercase" maxlength="5" size="5" ng-model="userotp" placeholder="Insert OTP">
              <button class="btn btn-primary mt-3" ng-click="checkOtp()">Check</button><br>
              <div class="mt-3 text-muted" ng-hide="resend">SMS আসেনি? অপেক্ষা করুন </div>
              <div class="btn btn-link mt-3" ng-click="sendSMSto()" ng-show="resend">SMS আসেনি? পুনরায় পাঠাও</div>
            </div>
            <div class="alert alert-danger text-center" ng-show='errors==0'>
              এই তথ্য সহ ব্যবহারকারীর পাওয়া যায়নি।
            </div>
            <div class="alert alert-danger text-center" ng-show='errors==2'>
              আপনার অ্যাকাউন্টের সাথে কোনো ফোন নম্বর যোগ করা হয়ন।
            </div>
          </div>
          <div class="col-12" ng-hide='errors==1'>
            <div class="form-text text-muted text-center">
              <sup class="text-danger">**</sup> It is mandatory to fill the 2 fields: <br>User ID and phone number
            </div>
            <label>User ID</label>
            <input type="text" ng-model="userid" class="form-control" placeholder="Registered User ID" />
          </div>
          <div class="col-12 mt-3" ng-hide='errors==1'>
            <label>Phone number</label>
            <input type="text" ng-model="phone" class="form-control" placeholder="Provided Phone number" />
          </div>
          <div class="col-12 p-3 text-center" ng-hide='errors==1'>
            <button class="btn btn-primary btn-lg" ng-click="sendSMSto()">Send</button>
          </div>
          <div class="col-12 justify-content-center" ng-show="enablepass"> 
          <!-- 
            
          -->
            <div><label>New Password</label>
              <div class="mb-3" ng-init="showpass=true">
                <input type="password" ng-model="password" class="form-control" id="password" placeholder="Password" ng-change='checkPassComp()' />
                <div class="text-muted"><i ng-show='!passCks[0]'>&#10007;</i><b ng-show='passCks[0]' class='text-success'>&#10003;</b> At least 8 characters</div>
                <div class="text-muted"><i ng-show='!passCks[1]'>&#10007;</i><b ng-show='passCks[1]' class='text-success'>&#10003;</b> At least one lowercase letter</div>
                <div class="text-muted"><i ng-show='!passCks[2]'>&#10007;</i><b ng-show='passCks[2]' class='text-success'>&#10003;</b> At least one uppercase letter</div>
                <div class="text-muted"><i ng-show='!passCks[3]'>&#10007;</i><b ng-show='passCks[3]' class='text-success'>&#10003;</b> At least one number</div>
                <!-- <input type="text" ng-model="password" class="form-control" placeholder="Password" ng-show="!showpass"/>
              <div class="input-group-append" ng-click="showpass=!showpass" ng-click="showpass=!showpass">
                <span class="input-group-text btn" id="basic-addon2">
                  <ion-icon name="eye-outline" ng-show="showpass"></ion-icon>
                  <ion-icon name="eye-off-outline" ng-show="!showpass"></ion-icon>
                </span>
              </div> -->
              </div>
            </div>
            <div><label>Retype Password</label>
              <input type="password" ng-model="repassword" class="form-control" placeholder="Retype Password" ng-change='checkPassComp()' />
							<div class="text-muted"><span ng-show='!passCks[4]'>&#10007; Does not match</span><b ng-show='passCks[4]' class='text-success'>&#10003; matched</b></div>
            </div>
            <div class="text-center">
              <button type="button" name="button" class="btn btn-primary mt-3 align-center" ng-model="respass" ng-click="setPassword()">Set Password</button><br>
              <div ng-show="message!=''"><label for="" class="alert alert-danger mt-3">{{message}}</label></div>
              <div ng-show="success!=''"><label for="" class="alert alert-success mt-3">{{success}}</label></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  // $().ready(function() {
    // $('#password').on("input", function() {
    //   let pass = $(this).val();
    //   if (pass != undefined) {
    //     if (pass.match(/[A-Za-z]/g))
    //       $('.errcheck1').addClass('right');
    //     else $('.errcheck1').removeClass('right');
    //     if (pass.match(/[0-9]/g))
    //       $('.errcheck2').addClass('right');
    //     else $('.errcheck2').removeClass('right');
    //     if (pass.match(/\S{8,}/g))
    //       $('.errcheck3').addClass('right');
    //     else $('.errcheck3').removeClass('right');
    //   }
    // });
  // })
</script>