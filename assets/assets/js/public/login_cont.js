var app = angular.module("page_app", []);
app.controller("page_controller", function ($scope, $http, $window) {
	$scope.logedIn = true;
	$scope.passOk = true;
	$scope.loginUser = function () {
		$scope.logedIn = true;
		var dt = { section: 2, uid: $scope.userid, pass: $scope.password };
		$http({
			method: "POST",
			url: $scope.base_url + "puser/logdb",
			data: dt,
			header: { "Content-Type": "application/x-www-form-urlencoded" },
		}).then(function (data) {
			$scope.loginChecker = data.data[0];
			$scope.logedIn = data.data[0] == "false" ? false : true;
			if ($scope.logedIn)
				$window.location.href = $scope.base_url + "pdrill/labs";
		});
	};
});
