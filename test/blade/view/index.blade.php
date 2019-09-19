@extends('layouts.app')

@section('title', 'Page Title')

@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection

@section('content')
    <p>This is my body content.</p>

    @foreach ($list as $vo)
        <a href="/new/{{ $vo['id'] }}">{{ $vo['title'] }}</a><br/>
        {{ $vo['content'] }}
    @endforeach

    <br/>

    最新资讯：
    <br/>
    @foreach ($news as $new)
    <a href="/new/{{ $new['id'] }}">{{ $new['title'] }}</a><br/>
    @endforeach

@endsection