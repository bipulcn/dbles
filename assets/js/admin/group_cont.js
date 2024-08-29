var app = angular.module("page_app", []);
app.controller("page_controller", function ($scope, $http, $window) {
	$scope.test = "Test name ";
	$scope.passOk = false;
	$scope.gky = -1;
	$scope.editGroup = 0;

	$scope.getGroupList = function () {
		var dt = { section: 1 };
		$http({
			method: "POST",
			url: $scope.base_url + "auser/grpdb",
			data: dt,
			header: { "Content-Type": "application/x-www-form-urlencoded" },
		}).then(function (data) {
			$scope.perList = data.data;
		});
	};
	// $scope.checkGroup = function (name, itm = 0) {
	// 	var dt = { section: 2, gid: itm, gname: name };
	// 	$http({
	// 		method: "POST",
	// 		url: $scope.base_url + "auser/grpdb",
	// 		data: dt,
	// 		header: { "Content-Type": "application/x-www-form-urlencoded" },
	// 	}).then(function (data) {
	// 		if (data.data[0] == "ok") return true;
	// 		else return false;
	// 	});
	// };
	$scope.setKey = function (k) {
		$scope.gky = k;
	};
	$scope.newGroup = function() {
		$scope.editGroup = 0;
	}
	$scope.setEdit = function () {
		$scope.editGroup = $scope.perList[$scope.gky].sgid;
		let gname = $scope.perList[$scope.gky].groupname;
		let spl = gname.split("_");
		$scope.gr_year = "20"+spl[1];
		$scope.gr_sects = spl[2];
		$scope.gr_seque = spl[3];
		$scope.gr_detail = $scope.perList[$scope.gky].description;
		console.log($scope.gr_detail);
	};
	$scope.saveGroup = function () {
		let itm = 0;
		if ($scope.editGroup != 0) itm = $scope.editGroup;
		var dt = {
			section: 4,
			gid: itm,
			yer: $scope.gr_year,
			grp: $scope.gr_sects,
			squ: $scope.gr_seque,
			descr: $scope.gr_detail,
		};
		$http({
			method: "POST",
			url: $scope.base_url + "auser/grpdb",
			data: dt,
			header: { "Content-Type": "application/x-www-form-urlencoded" },
		}).then(function (data) {
			// console.log(data.data);
			$scope.getGroupList();
		});
	};

	angular.element("document").ready(function () {
		$scope.getGroupList();
		let dte = new Date();
		let yer = dte.getFullYear();
		$scope.gr_year = yer;
		$scope.years = [];
		$scope.years.push(yer);		
		for (let i = 1; i < 10; i++) {
			$scope.years.push(yer - i);
		}

	})
});
