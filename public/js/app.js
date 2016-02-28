var app = angular.module('UrlShortner', ['ngMaterial', 'ngMessages']);

app.controller('AppCtrl',['$http','$scope', '$log', '$httpParamSerializerJQLike',
 	function($http, $scope, $log, $httpParamSerializerJQLike){
		//holds urls
		$scope.siteurl = "http://";
		//submit this url for shortening
		$scope.submitURL = function(){
			$scope.isShortening = true;
			var data = {
				'siteurl' : $scope.siteurl
			}
			//send ajax request
			$http({
				method: 'POST',
				url: 'index.php',
				data: $httpParamSerializerJQLike(data),
				headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			}).success(function(response){
				$log.info(response);
				$scope.isShortening = false;
			}).error(function(response){
				$scope.isShortening = false;
			});
		}
	}
]);