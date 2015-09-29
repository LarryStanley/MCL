angular.module('freshApp', [])
	.controller('FreshController', function($scope, $http) {
		var time;
		var nextStatus;
		var allTimer = [];

		$.getJSON("/fresh/currentStatus", function(data) {
			$scope.freshData = data.freshPeople;

			if (data.freshPeople.length) {
				angular.forEach(data.freshPeople, function(value, key) {
					if (value.status === "absenteeism") {
						$scope.freshData[key].message = "您已經曠課囉，下次請早點來！";
						$scope.$apply();
						$(".signUpButton-"+key).remove();
					} else if (value.status === "signed") {
						var signTime = value.signTime.split(" ");
						$scope.freshData[key].message  = "您已於" + signTime[1] + "簽到";
						$scope.$apply();
						$(".signUpButton-"+key).remove();
					} else {
						var currentTime = data.currentTime.split(":");
						if (value.status === "late") {
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
									$scope.freshData[key].message  = "您已經曠課囉，下次請早點來！";
									$scope.$apply();
									$(".signUpButton-"+key).remove();
								}
							} else {
								var presentTime = secondsToTime(time);
								$scope.freshData[key].message  = "您還有" + presentTime.m + ":" + presentTime.s + "將" + nextStatus;
								$scope.$apply();
							}
						}, 1000);
						allTimer.push(timer);
					}
				});
			} else {
				$scope.toAllMessage = "目前非值班時段";
				$scope.$apply();
			}
		});

		this.signUp = function(id, key) {
			$.post('/fresh/signUp', {"_token" : $("#token").val(), "user_id" : id})
				.done( function(data) {
				console.log(data);
				clearInterval(allTimer[key]);
				//var signTime = data.signTime.split(" ");
				$scope.freshData[key].message = "您已於" + data.signTime + "簽到";
				$scope.$apply();
				$(".signUpButton-"+key).remove();
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