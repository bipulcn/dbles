var app = angular.module('page_app', []);
app.controller('page_controller', function($scope, $http, $window, $sce){
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
  $scope.lessonlst = "";

  $scope.setLesson = function(itm) { $scope.selLesson = itm; }
  $scope.setSection = function(itm) { 
    $scope.selSes = itm; 
    // let lst = $scope.group[itm].enable.split(","); 
    // $scope.simprob = [];
    // angular.forEach($scope.prob, (val, k) => {
    //   // console.log(lst.indexOf(k), lst, k);
    //   if(lst.indexOf(k)>-1) $scope.simprob[k] = val;
    // });
    $scope.loadUserList(itm);
  }
  $scope.loadProblems = function() {
    $scope.preloader = true;
    var dt = { section: 1 }
    $http({
      method: "POST", url:$scope.base_url+'adpro/load_pans', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      // $scope.user = data.data.user;
      $scope.prob = data.data.prob;
      $scope.group = data.data.group;
      // console.log(data.data);
      $scope.preloader = false;
    }, function errorCallback(res) {
      var er = res['data'];
      console.log(er);
      $scope.preloader = false;
    });
  }
  $scope.loadUserList = function(gpid) {
    let dt = {section: 4, gid: gpid}
    $http({
      method: "POST", url:$scope.base_url+'adpro/load_pans', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      $scope.user = data.data;
      // console.log($scope.user);
      $scope.preloader = false;
    })
  }
  $scope.loadUserAnswers = function(itm) {
    $scope.selUser = itm;
    angular.forEach($scope.user, function(v, k){
      if(v.uid==itm) $scope.selUserName = v.name;
    });
    var dt = { section: 2, uid:itm }
    $http({
      method: "POST", url:$scope.base_url+'adpro/load_pans', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      $scope.uanswer = data.data;
      // console.log(data.data);
      $scope.preloader = false;
    }, function errorCallback(res) {
      var er = res['data'];
      console.log(er);
      $scope.preloader = false;
    });
  }
  $scope.saveMarks = function(dts, mark) {
    var dt = { section: 3, uid:dts.uid, pid:dts.pid, spid: dts.spid, mrk: mark }
    $http({
      method: "POST", url:$scope.base_url+'adpro/load_pans', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      // console.log(data.data);
      $scope.loadUserAnswers(dts.uid);
      $scope.preloader = false;
    }, function errorCallback(res) {
      var er = res['data'];
      console.log(er);
      $scope.preloader = false;
    });
  }


  $scope.executeQuery = function(code, k, s=-1){
    if(s==-1) $scope.outputTab[k] = null;
    else {
      if(!$scope.outputSameTab[k]) $scope.outputSameTab[k] = [];
      $scope.outputSameTab[k][s] = [];
    }
    if(s==-1) $scope.queryError[k] = "";
    else {$scope.querySameError[k] = [];$scope.querySameError[k][s] = "";}
    // if(s==-1) code = $scope.mod_query_code[k];
    // else code = $scope.mod_same_query_code[k][s];
    if(code!=undefined){
    $scope.preloader = true;
    var dt = { section: 2, que:code }
    $http({
      method: "POST", url:$scope.base_url+'pdrill/runqs', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      // console.log(data['data']);
      if(s==-1) $scope.outputTab[k] = data['data'];
      else $scope.outputSameTab[k][s] = data['data'];
      $scope.preloader = false;
    }, function errorCallback(res) {
      var er = res['data'];
      var pos1 = er.indexOf('<h1>');
      var pos2 = er.indexOf('</div>');
      console.log(pos1, pos2);
      if(s==-1) $scope.queryError[k] = $sce.trustAsHtml(er.substring(pos1, pos2));
      else $scope.querySameError[k][s] = $sce.trustAsHtml(er.substring(pos1, pos2));
      $scope.preloader = false;
        // called asynchronously if an error occurs
        // or server returns response with an error status.
    });}
  }
  $scope.loadResults = function(code, k, s=-1){
    if(s==-1) $scope.descTab[k] = null;
    else {$scope.descSameTab[k] = []; $scope.descSameTab[k][s] = null;}
    $scope.preloader = true;
    if(s==-1) $scope.queryError[k] = "";
    else $scope.querySameError[k][s] = "";
    var dt = { section: 2, que:code }
    $http({
      method: "POST", url:$scope.base_url+'pdrill/runqs', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      // console.log(data['data']);
      if(s==-1) $scope.descTab[k] = data['data'];
      else $scope.descSameTab[k][s] = data['data'];
      $scope.preloader = false;

    }, function errorCallback(res) {
      var er = res['data'];
      var pos1 = er.indexOf('<h1>');
      var pos2 = er.indexOf('</div>');
      console.log(pos1, pos2);
      if(s==-1) $scope.descError[k] = $sce.trustAsHtml(er.substring(pos1, pos2));
      else $scope.descSameError[k][s] = $sce.trustAsHtml(er.substring(pos1, pos2));
      $scope.preloader = false;
        // called asynchronously if an error occurs
        // or server returns response with an error status.
    });
  }

});
