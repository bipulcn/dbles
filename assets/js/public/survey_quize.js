var app = angular.module('page_app', []);
app.controller('page_controller', function($scope, $http, $window){
  $scope.options = [];
  $scope.comment = [];
  $scope.curent = 1;

  angular.element("document").ready(function () {
    $scope.executeQuery($scope.sid);
  });
  $scope.executeQuery = function(itm){
    $scope.preloader = true;
    var dt = { section: 1, sid:itm }
    console.log(dt);
    $http({
      method: "POST", url:$scope.base_url+'pdrill/load_srvy', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      var dts = data.data;
      console.log(dts.question);
      $scope.survey = dts.survey;
      $scope.ques = dts.question;
      $scope.answers = dts.answer;
      $scope.opts = dts.opts;
      $scope.nques = [];
      var keys = Object.keys($scope.ques);
      var len = keys.length;
      $scope.numques = len;
      for (var i = 1; i <= len; i++) {
        $scope.nques.push(i+0);
      }
      $scope.preloader = false;
    }, function errorCallback(res) {
      var er = res['data'];
      console.log(er);
      $scope.preloader = false;
        // called asynchronously if an error occurs
        // or server returns response with an error status.
    });
  };
  $scope.setCurrent = function(itm){ $scope.curent=parseInt(itm); console.log(parseInt(itm));}
  $scope.saveChoice = function(itm) {
    $scope.curent += 1;
    var choic = 0;
    var comnt = "";
    if($scope.options[itm])
      choic = 7-$scope.options[itm];
    if($scope.comment[itm])
      comnt = $scope.comment[itm];
    console.log($scope.curent+" and ");
    $scope.preloader = true;
    var dt = { section: 2, qid:itm, ans:choic, cmt: comnt, sid:$scope.sid }
    $http({
      method: "POST", url:$scope.base_url+'pdrill/load_srvy', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      var dts = data.data;
      console.log(dts);
      $scope.preloader = false;
    }, function errorCallback(res) {
      var er = res['data'];
      console.log(er);
      $scope.preloader = false;
    });
    if($scope.curent>$scope.numques){
      var dte = { section: 3, sid:$scope.sid }
      $http({
        method: "POST", url:$scope.base_url+'pdrill/load_srvy', data: dte,
        header: {'Content-Type': 'application/x-www-form-urlencoded'}
      }).then(function successCallback(data) {
        var dts = data.data;
        console.log(dts);
        $scope.preloader = false;
      }, function errorCallback(res) {
        var er = res['data'];
        console.log(er);
        $scope.preloader = false;
      });
    }
  }
});
