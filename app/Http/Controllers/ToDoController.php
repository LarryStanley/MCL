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

		return view('/dashboard/todolist', ["list" => $list, "doneList" => $doneList]);
	}

	public function postToDo() {
		DB::table("todo_list")->insert(array(
			"name" => Input::get("name"),
			"description" => Input::get("description"),
			"owner_id" => Auth::user()->id,
			"assign_id" => Auth::user()->id,
			"done" => false
		));

		return redirect("/dashboard/todo");
	}

	public function showToDo($id) {
		$todo = DB::table("todo_list")->where("id", $id)->first();
		$todo->description = Markdown::parse($todo->description);
		$comments = DB::table("todo_comments")->where("todo_id", $id)->get();
		foreach ($comments as $key => $value) {
			$comments[$key]->comment = Markdown::parse($comments[$key]->comment);
		}

		return view('/dashboard/todo', ["todo" => $todo, "comments" => $comments]);
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