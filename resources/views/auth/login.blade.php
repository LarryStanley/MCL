@extends("layout")

@section("head")

<link rel="stylesheet" href="/css/auth.css">

@stop

@section("content")

<div class="container">
    <div class="center">
        <h1>登入</h1>
        <div class="well">
            <form method="POST" action="/auth/login" class="form-horizontal">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label for="email">email</label>
                    <input class="form-control" type="email" name="email" value="{{ old('email') }}">
                </div>
                <div class="form-group">
                    <label for="password">密碼</label>
                    <input class="form-control" type="password" name="password" id="password">
                </div>

                <div class="form-group">
                    <input class="form-control" type="checkbox" name="remember"> 記住我
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-default pull-right">登入</button>
                </div>
            </form>
        </div>
    </div>
</div>

@stop