var app = angular.module('page_app', []);
app.controller('page_controller', function($scope, $http, $window){
  $scope.test = "test name";

  $scope.executeQuery = function(){
    $scope.preloader = true;
    var dt = { section: 2, que:$scope.mod_query_code }
    $http({
      method: "POST", url:$scope.base_url+'manus/mandrill/prac', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      $scope.preloader = false;
    }, function errorCallback(res) {
      var er = res['data'];
      console.log(er);
      $scope.preloader = false;
        // called asynchronously if an error occurs
        // or server returns response with an error status.
    });
  };
});
