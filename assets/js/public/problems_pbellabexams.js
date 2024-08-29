var app = angular.module('page_app', []);
app.controller('page_controller', function($scope, $http, $window, $sce){
  $scope.mod_query_code = [];
  $scope.queryError = [];
  $scope.outputTab = [];
  $scope.descTab = [];
  $scope.queryError = [];
  $scope.descError = [];
  $scope.selSchema = "HR Schema";
  $scope.problemrefe = [];
  $scope.tableCheck = [];
  $scope.modLess = 1;
  $scope.probindex = [];

  $scope.selectSchema1 = function(itm) { $scope.selSchema1 = itm; }
  $scope.selectSchema2 = function(itm) { $scope.selSchema2 = itm; }
  $scope.setLesson = function() { $scope.selExam = $scope.modLess; $scope.loadProblemList($scope.modLess); }
  $scope.shortcutKey = function(keyEvent, itm, s=-1) {
    if (keyEvent.which === 10) $scope.executeQuery(itm, s);
  }

  $scope.addForProblem = function(itm, sc) {
    $scope.problemrefe[itm] = [];
    angular.forEach($scope.schema[sc].data, function(v, k){
      if($scope.tableCheck[k]) {
        $scope.problemrefe[itm].push({'schema': sc, 'table':k});
      }
    });
    // console.log($scope.problemrefe);
  }
  $scope.checkFK = function(itm) {
    var eist = false;
    angular.forEach($scope.schema[$scope.selSchema1].fk, function(v, k){
      if (v==itm) eist = true;
    });
    return eist;
  }
  $scope.loadLessons = function() {
    $scope.preloader = true;
    var dt = { section: 1 }
    $http({
      method: "POST", url:$scope.base_url+'pdrill/load_exam', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      // let ls = [];
      $scope.exmlist = data.data.exmList;
      // angular.forEach($scope.exmlist, function(v, k){
      //   console.log(k);
      //   angular.forEach(v.quiz, function(sv, sk){
      //     console.log(sv);
      //     ls.push(sv.pid);
      //   });
      // })
      // console.log(ls.join(','));
      // $scope.loadAnswers(ls.join(','));
      $scope.schema = data.data.schema;
      $scope.preloader = false;
    }, function errorCallback(res) {
      var er = res['data'];
      console.log(er);
      $scope.preloader = false;
    });
  }
  $scope.loadAnswers = function(pids) {
    $scope.preloader = true;
    var dt = { section: 3, pid: pids }
    $http({
      method: "POST", url:$scope.base_url+'pdrill/load_exam', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      // console.log(data.data);
      $scope.preloader = false;
    }, function errorCallback(res) {
      var er = res['data'];
      console.log(er);
      $scope.preloader = false;
    });
  }
  $scope.loadProblemList = function(itm) {
    $scope.problemrefe = [];
    $scope.problemlist = $scope.exmlist[itm].quiz;
    angular.forEach($scope.problemlist, function(v, k){ $scope.problemrefe.push(k); $scope.problemrefe[k] = []; });
    // console.log($scope.problemlist);
  }
  $scope.loadTableInfo = function(itm) {
    var code = "DESC "+itm;
    var dt = { section: 2, que:code }
    $http({
      method: "POST", url:$scope.base_url+'pdrill/runqs', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      // console.log(data.data);
      $scope.tableInfos = data.data;
      $scope.preloader = false;
    }, function errorCallback(res) {
      var er = res['data'];
      var pos1 = er.indexOf('<h1>');
      var pos2 = er.indexOf('</div>');
      // console.log(pos1, pos2);
      $scope.queryError[k] = $sce.trustAsHtml(er.substring(pos1, pos2));
      $scope.preloader = false;
    });
  }
  $scope.executeQuery = function(k){
    $scope.outputTab[k] = null;
    $scope.queryError[k] = "";
    var code = $scope.mod_query_code[k];
    if(code!=undefined){
      $scope.preloader = true;
      var dt = { section: 2, que:code }
      $http({
        method: "POST", url:$scope.base_url+'pdrill/runqs', data: dt,
        header: {'Content-Type': 'application/x-www-form-urlencoded'}
      }).then(function successCallback(data) {
        $scope.outputTab[k] = data['data'];
        $scope.preloader = false;
      }, function errorCallback(res) {
        var er = res['data'];
        er = er.replace('temporary', '');
        var pos1 = er.indexOf('<h1>');
        var pos2 = er.indexOf('</div>');
        // console.log(pos1, pos2);
        $scope.queryError[k] = $sce.trustAsHtml(er.substring(pos1, pos2));
        $scope.preloader = false;
      });
    }
    if ($scope.identifyedQuery=="") {
      $scope.queryError[k] = $sce.trustAsHtml("<h4>Statement was not written in Standard SQL format.</h4><div>Check for syntax mistake, spelling mistake, SQL Format etc.<br><br><br></div>");
    }
  }
  $scope.loadResults = function(code, k, s=-1){
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
      // console.log(pos1, pos2);
      $scope.descError[k] = $sce.trustAsHtml(er.substring(pos1, pos2));
      $scope.preloader = false;
    });
  }

  $scope.saveUserAnswer = function(k, txt){
    if(txt) {
      var dt = { section: 5, pid:k, eid: $scope.selExam, cod: txt }
      $http({
        method: "POST", url:$scope.base_url+'pdrill/load_exam', data: dt,
        header: {'Content-Type': 'application/x-www-form-urlencoded'}
      }).then(function successCallback(data) {
        var sv = data.data[0]
        if(sv=="Query Saved") alert("Answer Was Saved Successfully");
        else alert("Something went wrong!");
        $scope.preloader = false;
      }, function errorCallback(res) {
        var er = res['data'];
        var pos1 = er.indexOf('<h1>');
        var pos2 = er.indexOf('</div>');
        log(er.substring(pos1, pos2));
        $scope.preloader = false;
      });
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
});
