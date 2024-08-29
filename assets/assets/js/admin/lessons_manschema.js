var app = angular.module('page_app', []);
app.controller('page_controller', function($scope, $http, $window){
  $scope.setlesson = function(itm){$scope.sellesson = itm;};
  $scope.setlessonToEdit = function(itm){$scope.sellesson = itm;};

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
});
