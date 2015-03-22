/**
 * Created by elyaet on 16/03/15.
 */
app.controller("webNotebookCtrl", function ($scope, $location) {
    $scope.json = {
        config: {
            default: "perso"
        },
        data: {
            Perso: {
                2015: {
                    3: {
                        22: "Hello World !"
                    }
                }
            },
            Pro: {
                2015: {
                    3: {
                        22: "Hello pro World !"
                    }
                }
            }
        }
    };
    //$scope.currentNb = $scope.json.config.default;
    $scope.currentDay = new Date();
    //$scope.htmlcontent = $scope.json.data[$scope.currentNb][$scope.currentDay.getFullYear()][$scope.currentDay.getMonth()+1][$scope.currentDay.getDate()];

    $scope.htmlContentChange = function () {
    };

    $scope.$on('$locationChangeStart', function (event) {
        var anchor = $location.url().substring(1);
        angular.forEach($scope.json.data, function (value, key) {
            if (key == anchor) {
                console.debug("Switch to " + anchor);
                $scope.currentNb = anchor;
            }
        });
        if(anchor==""){
            console.debug("Switch to " + $scope.json.config.default);
            $scope.currentNb = $scope.json.config.default;
        }
    });
});