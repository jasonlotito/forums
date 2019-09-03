@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ $thread->owner->path() }}">{{ $thread->owner->name }}</a>
                        {{ $thread->title }}
                    </div>

                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($thread->replies as $reply)
        @include ('threads.reply')
    @endforeach

    @if (auth()->check())
    <br>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Add Reply
                    </div>

                    <div class="card-body">
                        <form action="{{ $thread->path() }}/reply" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <textarea name="body" id="body" class="form-control" rows="5" placeholder="Have something to say?"></textarea>
                            </div>
                            <button class="btn-primary btn">Submit Post</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
        <p>Please <a href="{{ route('login') }}">sign in</a> to reply.</p>
    @endif
@endsection
