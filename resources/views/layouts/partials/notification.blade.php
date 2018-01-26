<li class="dropdown">
    <a class="dropdown-toggle count-info open-notification" data-toggle="dropdown" href="#">
        <em class="fa fa-bell"></em>
        <span class="label label-danger notification-count">
            {{ $notifications->count() }}
        </span>
    </a>
    <ul class="dropdown-menu dropdown-messages">
        @foreach($notifications as $notification)
        <li>
            <div class="dropdown-messages-box">
                <span class="pull-left">
                    <em class="fa {{ $notification->data['icon'] ?? 'fa-bell' }} fa-2x fa-fw"></em>
                </span>
                <div class="message-body">
                    <small class="pull-right">
                        {{ $notification->created_at->diffForHumans() }}
                    </small>
                    @if (! empty($notification->data['link']))
                    <a href="#">
                        {{ $notification->data['message'] }}
                    </a>
                    @else {{ $notification->data['message'] }} @endif
                    <br />
                    <small class="text-muted">
                        {{ $notification->created_at->format('Y-m-d H:i') }}
                    </small>
                </div>
            </div>
        </li>
        <li class="divider"></li>
        @endforeach
        <li>
            <div class="all-button">
                @if ($notifications->count() >= 1)
                <a href="#">
                    <em class="fa fa-inbox"></em>
                    <strong>All Notifications</strong>
                </a>
                @else
                <em class="fa fa-check"></em>
                <strong>Nothing to worry about!</strong>
                @endif
            </div>
        </li>
    </ul>
</li>