<?php
namespace App\Http\Controllers;
use DB;
use App\User;
use App\Http\Controllers\Controller;
use Input;
use Session;
use Auth;
use Markdown;

class ToDoController extends Controller
{
	public function showAllToDo() {
		$list = DB::table("todo_list")->where("done", 0)->get();
		$doneList = DB::table("todo_list")->where("done", true)->get();

		return view('/dashboard/todolist', ["list" => $list, "doneList" => $doneList, "title" => "MCL待辦事項"]);
	}

	public function postToDo() {
		DB::table("todo_list")->insert(array(
			"name" => Input::get("name"),
			"description" => Input::get("description"),
			"owner_id" => Auth::user()->id,
			"done" => false
		));

		return redirect("/dashboard/todo");
	}

	public function showToDo($id) {
		$todo = DB::table("todo_list")->where("id", $id)->first();
		$todo->description = Markdown::parse($todo->description);
		$owner = DB::table("users")->where("id", $todo->owner_id)->first();
		$comments = DB::table("todo_comments")->where("todo_id", $id)->get();
		$assigners = DB::table("todo_assigners")->where("done", false)->where("todo_id", $id)->get();

		foreach ($comments as $key => $value) {
			$comments[$key]->comment = Markdown::parse($comments[$key]->comment);
		}

		return view('/dashboard/todo', ["todo" => $todo, "comments" => $comments, "user" => Auth::user(), "title" => $todo->name, "owner" => $owner, "assigners" => $assigners]);
	}

	public function postComment() {
		DB::table("todo_comments")->insert(array(
			"todo_id" => Input::get("id"),
			"comment" => Input::get("comment"),
			"user_id" => Auth::user()->id,
			"user_name" => Auth::user()->name,
			"facebook_id" => Auth::user()->facebook_id
		));

		return redirect('/dashboard/todo/'.Input::get("id"));
	}

	public function postNewAssign() {
		$assigner = DB::table("users")->where("id", Input::get('assigner'))->first();
		$old_assign = DB::table("todo_assigners")->where("done", false)->where("user_id", $assigner->id)->where("todo_id", Input::get('id'))->get();

		if (!$old_assign) {
			DB::table("todo_comments")->insert(array(
				"todo_id" => Input::get("id"),
				"comment" => "將任務指派給<a target='_blank' href='http://www.facbook.com/".$assigner->facebook_id."'>".$assigner->name."</a>",
				"user_id" => Auth::user()->id,
				"user_name" => Auth::user()->name,
				"facebook_id" => Auth::user()->facebook_id
			));

			DB::table("todo_assigners")->insert(array(
				"todo_id" => Input::get('id'),
				"user_id" => Input::get('assigner'),
				"facebook_id" => $assigner->facebook_id,
				"done" => false
			));
		}

		return redirect("/dashboard/todo/".Input::get("id"));
	}

	public function todoComplete() {
		$user = Auth::user();

		DB::table("todo_assigners")->where("todo_id", Input::get('id'))->where("user_id", Auth::user()->id)->where("done", false)->update(array(
			"done" => true
		));

		DB::table("todo_comments")->insert(array(
				"todo_id" => Input::get("id"),
				"comment" => "<a target='_blank' href='http://www.facbook.com/".$user->facebook_id."'>".$user->name."</a><span style='color: #FF5722'>已完成任務</span>",
				"user_id" => Auth::user()->id,
				"user_name" => Auth::user()->name,
				"facebook_id" => Auth::user()->facebook_id
		));
		
		return redirect("/dashboard/todo/".Input::get("id"));
	}

	public function closeToDo() {
		DB::table("todo_list")->where("id", Input::get("id"))->update(array(
			"done" => true
		));

		DB::table("todo_comments")->insert(array(
			"todo_id" => Input::get("id"),
			"comment" => "<span style='color: #C62828'>此事件已完結</span>",
			"user_id" => Auth::user()->id,
			"user_name" => Auth::user()->name,
			"facebook_id" => Auth::user()->facebook_id
		));

		return redirect('/dashboard/todo/'.Input::get("id"));
	}
}