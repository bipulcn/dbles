var app = angular.module('page_app', []);
app.controller('page_controller', function($scope, $http, $window){
  $scope.exTitl = [];
  $scope.selProblms = [];

  $scope.setExam = function(itm) {
    $scope.selExam = itm;
    let dt = { section: 4, eid: itm };
    $http({
      method: "POST", url:$scope.base_url+'adpro/lod_eres', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      $scope.user = data.data.user;
      $scope.result = data.data.result;
      $scope.selProblms = data.data.prob;
      // console.log(data.data);
      $scope.preloader = false;
    }, function errorCallback(res) {
      console.log(res.data);
      $scope.preloader = false;
    });
  }
  $scope.setSection = function(itm) {
    $scope.selSes = itm;
    $scope.exTitl = $scope.prob[itm];
  }
  $scope.loadProblems = function() {
    $scope.preloader = true;
    var dt = { section: 1 }
    $http({
      method: "POST", url:$scope.base_url+'adpro/lod_eres', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      $scope.prob = data.data.prob;
      $scope.group = data.data.group;
      // console.log(data.data);
      $scope.preloader = false;
    }, function errorCallback(res) {
      console.log(res.data);
      $scope.preloader = false;
    });
  }
});
