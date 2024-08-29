var app = angular.module('page_app', []);
app.controller('page_controller', function($scope, $http, $window){
  $scope.setlesson = function(itm){$scope.sellesson = itm;};
  $scope.setComponent = function(itm){
    $scope.selcomp = itm;
    var dt = $scope.lessonlist[$scope.sellesson].cont;
    if(itm==-1){
      $scope.comOrder = dt.length+1;
      $scope.comType = "text";
      $scope.comCont = '';
    }
    else {
      angular.forEach(dt, function(v, k){
        if(v['ltid']==itm) {
          $scope.comOrder = v['sequence'];
          $scope.comType = v['type'];
          $scope.comCont = v['detail'];
        }
      });
    }
  };
  $scope.setObjective = function(itm){
    $scope.selObject = itm;
    var dt = $scope.lessonlist[$scope.sellesson].objc;
    if(itm==-1){
      $scope.lesObOrder = dt.length+1;
      $scope.lesObjective = "";
    }
    else {
      angular.forEach(dt, function(v, k){
        if(v['obid']==itm) {
          $scope.lesObOrder = v['sequence'];
          $scope.lesObjective = v['title'];
        }
      });
    }
  };
  $scope.setlessonToEdit = function(itm){
    $scope.sellesson = itm;
    var dt = $scope.lessonlist[itm].dt;
    $scope.lesLevel = dt.level;
    $scope.lesTitle = dt.title;
    $scope.lesDescription = dt.details;
    $scope.activePage = 2;
  };

  $scope.loadLessons = function() {
    $scope.preloader = true;
    var dt = { section: 1 }
    $http({
      method: "POST", url:$scope.base_url+'adpro/ld_lesson', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      var dt = data.data;
      $scope.lessonlist = dt.lesson;
      console.log(dt);
      $scope.preloader = false;
    }, function errorCallback(res) {
      var er = res['data'];
      console.log(er);
      $scope.preloader = false;
    });
  }
  $scope.saveLessons = function(lev, tit, des, id) {
    $scope.preloader = true;
    var dt = { section: 2, lvl:lev, ttl:tit, dsc:des, lid: id }
    $http({
      method: "POST", url:$scope.base_url+'adpro/ld_lesson', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      var dt = data.data;
      console.log(dt);
      $scope.loadLessons();
      $scope.preloader = false;
    }, function errorCallback(res) {
      var er = res['data'];
      console.log(er);
      $scope.preloader = false;
    });
  }
  $scope.addObjective = function(tit, odr, lid, id) {
    $scope.preloader = true;
    var dt = { section: 3, ttl:tit, ord:odr, lsid: lid, orid:id }
    $http({
      method: "POST", url:$scope.base_url+'adpro/ld_lesson', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      var dt = data.data;
      console.log(dt);
      $scope.loadLessons();
      $scope.preloader = false;
    }, function errorCallback(res) {
      var er = res['data'];
      console.log(er);
      $scope.preloader = false;
    });
  }
  $scope.addLesCompnt = function(tp, tit, odr, id, tid) {
    $scope.preloader = true;
    var dt = { section: 4, typ:tp, ttl:tit, ord:odr, lid: id, ltid:tid }
    $http({
      method: "POST", url:$scope.base_url+'adpro/ld_lesson', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      var dt = data.data;
      console.log(dt);
      $scope.loadLessons();
      $scope.preloader = false;
    }, function errorCallback(res) {
      var er = res['data'];
      console.log(er);
      $scope.preloader = false;
    });
  }
});
