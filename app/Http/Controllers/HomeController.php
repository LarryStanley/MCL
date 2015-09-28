<?php
namespace App\Http\Controllers;
use DB;
use App\User;
use App\Http\Controllers\Controller;
use Input;
use Session;
use Auth;
use Markdown;

class HomeController extends Controller
{
	public function showClass() {
		return view("/class", ["title" => "104上學期MCL使用表"]);
	}
}