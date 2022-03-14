/* 
 * RANDRIANASOLO Jean Samu�l 
 * rjs.samuel@yahoo.com
 * 23 juil. 2018
 */
function pad(num) {
    return num < 10 ? "0" + num : num;// ("0" + num).slice(-2);
}

function hhmmss(secs) {
    var minutes = Math.floor(secs / 60);
    secs = secs % 60;
    var hours = Math.floor(minutes / 60)
    minutes = minutes % 60;
    var days = Math.floor(hours / 24)
    hours = hours % 24;
    var res = [];
    if (days > 0) {
        res.push(`${pad(days)}jr`);
    }
    if (hours > 0) {
        res.push(`${pad(hours)}h`);
    }
    if (minutes > 0) {
        res.push(`${pad(minutes)}mn`);
    }
    if (secs > 0) {
        res.push(`${pad(secs)}s`);
    }
    return res.join(" ");
    //return `${pad(hours)}jr ${pad(hours)}h ${pad(minutes)}mn ${pad(secs)}s`;
}

var app = angular.module("app", ['ngSanitize']);
app.directive("ngFileModel", function ($parse) {
    return {
        link: function ($scope, element, attrs) {
            element.on("change", function (event) {
                var files = event.target.files;
                $parse(attrs.ngFileModel).assign($scope, element[0].files);
                $scope.$apply();
            });
        }
    };
});
app.directive('loading', ['$http', function ($http) {
    return {
        restrict: 'A',
        template: '<div class="loading-spiner" style="margin-left:50%;margin-top:20%;position:absolute;border-radius:100%;padding:5px;justify-content:center;"><img src="' + BASE_URL + 'assets/images/loading.gif" width="50" height="50"/></div>',
        link: function (scope, elm, attrs) {
            scope.isLoading = function () {
                return $http.pendingRequests.length > 0;
            };
            scope.$watch(scope.isLoading, function (v) {
                if (v) {
                    elm.show();
                } else {
                    elm.hide();
                }
            });
        }
    };
}]);