@extends('layouts.default')

@section('content')
  @if (Auth::check())
    <div class="row">
      <div class="col-md-8">
        <section class="status_form">
          @include('shared._status_form')
        </section>
        <h3>微博列表</h3>
        @include('shared._feed')
      </div>
      <aside class="col-md-4">
        <section class="user_info">
          @include('shared._user_info', ['user' => Auth::user()])
        </section>

	 <section class="stats">
          @include('shared._stats', ['user' => Auth::user()])
        </section>

      </aside>
    </div>
  @else
    <div class="jumbotron">
      
<h1>Wel...come</h1>
    <p class="lead">
      你现在所看到的是 <a href="{{ route('welcome') }}">。。。。。就是一个测试页面！</a>
    </p>
    <p>
      感觉好累啊。尤其是脑袋，程序猿短命不是没有原因的，很有可能是被自己敲死的。
    </p>

      <p>
        <a class="btn btn-lg btn-success" href="{{ route('signup') }}" role="button">现在注册</a>
      </p>
    </div>
  @endif
@stop
