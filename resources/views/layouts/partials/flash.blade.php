<div class="row">
    <div class="col-md-12">

        @if(session('success'))
            <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

                <strong>Success!</strong><br>
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

                <strong>Error!</strong><br>
                {{ session('error') }}
            </div>
        @endif

    </div>
</div>