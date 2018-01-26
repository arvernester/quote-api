@extends('layouts.admin')

@section('content')

@include('layouts.partials.flash')

<div class="panel panel-container">
    <div class="row">
        <div class="col-xs-6 col-md-3 col-lg-3 no-padding">
            <div class="panel panel-teal panel-widget border-right">
                <div class="row no-padding">
                    <em class="fa fa-xl fa-quote-right color-blue"></em>
                    <div class="large">{{ number_format($total['quote'], 0) }}</div>
                    <div class="text-muted">Quotes</div>
                </div>
            </div>
        </div>
        <div class="col-xs-6 col-md-3 col-lg-3 no-padding">
            <div class="panel panel-blue panel-widget border-right">
                <div class="row no-padding">
                    <em class="fa fa-xl fa-th color-orange"></em>
                    <div class="large">{{ number_format($total['category']) }}</div>
                    <div class="text-muted">Categories</div>
                </div>
            </div>
        </div>
        <div class="col-xs-6 col-md-3 col-lg-3 no-padding">
            <div class="panel panel-orange panel-widget border-right">
                <div class="row no-padding">
                    <em class="fa fa-xl fa-user color-teal"></em>
                    <div class="large">{{ number_format($total['author']) }}</div>
                    <div class="text-muted">Authors</div>
                </div>
            </div>
        </div>
        <div class="col-xs-6 col-md-3 col-lg-3 no-padding">
            <div class="panel panel-orange panel-widget border-right">
                <div class="row no-padding">
                    <em class="fa fa-xl fa-users color-red"></em>
                    <div class="large">{{ number_format($total['user']) }}</div>
                    <div class="text-muted">Users</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default ">
            <div class="panel-heading">
                Latest Quotes
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
                        <div class="timeline-badge primary">
                            <em class="fa fa-quote-right"></em>
                        </div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4 class="timeline-title">{{ $quote->author->name ?? 'Unknown' }}</h4>
                            </div>
                            <div class="timeline-body">
                                <p>{{ $quote->text }}</p>
                                <p><a href="{{ route('admin.quote.show', $quote) }}">Show</a></p>
                            </div>

                            <hr>

                            <div class="timeline-time">
                                <p>
                                    {{ $quote->created_at->diffForHumans() }} in
                                    <a href="{{ route('admin.category.show', $quote->category) }}">{{ $quote->category->name }}</a>
                                </p>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default articles">
            <div class="panel-heading">
                Latest Authors
                <ul class="pull-right panel-settings panel-button-tab-right">
                    <li class="dropdown">
                        <a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                            <em class="fa fa-cogs"></em>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li>
                                <ul class="dropdown-settings">
                                    <li>
                                        <a href="{{ route('admin.author.index') }}">
                                            <em class="fa fa-cog"></em> All Authors
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
            <div class="panel-body articles-container">
                @foreach ($latestAuthors as $author)
                <div class="article border-bottom">
                    <div class="col-xs-12">
                        <div class="row">
                            <div class="col-xs-2 col-md-2 date">
                                <div class="large">{{ $author->created_at->format('d') }}</div>
                                <div class="text-muted">{{ $author->created_at->format('F') }}</div>
                            </div>
                            <div class="col-xs-10 col-md-10">
                                <h4>
                                    <a href="{{ route('admin.author.show', $author) }}">{{ $author->name }}</a>
                                </h4>
                                <p>{{ $author->latestQuote->text }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
                @endforeach
            </div>
        </div>
        <!--End .articles-->
    </div>
    <!--/.col-->
</div>
@endsection