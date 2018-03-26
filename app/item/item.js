var itemsController = angular.module('itemsController', ['ngAnimate']);

itemsController.controller('ListController', ['$scope', '$http', function($scope, $http) {
    console.log(1)
	$http.get('js/data.json').success(function(data) {
		$scope.artists = data;
		$scope.artistOrder = 'name';
	});

}]);

itemsController.controller('managementController', ['$scope', '$http','$routeParams', function($scope, $http, $routeParams) {
    console.log(2)
	$http.get('js/data.json').success(function(data) {
		$scope.artists = data;
		$scope.whichItem = $routeParams.itemId;

		if ($routeParams.itemId > 0) {
			$scope.prevItem = Number($routeParams.itemId)-1;
		} else {
			$scope.prevItem = $scope.artists.length-1;
		}

		if ($routeParams.itemId < $scope.artists.length-1) {
			$scope.nextItem = Number($routeParams.itemId)+1;
		} else {
			$scope.nextItem = 0;
		}

	});

}]);

