<?php
namespace App\Http\Controllers;
use DB;
use App\User;
use App\Http\Controllers\Controller;
use Input;
use Auth;
use Hash;
use Session;

class FreshController extends Controller
{
	public function index() {
		return view("fresh", ["title" => "大一值班"]);
	}

	public function returnStatus() {
		$now = date('H:i:s', time());
		$minute = date('i', time());

		// get current time
		$dayWeek = date('w', time());
		$hour = (int)date('H', time());
		$hour = (string)$hour;
		$classValue = ["8" => "1", "9" => "2", "10" => "3", "11" => "4", "12" => "Z", "13" => "5", "14" => "6", "15" => "7", "16" => "8", "17" => "9", "18" => "A", "19" => "B", "20" => "C"];
		if (!empty($classValue[$hour]))
			$currentClass = $classValue[$hour];
		else
			$currentClass = "1";
		if ($dayWeek == 6 || $dayWeek == 7)
			$dayWeek = 1;
		$currentTimeValue = $dayWeek.$currentClass;

		$freshPeopleId = DB::table("class")->where("type", "fresh")->where("time_id", $currentTimeValue)->get();
		$fresh = array();
		if ($freshPeopleId) {
			$freshWorks = DB::table("fresh_works")->where("time_id", $currentTimeValue)->get();
			foreach ($freshPeopleId as $key => $value) {
				$signData = DB::table("signUpData")->whereBetween('signTime', array(date('Y-m-d 00:00:00', time()), date('Y-m-d 23:59:59', time())))->where("userId", $value->user_id)->first();

				$data = DB::table('users')->where("id", $value->user_id)->first();
				$data->work = $freshWorks[$key]->work;

				$signTime = '';
				$signStatus = '';
				if ($signData) {
					$status = "signed";
					$signTime = $signData->signTime;
					$signStatus = $signData->status;
				} else {
					if ($minute > 20) {
						$status = "absenteeism";
					}else if ($minute > 5) {
						$status = "late";
					} else {
						$status = "notSign";
					}
				}

				$data->status = $status;
				$data->signTime = $signTime;
				$data->signStatus = $signStatus;

				array_push($fresh, $data);
			}
		}

		$data = [ "currentTime" => $now, "freshPeople" => $fresh, "currentTimeValue" => $currentTimeValue];

		return response()->json($data);
	}

	public function signUp() {
		$minute = date('i', time());

		if ($minute > 19) {
			$status = "fail";
		} else if ($minute > 4) {
			$status = "late";
			DB::table("signUpData")->insert(
				array("status" => "late", "userId" => Input::get("user_id"))
			);
		} else {
			$status = "ok";
			DB::table("signUpData")->insert(
				array("status" => "ok", "userId" => Input::get("user_id"))
			);
		}

		return response()->json(["status" => $status, "signTime" => date('H:i:s', time())]);
	}

	public function recordWill() {
		$wills = Input::get('will');
		$wills = json_decode($wills, true);
		$results = array();

		DB::table('fresh_will')->where('user_id', Auth::user()->id)->delete();

		foreach ($wills as $key => $value) {
			array_push($results, ["select_class" => $value, "user_id" => Auth::user()->id]);
		}

		DB::table('fresh_will')->insert($results);

		return "success";
	}

	public function freshTimeApi() {
		$result = DB::table("fresh_will")->where("user_id", Auth::user()->id)->get();

		return response()->json($result);
	}

	public function createNewUserByFile() {
		$file = file_get_contents(Input::file('users'));
		$lines = explode(PHP_EOL, $file);
		$array = array();
		foreach ($lines as $line) {
		    $user = str_getcsv($line);
		    if (count($user) == 2) {
		    	$id = DB::table('users')->insertGetId(array(
			    		"email" => $user[0]."@cc.ncu.edu.tw",
			    		"password" => Hash::make($user[0]),
			    		"facebook_id" => "1000000000",
			    		"name" => $user[1]
		    		));
		    	DB::table("users_group")->insert(array(
		    		"user_id" => $id, 
		    		"group_name" => "fresh"
	    		));
		    }
		}

		return redirect("/dashboard/changeUserGroup");
	}

	public function saveAllocate() {
		$result = json_decode(Input::get('result'));
		DB::table('class')->where("type", "fresh")->delete();
		foreach ($result as $key => $value) {
			DB::table('class')->insert(array(
				"user_id" => $value->user_id,
				"time_id" => strtoupper($value->class_value),
				"type" => "fresh"
			));
		}

		return "success";
	}
}