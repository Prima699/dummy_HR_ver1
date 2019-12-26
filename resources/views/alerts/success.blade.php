@if (session($key ?? 'status') AND session($key ?? 'status')!=NULL)
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session($key ?? 'status') }}
		<?php session(["status" => NULL]); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif