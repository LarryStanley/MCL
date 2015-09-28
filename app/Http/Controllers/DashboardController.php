<?php
namespace App\Http\Controllers;
use DB;
use App\User;
use App\Http\Controllers\Controller;
use Input;
use Session;
use Auth;
use Markdown;

class DashboardController extends Controller
{
	public function index() {
		$diary = DB::table("diary")->orderBy("id", "desc")->first();
		$diary->content = Markdown::parse($diary->content);
		$recordUser = DB::table("users")->where("id", $diary->recordUserId)->first();

		// get current time
		$dayWeek = date('w', time());
		$hour = (int)date('H', time());
		$hour = (string)$hour;
		$classValue = ["8" => "1", "9" => "2", "10" => "3", "4" => "11", "12" => "Z", "13" => "5", "14" => "6", "15" => "7", "16" => "8", "17" => "9", "18" => "A", "19" => "B", "20" => "C"];
		if (!empty($classValue[$hour]))
			$currentClass = $classValue[$hour];
		else
			$currentClass = "1";
		if ($dayWeek == 6 || $dayWeek == 7)
			$dayWeek = 1;

		$currentTimeValue = $dayWeek.$currentClass;

		return view("dashboard/dashboard", ["user" => Auth::user(), "diary" => $diary, "recordUser" => $recordUser, "title" => "總覽", "currentTimeValue" => $currentTimeValue]);
	}

	public function showAllDocuments() {
		$documents = DB::table("document_group")->get();

		foreach ($documents as $key => $value) {
			$group = DB::table("documents")->where("group_id", $value->id)->get();
			$documents[$key]->data = $group;
		}

		return view("dashboard/alldocuments", ["documents" => $documents, "title" => "MCL相關文件"]);
	}

	public function showDocument($id) {
		$data = DB::table("documents")->where("id", $id)->first();

		$content = Markdown::parse($data->content);

		return view("dashboard/documents", ["user" => Auth::user(), "content" => $content, "document" => $data, "title" => $data->name]);

	}

	public function editDocument($id) {
		$data = DB::table("documents")->where("id", $id)->first();
		$category = DB::table("document_group")->get();

		return view("dashboard/editDocument", ["user" => Auth::user(), "document" => $data, "category" => $category]);
	}

	public function postDocument() {
		if (Input::get('id')) {
			$id = Input::get('id');
			DB::table("documents")->where("id", Input::get('id'))->update(array(
				"content" => Input::get("content"),
				"name" => Input::get("name"),
				"updateTime" => date('Y-m-d H:i:s', time()),
				"editUserId" => Auth::user()->id,
				"editUserName" => Auth::user()->name,
				"group_id" => Input::get("category")
			));
		} else {
			$data = DB::table("documents")->insert(array(
				"content" => Input::get("content"),
				"name" => Input::get("name"),
				"editUserId" => Auth::user()->id,
				"editUserName" => Auth::user()->name,
				"group_id" => Input::get("category")
			));

			$id = DB::getPdo()->lastInsertId();
		}

		return redirect("dashboard/documents/".$id);
	}

	public function newDocument() {
		$category = DB::table("document_group")->get();

		return view("dashboard/editDocument", ["user" => Auth::user(), "category" => $category]);
	}

	public function showAllWorkerDiary() {
		$data = DB::table("diary")->get();
		$data = array_reverse($data);
		return view("dashboard/allDiary", ["user" => Auth::user(), "diaries" => $data, "title" => "工讀生日誌"]);
	}

	public function showAllWorkerDiaryByPage($page) {
		$data = DB::table("diary")->get();
		$data = array_reverse($data);
		$allPageCount = (count($data)/5 + 1);
		if ($page > (count($data)/5 + 1))
			return view('/errors/404');
		else {
			$data = array_slice($data, ($page - 1)*5, $page*5);
			return view("dashboard/allDiary", ["user" => Auth::user(), "diaries" => $data, "page" => $page, "allPageCount" => $allPageCount,"title" => "工讀生日誌"]);
		}
	}

	public function showDiary($id) {
		$data = DB::table("diary")->where("id", $id)->first();
		$data->content = Markdown::parse($data->content);
		$comments = DB::table("diary_comments")->where("diary_id", $id)->get();
		$recordUser = DB::table("users")->where("id", $data->recordUserId)->first();

		return view("dashboard/diary", ["user" => Auth::user(), "diary" => $data, "comments" => $comments, "recordUser" => $recordUser, "title" => $data->name]);
	}

	public function showEditDiary($id) {
		$diary = DB::table("diary")->where("id", $id)->first();
		if (Auth::user()->id == $diary->recordUserId)
			return view("dashboard/newDiary", ["user" => Auth::user(), "diary" => $diary, "title" => "編輯日誌"]);
		else
			return redirect("/dashboard/workerDiary");
	}

	public function showNewDiary() {
		return view("dashboard/newDiary", ["user" => Auth::user(), "title" => "新增日誌"]);
	}

	public function postNewDiary() {
		if (Input::get("id")) {
			DB::table("diary")->where("id", Input::get("id"))->update(array(
				"name" => Input::get("name"),
				"content" => Input::get("content"),
				"recordTime" => date('Y-m-d H:i:s', time())
				)
			);
			$id = Input::get("id");
		} else {
			DB::table("diary")->insert(array(
				"recordUserId" => Auth::user()->id,
				"recordUserName" => Auth::user()->name,
				"name" => Input::get("name"),
				"content" => Input::get("content")
				)
			);
			$id = DB::getPdo()->lastInsertId();
		}
		return redirect('/dashboard/workerDiary/'.$id);
	}

	public function postDiaryComment() {
		DB::table("diary_comments")->insert(array(
				"diary_id" => Input::get('id'),
				"comment" => Input::get('comment'),
				"user_id" => Auth::user()->id,
				"user_name" => Auth::user()->name,
				"facebook_id" => Auth::user()->facebook_id
			));

		return response()->json([
			"diary_id" => Input::get('id'), 
			"comment" => Input::get("comment"), 
			"user_id" => Auth::user()->id, 
			"user_name" => Auth::user()->name,
			"fb_id" => Auth::user()->facebook_id]);
	}

	public function showAnnouncement() {
		$data = DB::table("announcement")->get();
		$data = array_reverse($data);

		return view("/dashboard/announcement", ["announcements" => $data]);
	}

	public function postAnnouncement() {			
		DB::table("announcement")->insert(array(
			"content" => Input::get("content"),
			"recordUserName" => Auth::user()->name,
			"recordUserId" => Auth::user()->id,
			"show" => true
			)
		);

		$data = DB::table("announcement")->get();
		$data = array_reverse($data);

		return view("/dashboard/announcement", ["announcements" => $data]);		
	}

	public function showOS() {
		return view("/dashboard/os");		
	}

	public function showSoftware() {
		return view("/dashboard/software");
	}

	public function showDrivers() {
		$data = DB::table("driver_group")->get();
		return view("/dashboard/drivers", ["group" => $data]);
	}

	public function newComputer() {
		DB::table("driver_group")->insert(array("computerName" => Input::get("computerName")));
		return redirect("/dashboard/driver");
	}

	public function uploadDriver() {
		$group = DB::table("driver_group")->where("computerName", Input::get("computerName"))->first();

		$destinationPath = public_path().'/downloads';
		$upload_success = Input::file('driver')->move($destinationPath, Input::file('driver')->getClientOriginalName());

		DB::table("drivers")->insert(array(
			"groupId" => $group->id,
			"name" => Input::get("name"),
			"location" => Input::file('driver')->getClientOriginalName()
		));
		return redirect("/dashboard/driver");
	}

	public function showUploadDriver() {
		$data = DB::table("driver_group")->get();
		return view("/dashboard/uploadDriver", ["group" => $data]);
	}

	public function showNewComputer() {
		$data = DB::table("driver_group")->get();
		return view("/dashboard/newComputer");
	}

	public function changeUserGroup() {
		$userData = DB::table("users")->get();
		return view("/dashboard/changeUserGroup", ["users" => $userData]);
	}

	public function changeUserGroupById($id) {
		$userData = DB::table('users')->where("id", $id)->first();

		return view("/dashboard/changeUserGroupById", ["user" => $userData]);
	}

	public function postUserGroup() {
		DB::table("users_group")->where("user_id", Input::get("id"))->delete();

		foreach (Input::get("group") as $key => $value) {
			DB::table("users_group")->insert(array(
				"user_id" => Input::get("id"),
				"group_name" => $value
			));
		}

		return redirect("/dashboard/changeUserGroup/".Input::get('id'));
	}

	public function freshResult() {
		return view('/dashboard/result');
	}

	public function freshTime() {
		return view('/dashboard/time', ["title" => "大一勞服時間填寫"]);
	}

	public function mangeFresh() {

		// get not register people
		$freshData = DB::table("users_group")->where('group_name', 'fresh')->get();
		$notRegister = array();
		foreach ($freshData as $key => $value) {
			$will = DB::table("fresh_will")->where("user_id", $value->user_id)->get();
			if (empty($will)) {
				array_push($notRegister, $value->user_id);
			}
		}

		return view('/dashboard/mangeFresh', ["notRegister" => $notRegister, "title" => "勞服管理"]);
	}
}