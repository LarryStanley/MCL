@extends("layout")

@section("head")
    <link rel="stylesheet" href="/css/auth.css">
@stop

@section("content")

<div class="container">
    <div class="center">
        <h1>註冊使用者</h1>
        <div class="well">
            <form method="POST" action="/auth/register" class="form-horizontal">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label for="name">姓名</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email"  class="form-control" name="email" value="{{ old('email') }}">
                </div>

                <div class="form-group">
                    <label for="password">密碼</label>
                    <input type="password" class="form-control" name="password">
                </div>

                <div class="form-group">
                    <label for="password_confirmation">再次確認密碼</label>
                    <input type="password" class="form-control" name="password_confirmation">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-default pull-right">註冊</button>
                </div>
            </form>      
        </div>
    </div>
</div>

@stop