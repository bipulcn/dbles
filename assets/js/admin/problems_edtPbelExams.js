var app = angular.module('page_app', []);
app.controller('page_controller', function($scope, $http, $window, $sce){
  $scope.selExam = 0;
  $scope.selProblem = 0;
  $scope.qs_enable = false;
  $scope.exmMrk = 10;
  $scope.qs_marks = 50;
  $scope.activeTab = 1;

  $scope.loadExamContents = function() {
    $scope.preloader = true;
    var dt = {section: 1};
    $http({
      method: "POST", url:$scope.base_url+'adpro/load_exam', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      var rs = data.data;
      console.log(rs);
      $scope.group = rs.group;
      $scope.qsets = rs.qsets;
      $scope.eqlist = rs.eqlist;
      $scope.eqalist = rs.eqasign;
      $scope.preloader = false;
    }, function errorCallback(res) {
      var er = res['data'];
      console.log(er);
    });
  };

  $scope.saveNewExam = function() {
    $scope.preloader = true;
    var dt = {section: 2, eid:$scope.selExam, ttl:$scope.qs_title, enb:$scope.qs_enable, grp:$scope.qs_sgroup, mrk:$scope.qs_marks};
    console.log(dt);
    $http({
      method: "POST", url:$scope.base_url+'adpro/load_exam', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      console.log(data.data);
      $scope.loadExamContents();
      $scope.qs_title = "";
      $scope.qs_enable = false;
      $scope.qs_sgroup = "";
      $scope.qs_marks = "";
      $scope.preloader = false;
    }, function errorCallback(res) {
      var er = res['data'];
      console.log(er);
    });
  }

  $scope.setProblemToEdit = function(itm, num) {
    var dts = $scope.eqlist[itm][num];
    $scope.selProblem = dts.pid;
    $scope.pobtitle = dts.title;
    $scope.pobDesc = dts.details;
    $scope.pobSolut = dts.solution;
  }

  $scope.loadExistExam = function(itm, key) {
    angular.forEach($scope.qsets[itm], function(v, k){
      if(v.eid==key) {
        console.log(v);
        $scope.selExam = v.eid;
        $scope.qs_title = v.title;
        $scope.qs_enable = (v.enable==1)? true: false;
        $scope.qs_sgroup = v.section_id;
        $scope.qs_marks = v.marks;
      }
    });
  }

  $scope.saveProblemData = function(titl, dsc, sol, pid) {
    var dt, msg;
    dt = { section: 3, title:titl, detl:dsc, cod:sol, eid:$scope.selExam, id: pid };
    msg = "Do You want create problem \""+titl+"\"";
    if(confirm(msg))
    {
      $http({
        method: "POST", url:$scope.base_url+'adpro/load_exam', data: dt,
        header: {'Content-Type': 'application/x-www-form-urlencoded'}
      }).then(function successCallback(data) {
        $scope.selProblem = data.data;
        $scope.loadExamContents();
        $scope.preloader = false;
      }, function errorCallback(res) {
        var er = res['data'];
        console.log(er);
        $scope.preloader = false;
      });
    }
  }
  $scope.addExamQues = function(mrks) {
    var dt = {section: 4, eid: $scope.selExam, pid:$scope.selProblem, mrk: mrks };
    $scope.preloader = true;
    $http({
      method: "POST", url:$scope.base_url+'adpro/load_exam', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      $scope.loadExamContents();
      $scope.preloader = false;
    }, function errorCallback(res) {
      var er = res['data'];
      console.log(er);
      $scope.preloader = false;
    });
  }
  $scope.removeProblem = function(ed, pd) {
    var dt = {section: 5, eid: ed, pid:pd };
    $scope.preloader = true;
    $http({
      method: "POST", url:$scope.base_url+'adpro/load_exam', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      $scope.loadExamContents();
      $scope.preloader = false;
    }, function errorCallback(res) {
      var er = res['data'];
      console.log(er);
      $scope.preloader = false;
    });
  }

  $scope.executeQuery = function(code){
    $scope.outputTab = null;
    $scope.queryError = "";
    if(code!=undefined){
      $scope.preloader = true;
      var dt = { section: 2, que:code }
      $http({
        method: "POST", url:$scope.base_url+'pdrill/runqs', data: dt,
        header: {'Content-Type': 'application/x-www-form-urlencoded'}
      }).then(function successCallback(data) {
        console.log(data['data']);
        $scope.outputTab = data['data'];
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
    if ($scope.identifyedQuery=="") {
      $scope.queryError = $sce.trustAsHtml("<h4>Statement was not written in Standard SQL format.</h4><div>Check for syntax mistake, spelling mistake, SQL Format etc.<br><br><br></div>");
    }
  }

  $scope.analyzeStatement = function(cod) {
    $scope.identifyedQuery = null;
    var dt = { section: 3, que:cod }
    $http({
      method: "POST", url:$scope.base_url+'pdrill/runqs', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function (data) {
      var ddt = data.data;
      $scope.identifyedQuery = ddt;
      console.log(ddt);
    });
  }
});
