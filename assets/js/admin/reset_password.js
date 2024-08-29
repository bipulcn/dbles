var app = angular.module('page_app', []);
app.controller('page_controller', function($scope, $http, $window){
  $scope.search = "";

  $scope.searchUser = function(){
    $scope.preloader = true;
    var dt = { section: 1, serc: $scope.search }
    $http({
      method: "POST", url: $scope.base_url +'auser/db_password', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      $scope.userlst = data.data;
      $scope.preloader = false;
    }, function errorCallback(res) {
      $scope.preloader = false;
    });
  };

  $scope.selectUser = function(dt){
    $scope.selUser = dt;
    $scope.preloader = true;
    var dt = { section: 5, uid: $scope.selUser.uid }
    $http({
      method: "POST", url: $scope.base_url + 'auser/db_password', data: dt,
      header: { 'Content-Type': 'application/x-www-form-urlencoded' }
    }).then(function successCallback(data) {
      $scope.actInfo = data.data.trk;
      $scope.ansInfo = data.data.ans;
      $scope.preloader = false;
    }, function errorCallback(res) {
      $scope.preloader = false;
    });
  }
  $scope.resetPassword = function(){
    $scope.preloader = true;
    var dt = {  section: 12, uid: $scope.selUser.uid, pass: $scope.rg_pas }
    if (confirm("Do you really want to update the password?")){
      $http({
        method: "POST", url: $scope.base_url + "puser/regdb", data: dt,
        header: { 'Content-Type': 'application/x-www-form-urlencoded' }
      }).then(function successCallback(data) {
        if(data.data[0]==1) alert("Password Reseted");
        else alert("Failed to update password");
        $scope.preloader = false;
      }, function errorCallback(res) {
        $scope.preloader = false;
      });
    }
  }
  
  $scope.checkPassword = function(){
    $scope.preloader = true;
    var dt = { section: 13, uid: $scope.selUser.uid, pass: $scope.ck_pas }
    $http({
      method: "POST", url: $scope.base_url + 'puser/regdb', data: dt,
      header: { 'Content-Type': 'application/x-www-form-urlencoded' }
    }).then(function successCallback(data) {
      if(data.data[0]==1) alert("Password is correct");
      else alert("Password is incorrect");
      $scope.preloader = false;
    }, function errorCallback(res) {
      $scope.preloader = false;
    });
  }

  $scope.deleteUser = function () {
    $scope.preloader = true;
    var dt = { section: 4, uid: $scope.selUser.uid }
    if (confirm("Do you want to delete the user?")) {
      $http({
        method: "POST", url: $scope.base_url + 'auser/db_password', data: dt,
        header: { 'Content-Type': 'application/x-www-form-urlencoded' }
      }).then(function successCallback(data) {
        if (data.data == "ok") alert("User was deleted");
        $scope.preloader = false;
      }, function errorCallback(res) {
        $scope.preloader = false;
      });
    }
  }
});
