var app = angular.module('page_app', []);
app.controller('page_controller', ['$scope', '$http', function($scope, $http){
  $scope.selSur = "";
  $scope.qs_enable = true;
  // $scope.setlesson = function(itm){$scope.sellesson = itm;};
  // $scope.setlessonToEdit = function(itm){$scope.sellesson = itm;};

  $scope.loadSurvey = function() {
    $scope.preloader = true;
    var dt = { section: 1 }
    $http({
      method: "POST", url:$scope.base_url+'adpro/db_survey', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      var dt = data.data;
      $scope.survey = dt.survey;
      $scope.qus = dt.question;
      $scope.ans = dt.answer;
      $scope.preloader = false;
    }, function errorCallback(res) {
      var er = res['data'];
      console.log(er);
      $scope.preloader = false;
    });
  };
  $scope.saveSurvey = function(itm, etit, btit, detl, enbl) {
    $scope.preloader = true;
    var esid = 0;
    if (itm==1) {
      esid = $scope.selSur;
    }
    var dt = { section: 2, ett:etit, btt:btit, dtl:detl, enb:enbl, sid: esid }
    console.log(dt);
    if (typeof etit !== 'undefined')
    $http({
      method: "POST", url:$scope.base_url+'adpro/db_survey', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      var dt = data.data;
      console.log(dt);
      $scope.preloader = false;
      $scope.loadSurvey();
    }, function errorCallback(res) {
      var er = res['data'];
      console.log(er);
      $scope.preloader = false;
    });
  };
  $scope.saveSurveyQuestions = function(itm, etit, btit, detl, cnb) {
    $scope.preloader = true;
    var eqid = 0;
    if(itm==1) eqid = $scope.selQus;
    var dt = { section: 3, sid: $scope.selSur, ett:etit, btt:btit, dtl:detl, qid: eqid, enb: cnb }
    $http({
      method: "POST", url:$scope.base_url+'adpro/db_survey', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      var dt = data.data;
      $scope.qs_etitle = "";
      $scope.qs_btitle = "";
      $scope.qs_detail = "";
      $scope.qs_enable = false;
      $scope.preloader = false;
      $scope.loadSurvey();
    }, function errorCallback(res) {
      var er = res['data'];
      console.log(er);
      $scope.preloader = false;
    });
  };
  $scope.selectSurvey = function(itm) {
    $scope.selSur = itm;
    $scope.enbAE = true;
    if (itm=="") {
      $scope.sv_etitle = "";
      $scope.sv_btitle = "";
      $scope.sv_detail = "";
      $scope.sv_enable = "";
    }
    angular.forEach($scope.survey, function(v, k){
      if (v.fbkid==itm) {
        $scope.sv_etitle = v.etitle;
        $scope.sv_btitle = v.btitle;
        $scope.sv_detail = v.detail;
        $scope.sv_enable = v.active;
      }
    });
  };
  $scope.selectQuestion = function(itm) {
    $scope.selQus = itm;
    $scope.enbAE = false;
    angular.forEach($scope.qus[$scope.selSur], function(v, k){
      if (v.fbqid==itm) {
        $scope.qs_etitle = v.etitle;
        $scope.qs_btitle = v.btitle;
        $scope.qs_detail = v.detail;
        $scope.qs_enable = (v.cenble=='T')? true: false;
      }
    });
    if (itm==0) {
      $scope.qs_etitle = "";
      $scope.qs_btitle = "";
      $scope.qs_detail = "";
      $scope.qs_enable = false;
    }
  };
}]);
