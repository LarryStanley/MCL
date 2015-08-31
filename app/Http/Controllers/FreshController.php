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
		return view("fresh");
	}

	public function returnStatus() {
		$now = date('H:i:s', time());

		$minute = date('i', time());
		if ($minute > 20) {
			$status = "absenteeism";
		}else if ($minute > 5) {
			$status = "late";
		} else {
			$status = "notSign";
		}

		$data = ["status" => $status, "currentTime" => $now];

		return response()->json($data);
	}

	public function signUp() {
		$minute = date('i', time());
		if ($minute > 20) {
			$status = "fail";
		} else if ($minute > 5) {
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

		return response()->json(["status" => $status]);
	}
}