var app = angular.module('page_app', []);
app.controller('page_controller', ['$scope', '$http', function($scope, $http){
  $scope.selSur = "";
  $scope.qs_enable = false;

  $scope.loadSurvey = function() {
    $scope.preloader = true;
    $scope.serLoad = -1;
    var dt = { section: 1 }
    $http({
      method: "POST", url:$scope.base_url+'adpro/db_surres', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      var dt = data.data;
      // console.log(dt);
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
  $scope.loadAnswers = function(ssid) {
    $scope.preloader = true;
    $scope.serLoad = ssid;
    var dt = { section: 2, sid:ssid }
    $http({
      method: "POST", url:$scope.base_url+'adpro/db_surres', data: dt,
      header: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function successCallback(data) {
      var dt = data.data;
      $scope.ans = dt;
      // console.log($scope.ans);
      $scope.preloader = false;
    }, function errorCallback(res) {
      var er = res['data'];
      console.log(er);
      $scope.preloader = false;
    });
  };

  $scope.loadGraph = function(id) {
    $scope.selQus = id;
    let obj = $scope.ans.qus[id];
    // let data = ["Disagree Strongly", "Disagree Moderately", "Disagree Slightly", "Neither Agree nor Disagree", "Agree Slightly", "Agree Moderately", "Agree Strongly"];
    let res = [0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0];
    angular.forEach(obj.ans, function(v, k){
      res[v] += 1;
    });
    // console.log(res, obj.ans);
    google.charts.load('current', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawChart);

    // Callback that creates and populates a data table,
    // instantiates the pie chart, passes in the data and
    // draws it.
    function drawChart() {

      // Create the data table.
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Kinds');
      data.addColumn('number', 'Answer');
      data.addRows([
        ["Disagree Strongly", res[0]],
        ["Disagree Moderately", res[1]],
        ["Disagree Slightly", res[2]],
        ["Neither Agree nor Disagree", res[3]],
        ["Agree Slightly", res[4]],
        ["Agree Moderately", res[5]],
        ["Agree Strongly", res[6]]
      ]);

      // Set chart options
      var options = {'title':obj.title.e, 'width':'100%', 'height':500};

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
      // Wait for the chart to finish drawing before calling the getImageURI() method.
      google.visualization.events.addListener(chart, 'ready', function () {
        document.getElementById('image_div').innerHTML = '<img src="' + chart.getImageURI() + '" style="width: 100%;">';
      });
      chart.draw(data, options);
    }
  }
  $scope.saveImageToFile = function() {
    let chart = document.getElementById('chart_div');
  }
  $scope.selectSurvey = function(itm) {
    $scope.selSur = itm;
    $scope.enbAE = true;
    $scope.loadAnswers(itm);
  };

}]);
