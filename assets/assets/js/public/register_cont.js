var app = angular.module("page_app", []);
app.controller("page_controller", function ($scope, $http, $window) {
	$scope.utype = "S";
	$scope.passCks = [false, false, false, false, false];
	$scope.department = {"ete":"Electronics and Telecommunication Engineering", "cse":"Computer Science and Engineering", "ece":"Electrical and Computer Engineering", "eee":"Electrical and Electronic Engineering", "ict": "Information and Communication Technology", "mech":"Mechanical Engineering", "chem":"Chemical Engineering", "civil":"Civil Engineering"};
	$scope.designations = {
		professor: "Professor",
		"Associate professor": "Associate Professor",
		"assistant professor": "Assistant Professor",
		lecturer: "Lecturer",
		"adjunct professor": "Adjunct Professor",
		"teaching assistant": "Teaching Assistant",
		"research assistant": "Research Assistant",
		president: "President",
		provost: "Provost",
		dean: "Dean",
		"associate dean": "Associate Dean",
		"department chair": "Department Chair",
		librarian: "Librarian",
		counselor: "Counselor",
		advisor: "Advisor",
		coach: "Coach",
		other: "Other",
	};
	$scope.checkPassComp = function () {
		let pas1 = $scope.rg_pas;
		let pas2 = $scope.rg_repas;
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

	$scope.registerUser = function () {
		let all = allAreTrue($scope.passCks);
		let sese = $scope.rg_year + "_" + $scope.rg_semis;
		let userid = $scope.rg_uid;
		if($scope.utype=="S") userid = $scope.rg_insti + $scope.rg_unid;
		if (all && $scope.rg_uid != "") {
			var dt = {
				section: 2,
				typ: $scope.utype,
				ins: $scope.rg_insti,
				dep: $scope.rg_depar,
				sem: sese,
				nam: $scope.rg_name,
				nid: $scope.rg_unid,
				pho: $scope.rg_phone,
				ema: $scope.rg_email,
				des: $scope.rg_desig,
				uid: userid,
				pas: $scope.rg_pas,
			};
			$http({
				method: "POST",
				url: $scope.base_url + "puser/regdb",
				data: dt,
				header: { "Content-Type": "application/x-www-form-urlencoded" },
			}).then(function (data) {
				console.log(data.data);
				if(data['data']=='true')
					$window.location.href = $scope.base_url + "pdrill/labs";
				else {
					alert("Registration Failed");
				}
				// location.reload();
			});
		}
	};

	$scope.checkUserId = function (vals) {
		$scope.greens = 0;
		let valid = vals.match(/^(\S{6,})$/);
		if (valid != null && vals != undefined) {
			var dt = { section: 3, uid: vals };
			$http({
				method: "POST",
				url: $scope.base_url + "puser/regdb",
				data: dt,
				header: { "Content-Type": "application/x-www-form-urlencoded" },
			}).then(function (data) {
				if (data.data == "true") $scope.greens = 1;
				else $scope.greens = 0;
			});
		} else {
			$scope.greens = 2;
		}
	};

	$scope.getInititute = function() {
		var dt = { section: 1 };
		$http({
			method: "POST",
			url: $scope.base_url + "puser/regdb",
			data: dt,
			header: { "Content-Type": "application/x-www-form-urlencoded" },
		}).then(function (data) {
			$scope.instLst = data.data;
		});
	}
	angular.element(document).ready(function() {
		$scope.getInititute();
	})

	// $scope.test = "Test name ";
	// $scope.passOk = true;
	// $scope.loginCheck = function(){
	// 	var dt = { section: 1, uid: $scope.rg_uid };
	// 	$http({
	//   method: "POST", url:$scope.base_url+'puser/regdb', data: dt,
	//   header: {'Content-Type': 'application/x-www-form-urlencoded'}
	// }).then(function (data) {
	// 		console.log(data.data);
	// 	});
	// }

	// $scope.loadUserInfo = function() {
	// 	var add = $scope.base_url+'puser/regdb';
	// 	var dt = { section: 4 };
	// 	$http({
	//   method: "POST", url: add, data: dt,
	//   header: {'Content-Type': 'application/x-www-form-urlencoded'}
	// }).then(function (data) {
	// 		$scope.uinfo = data.data;
	// 		$scope.rg_uid = $scope.uinfo.uid;
	// 		$scope.rg_name = $scope.uinfo.name;
	// 		$scope.rg_sess = $scope.uinfo.session;
	// 		$scope.loadBasicData();
	// 	});
	// }
	// $scope.cngUserInfo = function() {
	// 	var dt = { section: 5, uid: $scope.rg_uid, nam: $scope.rg_name, ses: $scope.rg_sess };
	// 	$http({
	//   method: "POST", url: $scope.base_url+'puser/regdb', data: dt,
	//   header: {'Content-Type': 'application/x-www-form-urlencoded'}
	// }).then(function (data) {
	// 		console.log(data.data);
	// 		alert("User Name Saved.");
	// 	});
	// }
	// $scope.cngUserPassword = function() {
	// 	var pas1 = $scope.rg_pas;
	// 	if($scope.passOk && pas1.length) {
	// 		var dt = { section: 6, uid: $scope.rg_uid, opas: $scope.rg_opas, pas: $scope.rg_pas };
	// 		$http({
	//   	  method: "POST", url: $scope.base_url+'puser/regdb', data: dt,
	//   	  header: {'Content-Type': 'application/x-www-form-urlencoded'}
	//   	}).then(function (data) {
	// 			var ck = data.data;
	// 			console.log(ck);
	// 			if(ck=='false') alert("Given Old password is not correct");
	// 			else alert("New password was saved");
	// 		});
	// 	}
	// 	else alert("Please give a valid password!");
	// }
	// $scope.loadBasicData = function() {
	// 	var dt = { section: 7 };
	// 	$http({
	//   method: "POST", url: $scope.base_url+'puser/regdb', data: dt,
	//   header: {'Content-Type': 'application/x-www-form-urlencoded'}
	// }).then(function (data) {
	// 		console.log(data.data);
	// 		$scope.session = data.data.group;
	// 	});
	// }
});
