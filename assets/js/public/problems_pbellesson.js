var app = angular.module('page_app', []);
app.controller('page_controller', function($scope, $http, $window, $sce){

  $scope.loadLessons = function() {
    $scope.preloader = true;
    var dt = { section: 1 }
    $http({
      method: "POST", url:$scope.base_url+'pdrill/load_dril', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      $scope.lessonlist = data.data.lesson;
      $scope.schema = data.data.schema;
      $scope.preloader = false;
      $scope.loadProblemList(0);
    }, function errorCallback(res) {
      var er = res['data'];
      // console.log(er);
      $scope.preloader = false;
    });
  }
  $scope.loadProblemList = function(itm) {
    $scope.problemlist = $scope.lessonlist[itm].problems;
  }

	angular.element("document").ready(function () {
		$scope.loadHistory();
	});

  $scope.executeQuery = function(){
    $scope.outputTab = null;
    $scope.preloader = true;
    $scope.queryError = "";
    var dt = { section: 2, que:$scope.mod_query_code }
    $http({
      method: "POST", url:$scope.base_url+'pdrill/runqs', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      // console.log(data['data']);
      $scope.outputTab = data['data'];
      $scope.preloader = false;
      $scope.loadHistory();
    }, function errorCallback(res) {
      var er = res['data'];
      var pos1 = er.indexOf('<h1>');
      var pos2 = er.indexOf('</div>');
      // console.log(pos1, pos2);
      $scope.queryError = $sce.trustAsHtml(er.substring(pos1, pos2));
      $scope.preloader = false;
        // called asynchronously if an error occurs
        // or server returns response with an error status.
    });
  }
  $scope.analyzeStatement = function() {
    // $scope.preloader = true;
    var dt = { section: 3, que:$scope.mod_query_code }
    $http({
      method: "POST", url:$scope.base_url+'pdrill/runqs', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function (data) {
      $scope.queryTypes = data['data'];
      // $scope.preloader = false;
      // console.log(data['data']);
    });
  }

  $scope.loadTabInfo = function(itm) {
    // if (itm==$scope.selTab || itm==null) {
    //   $scope.selTab = "";
    //   $scope.dataTab = null;
    //   $scope.descTab = null;
    // }
    // else {
      $scope.preloader = true;
      $scope.selTab = itm;
      var qurt = "SELECT * FROM "+itm;
      var dt = { section: 2, que:qurt }
      $http({
        method: "POST", url:$scope.base_url+'pdrill/runqs', data: dt,
        header: {'Content-Type': 'application/x-www-form-urlencoded'}
      }).then(function successCallback(data) {
        $scope.dataTab = data['data'];
        // console.log(data.data);
        $scope.preloader = false;
      });
      qurt = "DESC "+itm;
      var dt = { section: 2, que:qurt }
      $http({
        method: "POST", url:$scope.base_url+'pdrill/runqs', data: dt,
        header: {'Content-Type': 'application/x-www-form-urlencoded'}
      }).then(function successCallback(data) {
        $scope.descTab = data['data'];
        // console.log(data.data);
        $scope.preloader = false;
      });
    // }
  }
  $scope.loadHistory = function() {
    $scope.preloader = true;
    var dt = { section: 4 }
    $http({
      method: "POST", url:$scope.base_url+'pdrill/load_dril', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      var dt = data['data'];
      var ar = [];
      var nm = 0;
      angular.forEach(dt, function(v,k){
        ar.push({query:v});
        nm++;
      });
      $scope.preQuery = ar;
      $scope.preloader = false;
    }, function errorCallback(res) { console.log(res['data']); });
  }
});
