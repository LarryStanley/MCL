<?php
namespace App\Http\Controllers;
use DB;
use App\User;
use App\Http\Controllers\Controller;
use Input;
use Session;

class FreshController extends Controller
{
	public function index() {
		return view("fresh", ["title" => "大一值班"]);
	}

	public function returnStatus() {
		$now = date('H:i:s', time());
		$minute = date('i', time());

		$signData = DB::table("signUpData")->whereBetween('signTime', array(date('Y-m-d 00:00:00', time()), date('Y-m-d 23:59:59', time())))->where("userId", "2")->first();

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
		$data = ["status" => $status, "signStatus" => $signStatus, "currentTime" => $now, "signTime" => $signTime];

		return response()->json($data);
	}

	public function signUp() {
		$minute = date('i', time());

		if ($minute > 19) {
			$status = "fail";
		} else if ($minute > 4) {
			$status = "late";
			DB::table("signUpData")->insert(
				array("status" => "late", "userId" => 2)
			);
		} else {
			$status = "ok";
			DB::table("signUpData")->insert(
				array("status" => "ok", "userId" => 2)
			);
		}

		return response()->json(["status" => $status, "signTime" => date('H:i:s', time())]);
	}

	public function test() {
		echo "TEST";
	}
}