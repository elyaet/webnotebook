/**
 * Created by elyaet on 16/03/15.
 */
app.controller("webNotebookCtrl", function ($scope, $location, $http, $interval) {
    $scope.queue = {
        "data": {}
    };
    var inter;
    $scope.loading = true;
    $http.get('ctrl.php').success(function (data) {
        $scope.json = data;
        console.log($scope.json);
        $scope.updateCurrentNb();
        $scope.loading = false;
    });

    //$scope.currentNb = $scope.json.config.default;
    //$scope.htmlcontent = $scope.json.data[$scope.currentNb][$scope.currentDay.getFullYear()][$scope.currentDay.getMonth()+1][$scope.currentDay.getDate()];

    $scope.$on('$locationChangeStart', function (event) {
        $scope.updateCurrentNb();
    });

    $scope.updateCurrentNb = function () {
        var anchor = $location.url().substring(1);
        if ($scope.json) {
            angular.forEach($scope.json.data, function (value, key) {
                if (key == anchor) {
                    console.debug("Switch to " + anchor);
                    $scope.currentNb = anchor;
                }
            });
            if (anchor == "") {
                console.debug("Switch to " + $scope.json.config.default);
                $scope.currentNb = $scope.json.config.default;
            }
        }
    };

    $scope.currentContentChange = function () {
        console.log($scope.json.data[$scope.currentNb][$scope.currentDay.getFullYear()][$scope.currentDay.getMonth() + 1][$scope.currentDay.getDate()]);

        if (!$scope.queue.data[$scope.currentNb]) {
            $scope.queue.data[$scope.currentNb] = {};
            console.log("Add new Notebook in queue ");
        }
        if (!$scope.queue.data[$scope.currentNb][$scope.currentDay.getFullYear()]) {
            $scope.queue.data[$scope.currentNb][$scope.currentDay.getFullYear()] = {};
            console.log("Add new Year in queue ");
        }
        if (!$scope.queue.data[$scope.currentNb][$scope.currentDay.getFullYear()][$scope.currentDay.getMonth() + 1]) {
            $scope.queue.data[$scope.currentNb][$scope.currentDay.getFullYear()][$scope.currentDay.getMonth() + 1] = {};
            console.log("Add new Month in queue ");
        }
        $scope.queue.data[$scope.currentNb][$scope.currentDay.getFullYear()][$scope.currentDay.getMonth() + 1][$scope.currentDay.getDate()] = $scope.json.data[$scope.currentNb][$scope.currentDay.getFullYear()][$scope.currentDay.getMonth() + 1][$scope.currentDay.getDate()];
        console.log("Add/Update Day in queue with data " + $scope.queue.data[$scope.currentNb][$scope.currentDay.getFullYear()][$scope.currentDay.getMonth() + 1][$scope.currentDay.getDate()]);
        if (angular.isDefined(inter)) return;

        inter = $interval(function () {
            $scope.loading = true;
            console.log("Sending data...");
            console.log($scope.queue);
            $interval.cancel(inter);
            inter = undefined;
            $http.post('ctrl-post.php', $scope.queue).
                success(function (data, status, headers, config) {
                    // this callback will be called asynchronously
                    // when the response is available
                    console.log("Send OK");
                    $scope.queue = {
                        "data": {}
                    };
                    $scope.loading = false;
                }).
                error(function (data, status, headers, config) {
                    // called asynchronously if an error occurs
                    // or server returns response with an error status.
                    console.log("Send KO !!");
                    $scope.loading = false;
                });
        }, $scope.json.config.saveInterval);
    };

    $scope.searchChange = function () {
        var count = 0;
        if ($scope.searchInput.length >= $scope.json.config.minSearchCar) {
            $scope.searchResults = {};
            console.log($scope.searchInput);
            angular.forEach($scope.json.data[$scope.currentNb], function (value, keyY) {//year
                angular.forEach(value, function (value, keyM) {//month
                    angular.forEach(value, function (value, keyD) {//day
                        var plainText = $scope.htmlToPlaintext(value);
                        if (count < $scope.json.config.maxResults && ~plainText.indexOf($scope.searchInput)) {
                            var indexValue = plainText.indexOf($scope.searchInput);
                            $scope.searchResults[keyY + "-" + keyM + "-" + keyD] = plainText.substring(indexValue - 20, indexValue + 20);
                            count++;
                        }
                    });

                });
            });
        }
    };


    $scope.htmlToPlaintext = function (text) {
        return String(text).replace(/<[^>]+>/gm, '');
    };


    $scope.searchDisplay = function (key) {
        $scope.currentDay = new Date(key);
    };

    $scope.today = function () {
        $scope.currentDay = new Date();

    };
    $scope.today();
});