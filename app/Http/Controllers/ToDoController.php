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
		return view('/dashboard/todolist', ["list" => $list]);
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
}