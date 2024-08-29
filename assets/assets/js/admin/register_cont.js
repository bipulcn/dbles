var app = angular.module("page_app", []);
app.controller("page_controller", function ($scope, $http, $window) {
	$scope.utypes = {'S':'Student', 'T':'Teacher', 'A':'Admin', 'G':'Guest'};
	// $scope.test = "Test name ";
	// $scope.passOk = false;
	// $scope.loginCheck = function(){
	// 	var dt = { section: 1, uid: $scope.rg_uid };
	// 	$http({
	//   method: "POST", url:$scope.base_url+'auser/regdb', data: dt,
	//   header: {'Content-Type': 'application/x-www-form-urlencoded'}
	// }).then(function (data) {
	// 		console.log(data['data']);
	// 	});
	// }
	// $scope.checkPassComp = function() {
	// 	var pas1 = $scope.rg_pas;
	// 	var pas2 = $scope.rg_repas;
	// 	if(pas1==pas2) { $scope.passOk = true; }
	// 	else {
	// 		$scope.passOk = false;
	// 	}
	// }
	// $scope.registerUser = function() {
	// 	if($scope.passOk) {
	// 		var dt = { section: 2, uid: $scope.rg_uid, pas: $scope.rg_pas, rol: $scope.rg_role };
	// 		$http({
	//   	  method: "POST", url:$scope.base_url+'auser/regdb', data: dt,
	//   	  header: {'Content-Type': 'application/x-www-form-urlencoded'}
	//   	}).then(function (data) {
	// 			console.log(data['data']);
	// 		});
	// 	}
	// }
	$scope.getUserPerList = function() {
		var dt = { section: 3 };
		$http({
	  method: "POST", url:$scope.base_url+'auser/regdb', data: dt,
	  header: {'Content-Type': 'application/x-www-form-urlencoded'}
	}).then(function (data) {
			$scope.perList = data.data;
		});
	}
	$scope.approveRequest = function (itm) {
		var dt = { section: 6, uid: itm };
		$http({
			method: "POST",
			url: $scope.base_url + "auser/regdb",
			data: dt,
			header: { "Content-Type": "application/x-www-form-urlencoded" },
		}).then(function (data) {
			$scope.getUserPerList();
		});
	};
	$scope.ValidateRequest = function (itm) {
		var dt = { section: 4, uid: itm };
		$http({
			method: "POST",
			url: $scope.base_url + "auser/regdb",
			data: dt,
			header: { "Content-Type": "application/x-www-form-urlencoded" },
		}).then(function (data) {
			$scope.getUserPerList();
		});
	};
	$scope.deleteRequest = function (itm) {
		var dt = { section: 5, uid: itm };
		$http({
			method: "POST",
			url: $scope.base_url + "auser/regdb",
			data: dt,
			header: { "Content-Type": "application/x-www-form-urlencoded" },
		}).then(function (data) {
			$scope.getUserPerList();
		});
	};
	$scope.deleteValid = function (itm) {
		var dt = { section: 7, uid: itm };
		$http({
			method: "POST",
			url: $scope.base_url + "auser/regdb",
			data: dt,
			header: { "Content-Type": "application/x-www-form-urlencoded" },
		}).then(function (data) {
			$scope.getUserPerList();
		});
	};
	$scope.delUser = function (gsid, uid, gid, ind) {
		let dt = { section: 9, gid: gsid }
		$http({
			method: "POST",
			url: $scope.base_url + "auser/regdb",
			data: dt,
			header: { "Content-Type": "application/x-www-form-urlencoded" },
		}).then(function (data) {
			console.log(data.data);
			// $scope.getGroupStudentList();
			$scope.grpStud[uid][gid].splice(ind, 1);
		});
	}
	$scope.aproveUser = function (gsid, uid, gid, ind) {
		let dt = { section: 10, gid: gsid }
		$http({
			method: "POST",
			url: $scope.base_url + "auser/regdb",
			data: dt,
			header: { "Content-Type": "application/x-www-form-urlencoded" },
		}).then(function (data) {
			console.log(data.data);
			$scope.grpStud[uid][gid][ind].aproved = 'Y';
			// $scope.getGroupStudentList();
		});
	}
	$scope.getGroupStudentList = function() {
		$scope.grpStud = {};
		var dt = { section: 8 };
		$http({
			method: "POST",
			url: $scope.base_url + "auser/regdb",
			data: dt,
			header: { "Content-Type": "application/x-www-form-urlencoded" },
		}).then(function (data) {
			let dta = data.data;
			dta.forEach(row => {
				if($scope.grpStud[row.intid] != undefined) {
				if($scope.grpStud[row.intid][row.groupname] != undefined) {
					$scope.grpStud[row.intid][row.groupname].push(row);
				} else {
					$scope.grpStud[row.intid][row.groupname] = [row];
				}
				}
				else {
					$scope.grpStud[row.intid] = {};
					$scope.grpStud[row.intid][row.groupname] = [row];
				}
			});
		});
	}
	angular.element("document").ready(function() {
		$scope.getGroupStudentList();
	})
});
