app.controller("login_controller", function ($scope, $http, $window) {
	$scope.showLoginForm = false;
	$scope.logedIn = false;
	$scope.loginChecker = true;
	$scope.setLoginVis = function () {
		$scope.showLoginForm = !$scope.showLoginForm;
	};
	$scope.loginCheck = function () {
		$http({
			method: "POST",
			url: $scope.base_url + "puser/logdb",
			data: { section: 1 },
			header: { "Content-Type": "application/x-www-form-urlencoded" },
		}).then(function (data) {
			if (data["data"][0] == "false") $scope.logedIn = false;
			else $scope.logedIn = true;
		});
	};
	angular.element("document").ready(function () {
		$scope.loginCheck();
	});
	$scope.onEnter = function (e) {
		if (e.keyCode == 13) $scope.loginUser();
	};
	$scope.loadRegister = function () {
		$window.location.href = $scope.base_url + "puser/register";
	};
	$scope.loginUser = function () {
		var dt = { section: 2, uid: $scope.userid, pass: $scope.password };
		$http({
			method: "POST",
			url: $scope.base_url + "puser/logdb",
			data: dt,
			header: { "Content-Type": "application/x-www-form-urlencoded" },
		}).then(function (data) {
			$scope.loginChecker = data.data[0];
			$scope.logedIn = data["data"][0] == "false" ? false : true;
			if ($scope.logedIn)
				$window.location.href = $scope.base_url + "pdrill/labs";
		});
	};
	$scope.userLogOut = function () {
		$http({
			method: "POST",
			url: $scope.base_url + "puser/logdb",
			data: { section: 3 },
			header: { "Content-Type": "application/x-www-form-urlencoded" },
		}).then(function (data) {
			$scope.logedIn = false;
			$window.location.href = $scope.base_url + "puser/register";
		});
	};
});
