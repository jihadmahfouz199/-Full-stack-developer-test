var itemsControllers = angular.module('itemsControllers', ['ngAnimate']);

itemsControllers.controller('itemsController', ['$scope', '$http', function ($scope, $http) {
    $http.get('backend/items').success(function (data) {
        if (data.status) {
            $scope.items = data.Data;
        }
    });
    $scope.reverse = true;
    $scope.reverseD = true;
    $http.get('backend/Welcome/tags_get').success(function (data) {
        $scope.currentTags = data;
    });

    $scope.sortName = function () {
        $scope.reverse = !$scope.reverse;
    }
    $scope.sortDescription = function () {
        $scope.reverseD = !$scope.reverseD;
    }

}]);

itemsControllers.controller('addItemController', ['$scope', '$http', '$routeParams', 'FileUploader', function ($scope, $http, $routeParams, FileUploader) {
    $scope.tags = ['bootstrap', 'list', 'angular'];
    $scope.allTags = ['bootstrap', 'list', 'angular', 'directive', 'edit', 'label', 'modal', 'close', 'button', 'grid', 'javascript', 'html', 'badge', 'dropdown'];

    var uploader = $scope.uploader = new FileUploader({
        url: 'backend/Welcome/uploadFile'
    });
    uploader.onCompleteItem = function (fileItem, response, status, headers) {
        if (response.is_done) {
            $scope.fileId = response.file_name;
        }
    };
    uploader.onAfterAddingFile = function (fileItem) {
        uploader.queue[0].upload();
    };

    $scope.addItem = function () {
        $http({
            method: 'POST',
            url: "backend/Welcome/addItem",
            data: {
                name: $scope.name,
                desc: $scope.description,
                image: $scope.fileId,
                tags: $scope.tags
            },
            headers: {'Content-Type': 'application/json'}
        }).success(function (response) {
            if (response.is_done) {

            } else {

            }
        }).error(function (response) {
        });
    }
    // $http.get('js/data.json').success(function (data) {
    //     $scope.artists = data;
    //     $scope.whichItem = $routeParams.itemId;
    //
    //     if ($routeParams.itemId > 0) {
    //         $scope.prevItem = Number($routeParams.itemId) - 1;
    //     } else {
    //         $scope.prevItem = $scope.artists.length - 1;
    //     }
    //
    //     if ($routeParams.itemId < $scope.artists.length - 1) {
    //         $scope.nextItem = Number($routeParams.itemId) + 1;
    //     } else {
    //         $scope.nextItem = 0;
    //     }
    //
    // });
}]);

