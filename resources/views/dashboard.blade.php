@extends('layouts.admin')

@section('content')
@include('layouts.partials.flash')

<div class="panel panel-container">
    <div class="row">
        <div class="col-xs-12 col-md-4 col-lg-4 no-padding">
            <div class="panel panel-teal panel-widget border-right">
                <div class="row no-padding">
                    <em class="fa fa-xl fa-quote-right color-blue"></em>
                    <div class="large">{{ number_format($total['quote'], 0) }}</div>
                    <div class="text-muted">Quotes</div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-4 col-lg-4 no-padding">
            <div class="panel panel-blue panel-widget border-right">
                <div class="row no-padding">
                    <em class="fa fa-xl fa-th color-orange"></em>
                    <div class="large">{{ number_format($total['category']) }}</div>
                    <div class="text-muted">Category</div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-4 col-lg-4 no-padding">
            <div class="panel panel-orange panel-widget border-right">
                <div class="row no-padding">
                    <em class="fa fa-xl fa-users color-teal"></em>
                    <div class="large">{{ number_format($total['author']) }}</div>
                    <div class="text-muted">Authors</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
    <div class="panel panel-default ">
        <div class="panel-heading">
            Latest Added Quotes
            <ul class="pull-right panel-settings panel-button-tab-right">
                <li class="dropdown">
                    <a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                        <em class="fa fa-cogs"></em>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li>
                            <ul class="dropdown-settings">
                                <li>
                                    <a href="{{ route('admin.quote.index') }}">
                                        <em class="fa fa-cog"></em> All Quotes
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
            <span class="pull-right clickable panel-toggle panel-button-tab-left">
                <em class="fa fa-toggle-up"></em>
            </span>
        </div>
        <div class="panel-body timeline-container">
            <ul class="timeline">
                @foreach ($latestQuotes as $quote)
                <li>
                    <div class="timeline-badge">
                        <em class="glyphicon glyphicon-pushpin"></em>
                    </div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4 class="timeline-title">{{ $quote->author->name ?? 'Unknown' }}</h4>
                        </div>
                        <div class="timeline-body">
                            <p>{{ $quote->text }}</p>
                        </div>

                        <hr>

                        <div class="timeline-time">
                            <p>
                                {{ $quote->created_at->diffForHumans() }} in <a href="{{ route('admin.category.show', $quote->category) }}">{{ $quote->category->name }}</a>
                            </p>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
</div>
@endsection