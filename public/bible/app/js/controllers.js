var bibleApp = angular.module('biblePlanApp', ['bibleServices']);

bibleApp.controller('bibleCtrl', ['$scope', 'Bible', function($scope, Bible) {
  $scope.days = Bible.query();
}]);