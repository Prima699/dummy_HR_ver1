@if (!$errors->isEmpty() OR (session("error") AND session("error")!=NULL))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
		@if (!$errors->isEmpty())
			@foreach ($errors->all() as $error)
				{{ $error }} <br>
			@endforeach
		@endif
		@if(session("error") AND session("error")!=NULL)
			{!! session("error") !!}
			<?php session(["error" => NULL]); ?>
		@endif
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif