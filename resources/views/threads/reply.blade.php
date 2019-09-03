<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a href="{{ $reply->owner->path() }}">{{ $reply->owner->name }}</a>
                    replied {{ $reply->created_at->diffForHumans() }}
                </div>

                <div class="card-body">
                    {{ $reply->body }}
                </div>

            </div>
        </div>
    </div>
</div>

