angular.module('freshTimeApp', [])
	.controller('FreshTimeController', function($scope, $http) {
		var time = this;
		var classValue = ["1", "2", "3", "4", "Z", "5", "6", "7", "8", "9", "A", "B", "C"];
		time.notOpen = ["13", "14", "44", "23", "24", "55", "56", "57", "58", "59", "5A", "5B", "5C"];
		time.classTable = [];
		$.getJSON('/fresh/timeJson', function(oldTime) {
			for (var j = 0; j < classValue.length; j++) {
				var row = [];
				for (var i = 0; i < 5; i++) {
					var currentValue = parseInt(i+1) + classValue[j];
					row.push({classValue: currentValue, checked: false});
					for (var k = 0; k < oldTime.length; k++) {
						if (oldTime[k].select_class == currentValue) {
							row[row.length - 1] = {classValue: currentValue, checked: true};
							break;
						}
					}
				}
				time.classTable.push(row);
			}
			$scope.$apply();
		});

		time.duration = ["1 08:00 ~ 08:50", "2 09:00 ~ 09:50", "3 10:00 ~ 10:50", "4 11:00 ~ 11:50", "Z 12:00 ~ 12:50", "5 13:00 ~ 13:50", "6 14:00 ~ 14:50", "7 15:00 ~ 15:50", "8 16:00 ~ 16:50", "9 17:00 ~ 17:50", "A 18:00 ~ 18:50", "B 19:00 ~ 19:50", "C 20:00 ~ 20:50"];

		time.status = function() {
			var result = 0;
			angular.forEach(time.classTable, function(row) {
				angular.forEach(row, function(value) {
					if (value.checked) {
						if (result == 6)
							value.checked = false;
						else
						result++;
					}
				});
			});

			return "已選擇" + parseInt(result) + "節課，還可以再選擇" + parseInt(6 - result) + "節課";
		};

		time.submit = function() {
			var result = [];
			angular.forEach(time.classTable, function(row) {
				angular.forEach(row, function(value) {
					if (value.checked) 
						result.push(value.classValue);
				});
			});

			$("#message").html("");
			if (result.length > 3) {
				result = JSON.stringify(result);
				console.log(result);
				$.post("/fresh/receiveWill", { will: result, _token : $("#token").val()}, function(data) {
					console.log(data);
					$("#message").append("<span class='animated fadeIn'>已成功儲存，您可於9/24時回來察看分發結果</span>");
				});
			} else {
				$("#message").append("<span class='animated fadeIn'>請選足超過4個時段喔！！</span>");
			}
		};
	});