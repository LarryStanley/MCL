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
		return view("dashboard/dashboard", ["user" => Auth::user()]);
	}

	public function showAllDocuments() {
		$documents = DB::table("document_group")->get();

		foreach ($documents as $key => $value) {
			$group = DB::table("documents")->where("group_id", $value->id)->get();
			$documents[$key]->data = $group;
		}

		return view("dashboard/alldocuments", ["documents" => $documents]);
	}

	public function showDocument($id) {
		$data = DB::table("documents")->where("id", $id)->first();

		$content = Markdown::parse($data->content);

		return view("dashboard/documents", ["user" => Auth::user(), "content" => $content, "document" => $data]);

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
		return view("dashboard/allDiary", ["user" => Auth::user(), "diaries" => $data]);
	}

	public function showDiary($id) {
		$data = DB::table("diary")->where("id", $id)->first();
		$data->content = Markdown::parse($data->content);
		$comments = DB::table("diary_comments")->where("diary_id", $id)->get();
		$recordUser = DB::table("users")->where("id", $data->recordUserId)->first();

		return view("dashboard/diary", ["user" => Auth::user(), "diary" => $data, "comments" => $comments, "recordUser" => $recordUser]);
	}

	public function showEditDiary($id) {
		$diary = DB::table("diary")->where("id", $id)->first();
		if (Auth::user()->id == $diary->recordUserId)
			return view("dashboard/newDiary", ["user" => Auth::user(), "diary" => $diary]);
		else
			return redirect("/dashboard/workerDiary");
	}

	public function showNewDiary() {
		return view("dashboard/newDiary", ["user" => Auth::user()]);
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
		return view('/dashboard/time');
	}
}