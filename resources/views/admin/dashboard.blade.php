@extends('layouts.admin')

@section('content')

@include('layouts.partials.flash')

<div class="panel panel-container">
    <div class="row">
        <div class="col-xs-6 col-md-3 col-lg-3 no-padding">
            <div class="panel panel-teal panel-widget border-right">
                <div class="row no-padding">
                    <em class="fa fa-xl fa-quote-right color-blue"></em>
                    <div class="large">
                        {!! Numbers\Number::n($total['quote'])->round(3)->getSuffixNotation() !!}
                    </div>
                    <div class="text-muted">{{ __('Quotes') }}</div>
                </div>
            </div>
        </div>
        <div class="col-xs-6 col-md-3 col-lg-3 no-padding">
            <div class="panel panel-blue panel-widget border-right">
                <div class="row no-padding">
                    <em class="fa fa-xl fa-th color-orange"></em>
                    <div class="large">{{ number_format($total['category']) }}</div>
                    <div class="text-muted">{{ __('Category') }}</div>
                </div>
            </div>
        </div>
        <div class="col-xs-6 col-md-3 col-lg-3 no-padding">
            <div class="panel panel-orange panel-widget border-right">
                <div class="row no-padding">
                    <em class="fa fa-xl fa-user color-teal"></em>
                    <div class="large">
                        {!! Numbers\Number::n($total['author'])->round(2)->getSuffixNotation() !!}
                    </div>
                    <div class="text-muted">{{ __('Author') }}</div>
                </div>
            </div>
        </div>
        <div class="col-xs-6 col-md-3 col-lg-3 no-padding">
            <div class="panel panel-orange panel-widget border-right">
                <div class="row no-padding">
                    <em class="fa fa-xl fa-users color-red"></em>
                    <div class="large">{{ number_format($total['user']) }}</div>
                    <div class="text-muted">{{ __('User') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default ">
            <div class="panel-heading">
                {{ __('Latest Quote') }}
                <ul class="pull-right panel-settings panel-button-tab-right">
                    <li class="dropdown">
                        <a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                            <em class="fa fa-cogs"></em>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li>
                                <ul class="dropdown-settings">
                                    <li>
                                        <a href="{{ route('admin.quote.index', [session('lang')]) }}">
                                            <em class="fa fa-cog"></em> {{ __('All Quote') }}
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
                                <div class="actions">
                                    <a class="btn btn-default btn-xs" href="{{ route('admin.quote.show', [session('lang'), $quote]) }}"><em class="fa fa-eye fa-fw"></em></a>
                                    <a class="btn btn-default btn-xs btn-copy" data-clipboard-text="{{ $quote->text }} By {{ $quote->author->name }}." href="javascript:void(0)"><em class="fa fa-copy fa-fw"></em></a>
                                    <a class="btn btn-primary btn-xs" href="{{ route('share.twitter', $quote) }}"><em class="fa fa-twitter fa-fw"></em></a>
                                </div>
                            </div>

                            <hr>

                            <div class="timeline-time">
                                <p>
                                    {{ $quote->created_at->diffForHumans() }} in
                                    <a href="{{ route('admin.category.show', [session('lang'), $quote->category]) }}">{{ $quote->category->name }}</a>
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
                {{ __('Latest Author') }}
                <ul class="pull-right panel-settings panel-button-tab-right">
                    <li class="dropdown">
                        <a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                            <em class="fa fa-cogs"></em>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li>
                                <ul class="dropdown-settings">
                                    <li>
                                        <a href="{{ route('admin.author.index', [session('lang')]) }}">
                                            <em class="fa fa-cog"></em> {{ __('All Author') }}
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
                                <div class="text-muted">{{ $author->created_at->format('M') }}</div>
                                <div class="text-muted">{{ $author->created_at->format('H:i') }}</div>
                            </div>
                            <div class="col-xs-10 col-md-10">
                                <h4>
                                    <a href="{{ route('admin.author.show', [session('lang'), $author]) }}">{{ $author->name }}</a>
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

@push('js')
<script src="https://cdn.jsdelivr.net/npm/clipboard@1/dist/clipboard.min.js"></script>

<script>
    new Clipboard('.btn-copy')
</script>
@endpush