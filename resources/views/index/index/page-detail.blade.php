@extends('index.layouts.app')

@section('keywords',$info->keywords)
@section('description',$info->description)
@section('title',\App\Libraries\Config::getInstance()->get('name').' - '.$info->title)

@section('content')
    <div id="content">
        <div id="primary">
            <article class="post">
                <header class="post-header">
                    <h1 class="post-title">{{ $info->title }}</h1>
                </header>
                <div class="post-content">
                    {!! $info->content !!}
                </div>
            </article>
        </div>
    </div>
@endsection
