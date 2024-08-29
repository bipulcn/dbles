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

  $scope.exTitl = [];
  $scope.selProblms = [];
  $scope.selAnswers = [];

  $scope.setExam = function(itm) {
    $scope.selExam = itm;
    $scope.selProblms = [];
    angular.forEach($scope.prob[$scope.selSes], function(v, k){
      if(itm==v.data.eid){
        angular.forEach(v.prob, function(sv, sk) {
          var ans = [];
          angular.forEach(v.answer, function(a, ak){
            if(a.pid==sv.pid)
              ans[a.uid] = a;
          });
          $scope.selProblms.push({'data':sv, 'answer':ans});
        });
      }
    });
  }
  $scope.setSection = function(itm) {
    $scope.selSes = itm;
    $scope.exTitl = [];
    angular.forEach($scope.prob[itm], function(v, k){
      $scope.exTitl.push({'title':v.data.title, 'eid':v.data.eid});
    });
    $scope.loadUserList(itm);
  }
  $scope.loadUserList = function(gpid) {
    let dt = {section: 4, gid: gpid}
    $http({
      method: "POST", url:$scope.base_url+'adpro/load_eans', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      $scope.user = data.data;
      // console.log($scope.user);
      $scope.preloader = false;
    })
  }
  $scope.loadProblems = function() {
    $scope.preloader = true;
    var dt = { section: 1 }
    $http({
      method: "POST", url:$scope.base_url+'adpro/load_eans', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      // $scope.user = data.data.user;
      $scope.prob = data.data.prob;
      $scope.group = data.data.group;
      $scope.preloader = false;
    }, function errorCallback(res) {
      var er = res['data'];
      console.log(er);
      $scope.preloader = false;
    });
  }
  $scope.loadUserAnswers = function(itm) {
    $scope.selUser = itm;
    angular.forEach($scope.user, function(v, k){
      $scope.suid = itm;
      if(v.uid==itm) $scope.selUserName = v.name;
    });
    var dt = { section: 2, uid:itm }
    $http({
      method: "POST", url:$scope.base_url+'adpro/load_eans', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      $scope.uanswer = data.data;
      $scope.preloader = false;
    }, function errorCallback(res) {
      var er = res['data'];
      console.log(er);
      $scope.preloader = false;
    });
  }
  $scope.saveMarks = function(dts, mark) {
    var dt = { section: 3, uid:dts.uid, pid:dts.pid, eid: dts.eid, mrk: mark }
    $http({
      method: "POST", url:$scope.base_url+'adpro/load_eans', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      $scope.loadUserAnswers(dts.uid);
      angular.forEach($scope.selProblms, function(v,k){
        if(dts.pid==v.data.pid){
          $scope.selProblms[k].answer[dts.uid].marks = mark;
        }
      });
      $scope.preloader = false;
    }, function errorCallback(res) {
      var er = res['data'];
      console.log(er);
      $scope.preloader = false;
    });
  }


  $scope.executeQuery = function(code, k){
    // $scope.outputTab = [];
    $scope.queryError = "";
    if(code!=undefined){
      $scope.preloader = true;
      var dt = { section: 2, que:code }
      $http({
        method: "POST", url:$scope.base_url+'pdrill/runqs', data: dt,
        header: {'Content-Type': 'application/x-www-form-urlencoded'}
      }).then(function successCallback(data) {
        console.log(data.data);
        $scope.outputTab[k] = data['data'];
        $scope.preloader = false;
      }, function errorCallback(res) {
        var er = res['data'];
        var pos1 = er.indexOf('<h1>');
        var pos2 = er.indexOf('</div>');
        console.log(pos1, pos2);
        $scope.queryError = $sce.trustAsHtml(er.substring(pos1, pos2));
        $scope.preloader = false;
          // called asynchronously if an error occurs
          // or server returns response with an error status.
      });
    }
  }
  $scope.loadResults = function(code, k){
    $scope.descTab[k] = null;
    $scope.preloader = true;
    $scope.queryError[k] = "";
    var dt = { section: 2, que:code }
    $http({
      method: "POST", url:$scope.base_url+'pdrill/runqs', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      $scope.descTab[k] = data['data'];
      $scope.preloader = false;
    }, function errorCallback(res) {
      var er = res['data'];
      var pos1 = er.indexOf('<h1>');
      var pos2 = er.indexOf('</div>');
      console.log(pos1, pos2);
      $scope.descError[k] = $sce.trustAsHtml(er.substring(pos1, pos2));
      $scope.preloader = false;
        // called asynchronously if an error occurs
        // or server returns response with an error status.
    });
  }

});
