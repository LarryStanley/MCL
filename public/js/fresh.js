angular.module('freshApp', [])
	.controller('FreshController', function($scope, $http) {
		var time;
		var nextStatus;
		var timer;

		$.getJSON("/fresh/currentStatus", function(data) {
			if (data.status === "absenteeism") {
				$scope.message = "您已經曠課囉，下次請早點來！";
				$scope.$apply();
				$("#signUpButton").remove();
			} else if (data.status === "signed") {
				var signTime = data.signTime.split(" ");
				$scope.message = "您已於" + signTime[1] + "簽到";
				$scope.$apply();
				$("#signUpButton").remove();
			} else {
				var currentTime = data.currentTime.split(":");
				if (data.status === "late") {
					nextStatus = "曠課";
					time = 1200 - currentTime[1] * 60 - currentTime[2];
				} else {
					nextStatus = "遲到";
					time = 300  - currentTime[1] * 60 - currentTime[2];
				}

				timer = setInterval(function() {
					time--;
					if (time === 0) {
						if (nextStatus === "遲到") {
							time = 900;
							nextStatus = "曠課";
						} else {
							clearInterval(timer);
							$scope.message = "您已經曠課囉，下次請早點來！";
							$scope.$apply();
							$("#signUpButton").remove();
						}
					} else {
						var presentTime = secondsToTime(time);
						$scope.message = "您還有" + presentTime.m + ":" + presentTime.s + "將" + nextStatus;
						$scope.$apply();
					}
				}, 1000);
			}
		});

		this.signUp = function() {
			$.post('/fresh/signUp', {"_token" : $("#token").val()})
				.done( function(data) {
				console.log(data);
				clearInterval(timer);
				var signTime = data.signTime.split(" ");
				$scope.message = "您已於" + signTime[1] + "簽到";
				$scope.$apply();
				$("#signUpButton").remove();
			});
		}
	});

function secondsToTime(secs) {
    var hours = Math.floor(secs / (60 * 60));
   
    var divisor_for_minutes = secs % (60 * 60);
    var minutes = Math.floor(divisor_for_minutes / 60);
 
    var divisor_for_seconds = divisor_for_minutes % 60;
    var seconds = Math.ceil(divisor_for_seconds);
   
    var obj = {
        "h": hours,
        "m": minutes,
        "s": seconds
    };
    return obj;
}