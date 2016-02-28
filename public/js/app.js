var app = angular.module('UrlShortner', ['ngMaterial', 'ngMessages']);

app.controller('AppCtrl',['$http','$scope', '$log',function($http, $scope, $log){
	//holds urls
	$scope.siteurl = "http://";
	//submit this url for shortening
	$scope.submitURL = function(){
	
	}
}]);