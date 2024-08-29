var app = angular.module("page_app", []);
app.controller("page_controller", function ($scope, $http, $window) {
	$scope.errors = -1;
	$scope.enablepass = false;
	$scope.success = "";
	$scope.message = "";
	$scope.resend = false;
	$scope.passCks = [false, false, false, false, false];

	$scope.sendSMSto = function () {
		console.log("sending sms for", $scope.userid, $scope.phone);
		$scope.resend = false;
		let dts = { userid: $scope.userid, phone: $scope.phone };
		$http({
			method: "POST",
			url: $scope.base_url + "puser/sendsms",
			data: dts,
			header: { "Content-type": "application/x-www-from-urlencoded" },
		}).then(
			function (data) {
				let dt = data.data;
				$scope.datas = dt;
				if (dt.kinds == 1) {
					let succ = dt.message.split("|");
					$scope.genotp = succ[0];
					$scope.errors = 1;
					$scope.phoneidea =
						succ[1].substring(0, 3) +
						" **---** " +
						succ[1].substring(succ[1].length - 2);
				}
				if (dt.kinds == 0) {
					$scope.errors = 0;
				}
				if (dt.kinds == 2) {
					$scope.errors = 2;
				}
				setTimeout(function () {
					$scope.resend = true;
				}, 20000);
			},
			function (response) {
				console.log("failed to load data.");
			}
		);
	};
	$scope.checkOtp = function () {
		let uotp = $scope.userotp;
		if (uotp == $scope.genotp) {
			$scope.enablepass = true;
		}
	};
	$scope.checkPassComp = function () {
		let pas1 = $scope.password;
		let pas2 = $scope.repassword;
		$scope.passCks[4] = pas1 == pas2 ? true : false;
		$scope.passCks[0] = pas1.length > 7 ? true : false;
		$scope.passCks[1] = /[a-z]/.test(pas1) ? true : false;
		$scope.passCks[2] = /[A-Z]/.test(pas1) ? true : false;
		$scope.passCks[3] = /[0-9]/.test(pas1) ? true : false;
		// let all = allAreTrue($scope.passCks);
	};
	function allAreTrue(arr) {
		return arr.every((element) => element === true);
	}
	$scope.setPassword = function () {
		$scope.message = "";
		let all = allAreTrue($scope.passCks);
		let userid = $scope.userid;
		let pass = $scope.password;
    console.log(userid, pass)
		if (all) {
			$http({
				method: "POST",
				url: $scope.base_url + "puser/regdb",
				data: { section: 12, uid: userid, pass: pass },
				header: { "Content-type": "application/x-www-from-urlencoded" },
			}).then(
				function (data) {
					let dt = data.data;
					console.log(dt);
					if(dt[0] == 1)
						if(confirm( "পাসওয়ার্ড সফলভাবে সংরক্ষিত হয়েছে")) 
							window.location.href = $scope.base_url;
						else window.location.href = $scope.base_url;
				},
				function (response) {
					console.log("failed to load data.");
				}
			);
		} else {
			$scope.message = "পাসওয়ার্ড মেলে না অনুগ্রহ করে আবার চেষ্টা করুন";
		}
	};
});
