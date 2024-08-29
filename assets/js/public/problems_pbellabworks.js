var app = angular.module("page_app", []);
app.controller("page_controller", function ($scope, $http, $window, $sce) {
	$scope.mod_query_code = [];
	$scope.queryError = [];
	$scope.mod_same_query_code = [];
	$scope.mod_same_query_code[0] = [];
	$scope.outputSameTab = [];
	$scope.outputSameTab[0] = [];
	$scope.outputTab = [];
	$scope.descSameTab = [];
	$scope.descSameTab[0] = [];
	$scope.descTab = [];
	$scope.queryError = [];
	$scope.descError = [];
	$scope.querySameError = [];
	$scope.descSameError = [];
	$scope.querySameError[0] = [];
	$scope.descSameError[0] = [];
	$scope.selSchema = "HR Schema";
	$scope.problemrefe = [];
	$scope.tableCheck = [];
	$scope.modLess = 1;
	$scope.probindex = [];
	$scope.showSection = [];
	$scope.showSubSection = [];
	$scope.showSubSection[0] = [];

	$scope.showSectionEnb = function (id, itm) {
		if ($scope.showSection[itm] == "undefined") $scope.showSection[itm] = true;
		$scope.showSection[itm] = !$scope.showSection[itm];
		$scope.getAnswers(id, itm, -1);
	};
	$scope.showSubSectionEnb = function (id, sec, itm) {
		if (typeof $scope.showSubSection[sec] == "undefined")
			$scope.showSubSection[sec] = [];
		if (typeof $scope.showSubSection[sec] == "undefined")
			$scope.showSubSection[sec][itm] = true;
		$scope.showSubSection[sec][itm] = !$scope.showSubSection[sec][itm];
		$scope.getAnswers(id, sec, itm);
	};
	$scope.selectSchema1 = function (itm) {
		$scope.selSchema1 = itm;
	};
	$scope.selectSchema2 = function (itm) {
		$scope.selSchema2 = itm;
	};
	$scope.setLesson = function () {
		$scope.selLesson = $scope.modLess;
		$scope.preloader = true;
		var dt = { section: 2, lid: $scope.modLess };
		$http({
			method: "POST",
			url: $scope.base_url + "pdrill/load_labs",
			data: dt,
			header: { "Content-Type": "application/x-www-form-urlencoded" },
		}).then(
			function successCallback(data) {
				let rdt = data.data;
				// console.log(rdt);
				$scope.problemlist = rdt;
				angular.forEach($scope.problemlist, function (v, k) {
					$scope.problemrefe.push(k);
					$scope.problemrefe[k] = [];
				});
				$scope.preloader = false;
			},
			function errorCallback(res) {
				var er = res["data"];
				console.log(er);
				$scope.preloader = false;
			}
		);
		// $scope.loadProblemList($scope.modLess);
	};
	$scope.shortcutKey = function (keyEvent, itm, s = -1) {
		if (keyEvent.which === 10) $scope.executeQuery(itm, s);
	};

	$scope.addForProblem = function (itm, sc) {
		$scope.problemrefe[itm] = [];
		angular.forEach($scope.schema[sc].data, function (v, k) {
			if ($scope.tableCheck[k]) {
				$scope.problemrefe[itm].push({ schema: sc, table: k });
			}
		});
		// console.log($scope.problemrefe);
	};
	// $scope.removeRefer = function(k, sc, st) {
	//   angular.forEach($scope.problemrefe[k], function(v, s){
	//     if(v.schema==sc && v.table==st) {$scope.problemrefe[k].pop(s);}
	//   });
	// }
	// INSERT INTO `sqldb_system`.`user_detail` (`uid`, `name`, `roll`, `phone`, `email`, `session`) VALUES ('bipul', 'Bipul Nath', '02', '01675623295', 'bipulchnath@gmail.com', '1');

	$scope.checkFK = function (itm) {
		var eist = false;
		angular.forEach($scope.schema[$scope.selSchema1].fk, function (v, k) {
			if (v == itm) eist = true;
		});
		return eist;
	};
	$scope.loadLessons = function () {
		$scope.preloader = true;
		var dt = { section: 1 };
		$http({
			method: "POST",
			url: $scope.base_url + "pdrill/load_labs",
			data: dt,
			header: { "Content-Type": "application/x-www-form-urlencoded" },
		}).then(
			function successCallback(data) {
				let rdt = data.data;
				// console.log(rdt);
				$scope.lessonlist = rdt.lesson;
				$scope.schema = rdt.schema;
				$scope.preloader = false;
				// $scope.loadProblemList(1);
			},
			function errorCallback(res) {
				var er = res["data"];
				console.log(er);
				$scope.preloader = false;
			}
		);
	};
	$scope.loadProblemList = function (itm) {
		$scope.problemrefe = [];
		$scope.problemlist = $scope.lessonlist[itm].problems;
		angular.forEach($scope.problemlist, function (v, k) {
			$scope.problemrefe.push(k);
			$scope.problemrefe[k] = [];
		});
	};
	$scope.loadTableInfo = function (itm) {
		var code = "DESC " + itm;
		var dt = { section: 2, que: code };
		$http({
			method: "POST",
			url: $scope.base_url + "pdrill/runqs",
			data: dt,
			header: { "Content-Type": "application/x-www-form-urlencoded" },
		}).then(
			function successCallback(data) {
				// console.log(data.data);
				$scope.tableInfos = data.data;
				$scope.preloader = false;
			},
			function errorCallback(res) {
				var er = res["data"];
				var pos1 = er.indexOf("<h1>");
				var pos2 = er.indexOf("</div>");
				// console.log(pos1, pos2);
				if (s == -1)
					$scope.queryError[k] = $sce.trustAsHtml(er.substring(pos1, pos2));
				else
					$scope.querySameError[k][s] = $sce.trustAsHtml(
						er.substring(pos1, pos2)
					);
				$scope.preloader = false;
				// called asynchronously if an error occurs
				// or server returns response with an error status.
			}
		);
	};
	$scope.executeQuery = function (k, s = -1) {
		if (s == -1) $scope.outputTab[k] = null;
		else {
			if (!$scope.outputSameTab[k]) $scope.outputSameTab[k] = [];
			$scope.outputSameTab[k][s] = [];
		}
		if (s == -1) $scope.queryError[k] = "";
		else {
			$scope.querySameError[k] = [];
			$scope.querySameError[k][s] = "";
		}
		var code;
		if (s == -1) code = $scope.mod_query_code[k];
		else code = $scope.mod_same_query_code[k][s];
		if (code != undefined) {
			$scope.preloader = true;
			var dt = { section: 2, que: code };
			$http({
				method: "POST",
				url: $scope.base_url + "pdrill/runqs",
				data: dt,
				header: { "Content-Type": "application/x-www-form-urlencoded" },
			}).then(
				function successCallback(data) {
					if (s == -1) $scope.outputTab[k] = data["data"];
					else $scope.outputSameTab[k][s] = data["data"];
					$scope.preloader = false;
				},
				function errorCallback(res) {
					var er = res["data"];
					er = er.replace("temporary", "");
					var pos1 = er.indexOf("<h1>");
					var pos2 = er.indexOf("</div>");
					if (s == -1)
						$scope.queryError[k] = $sce.trustAsHtml(er.substring(pos1, pos2));
					else
						$scope.querySameError[k][s] = $sce.trustAsHtml(
							er.substring(pos1, pos2)
						);
					$scope.preloader = false;
					// called asynchronously if an error occurs
					// or server returns response with an error status.
				}
			);
		}
		if ($scope.identifyedQuery == "") {
			if (s == -1)
				$scope.queryError[k] = $sce.trustAsHtml(
					"<h4>Statement was not written in Standard SQL format.</h4><div>Check for syntax mistake, spelling mistake, SQL Format etc.<br><br><br></div>"
				);
			else
				$scope.querySameError[k][s] = $sce.trustAsHtml(
					"<h4>Statement was not written in Standard SQL format.</h4><div>Check for syntax mistake, spelling mistake, SQL Format etc.<br><br><br></div>"
				);
		}
	};
	$scope.loadAnswer = function (code, k, s = -1) {
		if (s == -1) $scope.mod_query_code[k] = code;
		else {
			$scope.mod_same_query_code[k] = [];
			$scope.mod_same_query_code[k][s] = code;
		}
	};
	$scope.loadResults = function (code, k, s = -1) {
		if (s == -1) $scope.descTab[k] = null;
		else {
			$scope.descSameTab[k] = [];
			$scope.descSameTab[k][s] = null;
		}
		$scope.preloader = true;
		// console.log($scope.querySameError.length, k);
		if (s == -1) $scope.queryError[k] = "";
		else if ($scope.querySameError.length > k) $scope.querySameError[k][s] = "";
		var dt = { section: 2, que: code };
		$http({
			method: "POST",
			url: $scope.base_url + "pdrill/runqs",
			data: dt,
			header: { "Content-Type": "application/x-www-form-urlencoded" },
		}).then(
			function successCallback(data) {
				// console.log(data['data']);
				if (s == -1) $scope.descTab[k] = data["data"];
				else $scope.descSameTab[k][s] = data["data"];
				$scope.preloader = false;
			},
			function errorCallback(res) {
				var er = res["data"];
				var pos1 = er.indexOf("<h1>");
				var pos2 = er.indexOf("</div>");
				// console.log(pos1, pos2);
				if (s == -1)
					$scope.descError[k] = $sce.trustAsHtml(er.substring(pos1, pos2));
				else
					$scope.descSameError[k][s] = $sce.trustAsHtml(
						er.substring(pos1, pos2)
					);
				$scope.preloader = false;
				// called asynchronously if an error occurs
				// or server returns response with an error status.
			}
		);
	};

	$scope.saveUserAnswer = function (k, s, txt) {
		if (txt) {
			var dt = { section: 5, pid: k, sid: s, cod: txt };
			$http({
				method: "POST",
				url: $scope.base_url + "pdrill/load_labs",
				data: dt,
				header: { "Content-Type": "application/x-www-form-urlencoded" },
			}).then(
				function successCallback(data) {
					var sv = data.data[0];
					if (sv == "Query Saved") alert("Answer Was Saved Successfully");
					else alert("Something went wrong!");
					$scope.preloader = false;
				},
				function errorCallback(res) {
					var er = res["data"];
					var pos1 = er.indexOf("<h1>");
					var pos2 = er.indexOf("</div>");
					log(er.substring(pos1, pos2));
					$scope.preloader = false;
					// called asynchronously if an error occurs
					// or server returns response with an error status.
				}
			);
		}
	};

	$scope.getAnswers = function (pid, ky, sk) {
		let dt = { section: 6, id: pid };
		$http({
			method: "POST",
			url: $scope.base_url + "pdrill/load_labs",
			data: dt,
			header: { "Content-Type": "application/x-www-form-urlencoded" },
		}).then(
			function (data) {
				let dts = data.data;
				// console.log(dts);
				$scope.mod_query_code[ky] = dts[0].codes;
				// console.log($scope.mod_query_code);
			},
			function (res) {
				console.error(res.data);
			}
		);
	};
	angular.element(document).ready(function () {
		// $scope.getAnswers();
	});

	$scope.analyzeStatement = function (cod) {
		$scope.identifyedQuery = null;
		var dt = { section: 3, que: cod };
		$http({
			method: "POST",
			url: $scope.base_url + "pdrill/runqs",
			data: dt,
			header: { "Content-Type": "application/x-www-form-urlencoded" },
		}).then(function (data) {
			var ddt = data.data;
			$scope.identifyedQuery = ddt;
		});
	};
});
