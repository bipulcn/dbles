var app = angular.module("page_app", []);
app.controller("page_controller", function ($scope, $http, $window) {
	$scope.passOk = true;
	$scope.passCks = [false, false, false, false, false];
	$scope.department = {
		ete: "Electronics and Telecommunication Engineering",
		cse: "Computer Science and Engineering",
		ece: "Electrical and Computer Engineering",
		eee: "Electrical and Electronic Engineering",
		ict: "Information and Communication Technology",
		mech: "Mechanical Engineering",
		chem: "Chemical Engineering",
		civil: "Civil Engineering",
	};
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

	$scope.getGroup = function () {
		var dt = { section: 10 };
		$http({
			method: "POST",
			url: $scope.base_url + "puser/regdb",
			data: dt,
			header: { "Content-Type": "application/x-www-form-urlencoded" },
		}).then(function (data) {
			$scope.mygroup = data.data;
		});
	};
	$scope.delGroup = function (id) {
		var dt = { section: 11, gid: id };
		if (confirm("Do you really want to delete it?")) {
			$http({
				method: "POST",
				url: $scope.base_url + "puser/regdb",
				data: dt,
				header: { "Content-Type": "application/x-www-form-urlencoded" },
			}).then(function (data) {
				$scope.getGroup();
			});
		}
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
	// $scope.loginCheck = function () {
	// 	var dt = { section: 1, uid: $scope.rg_uid };
	// 	$http({
	// 		method: "POST",
	// 		url: $scope.base_url + "puser/regdb",
	// 		data: dt,
	// 		header: { "Content-Type": "application/x-www-form-urlencoded" },
	// 	}).then(function (data) {
	// 		// console.log(data.data);
	// 	});
	// };

	$scope.loadUserInfo = function () {
		var add = $scope.base_url + "puser/regdb";
		var dt = { section: 4 };
		$http({
			method: "POST",
			url: add,
			data: dt,
			header: { "Content-Type": "application/x-www-form-urlencoded" },
		}).then(function (data) {
			// console.log(data.data);
			$scope.uinfo = data.data;
			$scope.rg_uid = $scope.uinfo[0].uid;
			$scope.rg_intid = $scope.uinfo[0].intid;
			$scope.rg_name = $scope.uinfo[0].name;
			$scope.rg_sess = $scope.uinfo[0].session;
			$scope.rg_email = $scope.uinfo[0].email;
			$scope.rg_phone = $scope.uinfo[0].phone;
			$scope.rg_desig = $scope.uinfo[0].designation;
			$scope.rg_depar = $scope.uinfo[0].department;
			$scope.rg_imgs = $scope.uinfo[0].imgs;
			$scope.rg_role = $scope.uinfo[0].role;
			$scope.loadGroupData();
			$scope.getGroup();
		});
	};
	$scope.cngUserInfo = function () {
		var dt = {
			section: 5,
			uid: $scope.rg_uid,
			nam: $scope.rg_name,
			ses: $scope.rg_sess,
		};
		$http({
			method: "POST",
			url: $scope.base_url + "puser/regdb",
			data: dt,
			header: { "Content-Type": "application/x-www-form-urlencoded" },
		}).then(function (data) {
			// console.log(data.data);
			alert("User Name Saved.");
		});
	};
	$scope.cngUserPassword = function () {
		var pas1 = $scope.rg_pas;
		let all = allAreTrue($scope.passCks);
		if (all && pas1.length) {
			var dt = { section: 6, opas: $scope.rg_opas, pas: $scope.rg_pas };
			$http({
				method: "POST",
				url: $scope.base_url + "puser/regdb",
				data: dt,
				header: { "Content-Type": "application/x-www-form-urlencoded" },
			}).then(function (data) {
				var ck = data.data;
				// console.log(ck);
				if (ck == "false") alert("Given Old password is not correct");
				else alert("New password was saved");
			});
		} else alert("Please give a valid password!");
	};

	$scope.uploadedFile = function (element) {
		// console.log(num);
		let reader = new FileReader();
		reader.onload = function (event) {
			$scope.image_source = event.target.result;
			$scope.$apply(function ($scope) {
				// console.log(element.files);
				$scope.imgdata = element.files;
			});
		};
		reader.readAsDataURL(element.files[0]);
	};

	$scope.uploadImg = function () {
		// console.log("Working"+$scope.imgdata[0]);
		let imge = $scope.imgdata[0];
		$http({
			method: "POST",
			url: $scope.base_url + "puser/upimg",
			processData: false,
			transformRequest: function (data) {
				let formData = new FormData();
				formData.append("image", imge);
				formData.append("dir", "/img/profile/");
				return formData;
			},
			data: $scope.form,
			headers: { "Content-Type": undefined },
		}).then(function (data) {
			$scope.savedimg = "File " + data.data[0];
		});
	};
	$scope.grpList = {};
	$scope.loadGroupData = function () {
		var dt = { section: 7, inst: $scope.rg_intid };
		$http({
			method: "POST",
			url: $scope.base_url + "puser/regdb",
			data: dt,
			header: { "Content-Type": "application/x-www-form-urlencoded" },
		}).then(function (data) {
			let dts = data.data;
			dts.forEach((element) => {
				let sdt = element.groupname.split("_");
				if ($scope.grpList[sdt[1]] == undefined) {
					$scope.grpList[sdt[1]] = {};
					$scope.grpList[sdt[1]][sdt[2]] = [];
					$scope.grpList[sdt[1]][sdt[2]].push(sdt[3]);
				} else {
					if ($scope.grpList[sdt[1]][sdt[2]] == undefined) {
						$scope.grpList[sdt[1]][sdt[2]] = [];
						$scope.grpList[sdt[1]][sdt[2]].push(sdt[3]);
					} else {
						if (!$scope.grpList[sdt[1]][sdt[2]].includes(sdt[3]))
							$scope.grpList[sdt[1]][sdt[2]].push(sdt[3]);
					}
				}
			});
		});
	};
	$scope.updateSession = function () {
		var dt = {
			section: 8,
			inst: $scope.rg_intid,
			yea: $scope.sc_year,
			sec: $scope.sc_sect,
			gru: $scope.sc_grup,
		};
		$http({
			method: "POST",
			url: $scope.base_url + "puser/regdb",
			data: dt,
			header: { "Content-Type": "application/x-www-form-urlencoded" },
		}).then(function (data) {
			$scope.getGroup();			
		});
	};
	$scope.updateInfo = function () {
		var dt = {
			section: 9,
			name: $scope.rg_name,
			email: $scope.rg_email,
			phone: $scope.rg_phone,
			desig: $scope.rg_desig,
			depar: $scope.rg_depar,
			rol: $scope.rg_role,
			inst: $scope.rg_intid,
		};
		$http({
			method: "POST",
			url: $scope.base_url + "puser/regdb",
			data: dt,
			header: { "Content-Type": "application/x-www-form-urlencoded" },
		}).then(function (data) {
			// console.log(data.data);
		});
	};

	$scope.getInititute = function () {
		var dt = { section: 1 };
		$http({
			method: "POST",
			url: $scope.base_url + "puser/regdb",
			data: dt,
			header: { "Content-Type": "application/x-www-form-urlencoded" },
		}).then(function (data) {
			$scope.instLst = data.data;
		});
	};
	angular.element(document).ready(function () {
		$scope.loadUserInfo();
		$scope.getInititute();
	});
});
