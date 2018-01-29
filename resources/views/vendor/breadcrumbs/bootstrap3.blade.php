@if ($breadcrumbs->count())
    <ol class="breadcrumb">
        @if (!request()->routeIs('admin.dashboard'))
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <em class="fa fa-home fa-fw"></em>
                </a>
            </li>
        @else
            <li class="active"><em class="fa fa-home fa-fw"></em></li>
        @endif
        @foreach ($breadcrumbs as $breadcrumb)
            @if ($breadcrumb->url() && $loop->remaining)
                <li><a href="{{ $breadcrumb->url() }}">{{ $breadcrumb->title() }}</a></li>
            @else
                <li class="active">{{ $breadcrumb->title() }}</li>
            @endif
        @endforeach
    </ol>
@endif
