var app = angular.module('page_app', []);
app.controller('page_controller', function($scope, $http, $window){
  $scope.queryError = [];
  $scope.outputSameTab = [];
  $scope.outputSameTab[0] = [];
  $scope.outputTab = [];
  $scope.descSameTab = [];
  $scope.descSameTab[0] = [];
  $scope.querySameError = [];
  $scope.descSameError = [];
  $scope.querySameError[0] = [];
  $scope.descSameError[0] = [];
  $scope.descTab = [];
  $scope.queryError = [];
  $scope.descError = [];
  $scope.selSes = "";

  $scope.setLesson = function(itm) { $scope.selLesson = itm; $scope.loadResult(); }
  $scope.setSection = function(itm) { $scope.selSes = itm; 
    // $scope.group.forEach((v, k) => {
    //   if(v.sgid==itm) $scope.secList = v.enable;
    // });
    $scope.loadProblems(); 
  }
  $scope.loadGroups = function() {
    $scope.preloader = true;
    var dt = { section: 1 }
    $http({
      method: "POST", url:$scope.base_url+'adpro/lod_res', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      $scope.group = data.data;
      $scope.preloader = false;
    }, function errorCallback(res) {
      var er = res['data'];
      console.log(er);
      $scope.preloader = false;
    });
  }
  $scope.loadProblems = function() {
    $scope.preloader = true;
    var dt = { section: 6 }
    $http({
      method: "POST", url:$scope.base_url+'adpro/lod_res', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      $scope.prob = data.data;
      $scope.preloader = false;
      $scope.loadUsers();
    }, function errorCallback(res) {
      var er = res['data'];
      console.log(er);
      $scope.preloader = false;
    });
  }
  $scope.loadUsers = function() {
    $scope.preloader = true;
    var dt = { section: 4, sec: $scope.selSes }
    console.log(dt);
    $http({
      method: "POST", url:$scope.base_url+'adpro/lod_res', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      $scope.user = data.data;
      $scope.preloader = false;
    }, function errorCallback(res) {
      var er = res['data'];
      console.log(er);
      $scope.preloader = false;
    });
  }
  $scope.loadResult = function() {
    $scope.preloader = true;
    var dt = { section: 5, les: $scope.selLesson }
    $http({
      method: "POST", url:$scope.base_url+'adpro/lod_res', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      $scope.result = data.data;
      // console.log(data.data);
      $scope.preloader = false;
    }, function errorCallback(res) {
      var er = res['data'];
      console.log(er);
      $scope.preloader = false;
    });
  }
  angular.element("document").ready(function () {
    $scope.loadGroups();
  });

});
