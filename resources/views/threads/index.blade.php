@extends('layouts.app')

@section('content')
    @if (auth()->check())
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                        <div class="card-body">
                            <a href="/threads/create" class="btn">Create a new thread</a>
                        </div>

                </div>
            </div>
        </div>
    </div>
    <br>
    @endif
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="justify-content-center">
                    {{ $threads->links() }}
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Forum Threads</div>
                    @foreach ($threads as $thread)
                        <div class="card-body">
                            <h3><a href="{{ $thread->path() }}">{{ $thread->title }}</a></h3>
                            {{ $thread->body }}
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="justify-content-center">
                    {{ $threads->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
