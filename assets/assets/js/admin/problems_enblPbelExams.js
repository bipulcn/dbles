var app = angular.module('page_app', []);
app.controller('page_controller', function($scope, $http, $window, $sce){
  $scope.selExam = 0;
  $scope.selProblem = 0;
  $scope.qs_enable = false;
  $scope.exmMrk = 10;
  $scope.qs_marks = 50;

  $scope.loadExamContents = function() {
    $scope.preloader = true;
    var dt = {section: 1};
    $http({
      method: "POST", url:$scope.base_url+'adpro/load_exam', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      var rs = data.data;
      $scope.group = rs.group;
      $scope.qsets = rs.qsets;
      $scope.preloader = false;
    }, function errorCallback(res) {
      var er = res['data'];
      console.log(er);
    });
  };

  $scope.saveNewExam = function() {
    $scope.preloader = true;
    var dt = {section: 1, eid:$scope.selExam, enb:$scope.qs_enable };
    $http({
      method: "POST", url:$scope.base_url+'adpro/enbl_exam', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      $scope.loadExamContents();
      $scope.preloader = false;
    }, function errorCallback(res) {
      var er = res['data'];
      console.log(er);
    });
  }

  $scope.loadExistExam = function(itm, key) {
    angular.forEach($scope.qsets[itm], function(v, k){
      if(v.eid==key) {
        $scope.selExam = v.eid;
        $scope.qs_title = v.title;
        $scope.qs_enable = (v.enable==1)? true: false;
        $scope.qs_sgroup = v.section_id;
        $scope.qs_marks = v.marks;
      }
    });
  }
});
