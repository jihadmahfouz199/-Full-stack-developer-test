var myApp = angular.module('myApp', [
    'ngRoute',
    'itemsControllers',
    'angularFileUpload'
]);

myApp.config(['$routeProvider', function ($routeProvider) {
    $routeProvider.when('/items', {
        templateUrl: 'app/views/items.html',
        controller: 'itemsController'
    }).when('/items/add', {
        templateUrl: 'app/views/add-item.html',
        controller: 'addItemController'
    }).otherwise({
        redirectTo: '/items'
    });
}]);