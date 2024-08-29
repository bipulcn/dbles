var app = angular.module('page_app', []);
app.controller('page_controller', function($scope, $http, $window, $sce){
  $scope.selLesson = -1;
  $scope.selProblem = -1;
  $scope.gky = -1;
  $scope.pbids = [];

  $scope.setLesson = function(itm) {$scope.selLesson = itm; $scope.pdts = null; $scope.selProblem = -1; }
  $scope.setProblem = function(itm) {
    $scope.selProblem = itm;
    $scope.pdts = $scope.problemlist[$scope.selLesson].prob[itm];
  }
  $scope.enableToEdit = function() { $scope.activePage = 2; $scope.setProblemToEdit($scope.selProblem); }
  $scope.deleteProblem = function(id, sid) {
    $scope.preloader = true;
    var dt = { section: 4, pid:id, spid:sid }
    if(confirm("Do you really want to delete it?")){
      $http({
        method: "POST", url:$scope.base_url+'adpro/load_dril', data: dt,
        header: {'Content-Type': 'application/x-www-form-urlencoded'}
      }).then(function successCallback(data) {
        $scope.loadProblems();
        $scope.pdts = null;
        $scope.selProblem = -1;
        $scope.preloader = false;
      }, function errorCallback(res) {
        var er = res['data'];
        console.log(er);
        $scope.preloader = false;
      });
    }
  }
  $scope.setProblemToEdit = function(itm) {
    $scope.selProblem = itm;
    var dts = $scope.problemlist[$scope.selLesson].prob[itm];
    $scope.pdts = dts;
    $scope.pobtitle = dts.title;
    $scope.pobDesc = dts.details;
    $scope.pobSolut = dts.solution;
    $scope.senbs = (dts.senb=='T')? true: false;
  }
  $scope.loadSimilarContent = function(itm) {
    $scope.selSimilar = itm;
    var dts = $scope.problemlist[$scope.selLesson].prob[$scope.selProblem].sprob[itm];
    $scope.spDetail = dts.details;
    $scope.spSolution = dts.solution;
    console.log((dts.senb=='T')? true: false);
    $scope.senbs = (dts.senb=='T')? true: false;
  }
  $scope.loadProblems = function() {
    $scope.preloader = true;
    var dt = { section: 1 }
    $http({
      method: "POST", url:$scope.base_url+'adpro/load_dril', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      $scope.problemlist = data.data;
      $scope.preloader = false;
    }, function errorCallback(res) {
      var er = res['data'];
      console.log(er);
      $scope.preloader = false;
    });
  }
  $scope.saveProblemData = function(titl, dsc, sol, enb, typ) {
    var dt, msg;
    if(typ==0) {
      dt = { section: 2, title:titl, detl:dsc, cod:sol, lid:$scope.selLesson, pid:$scope.problemlist[$scope.selLesson].prob[$scope.selProblem].pid, senb:enb };
      msg = "Do You want to update problem \""+titl+"\"";
    }
    else {
      dt = { section: 2, title:titl, detl:dsc, cod:sol, lid:$scope.selLesson, pid:-1, senb:enb };
      msg = "Do You want create problem \""+titl+"\"";
    }
    if(confirm(msg))
    {
      $http({
        method: "POST", url:$scope.base_url+'adpro/load_dril', data: dt,
        header: {'Content-Type': 'application/x-www-form-urlencoded'}
      }).then(function successCallback(data) {
        $scope.loadProblems();
        $scope.preloader = false;
      }, function errorCallback(res) {
        var er = res['data'];
        console.log(er);
        $scope.preloader = false;
      });
    }
  }
  $scope.saveSimProblemData = function(dsc, sol, typ, eb) {
    var dt, msg;
    var prid = $scope.problemlist[$scope.selLesson].prob[$scope.selProblem].pid;
    if(typ==0) {
      spid = $scope.problemlist[$scope.selLesson].prob[$scope.selProblem].sprob[$scope.selSimilar].spid;
      dt = { section: 3, detl:dsc, cod:sol, pid:prid, sid:spid, enb:eb };
      msg = "Do You want to update similar problem ";
    }
    else {
      dt = { section: 3, detl:dsc, cod:sol, pid:prid, sid:-1, enb:eb };
      msg = "Do You want create similar problem";
    }
    if(confirm(msg))  {
      $http({
        method: "POST", url:$scope.base_url+'adpro/load_dril', data: dt,
        header: {'Content-Type': 'application/x-www-form-urlencoded'}
      }).then(function successCallback(data) {
        $scope.loadProblems();
        $scope.setProblemToEdit($scope.selProblem)
        $scope.preloader = false;
      }, function errorCallback(res) {
        var er = res['data'];
        console.log(er);
        $scope.preloader = false;
      });
    }
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
      });}
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
    });
  }

  $scope.loadGroup = function() {
    $scope.preloader = true;
    var dt = { section: 5 }
    $http({
      method: "POST", url:$scope.base_url+'adpro/load_dril', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      let rdt = data.data;
      // console.log(rdt);
      $scope.group = rdt.group;
      $scope.preloader = false;
    }, function errorCallback(res) {
      var er = res['data'];
      console.log(er);
      $scope.preloader = false;
    });
  }
  $scope.setKey = function(k) {
    angular.forEach($scope.pbids, function(v, k){
      $scope.pbids[k] = false;
    });
    $scope.gky = k;
    let str = $scope.group[k]['enable'];
    if(str != null){
      let opt = str.split(',');
      angular.forEach(opt, function(v, k){
        $scope.pbids[v] = true;
      });
    }
  }
  $scope.enableList = function(k) { $scope.pbids[k] = !$scope.pbids[k]; }
  $scope.saveEanbled = function() {
    let ops = [];
    angular.forEach($scope.pbids, function(v, k){
      if(v) ops.push(k);
    });
    let str = ops.join(',');
    $scope.preloader = true;
    var dt = { section: 6, gid: $scope.group[$scope.gky].sgid, enb:str }
    $http({
      method: "POST", url:$scope.base_url+'adpro/load_dril', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      let rdt = data.data;
      $scope.loadGroup();
      $scope.preloader = false;
    }, function errorCallback(res) { var er = res['data']; console.log(er); $scope.preloader = false; });
  }
});
