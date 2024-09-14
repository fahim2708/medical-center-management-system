<div class="navbar navbar-expand-md header-menu-one bg-light">
    <div class="nav-bar-header-one">
        <div class="header-logo" style="color: navy; font-weight: bold; font-style: italic; font-size: 20px;">
            <a href="{{ route('home') }}">
                <i class="far fa-hospital"></i> Paradigm Medical
            </a>
        </div>

        <div class="toggle-button sidebar-toggle">
            <button type="button" class="item-link">
                <span class="btn-icon-wrap">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </button>
        </div>
    </div>
    <div class="d-md-none mobile-nav-bar">
        <button class="navbar-toggler pulse-animation" type="button" data-toggle="collapse"
            data-target="#mobile-navbar" aria-expanded="false">
            <i class="far fa-arrow-alt-circle-down"></i>
        </button>
        <button type="button" class="navbar-toggler sidebar-toggle-mobile">
            <i class="fas fa-bars"></i>
        </button>
    </div>
    <div class="header-main-menu collapse navbar-collapse" id="mobile-navbar">
        <ul class="navbar-nav">
            <li class="navbar-item header-search-bar">
                <div class="input-group stylish-input-group">


                </div>
            </li>
        </ul>
        <ul class="navbar-nav">


            {{-- Notifications Start--}}
            @php
                // Get total count of unread notifications
                $unreadCount = App\Models\Notification::where('is_read', 0)->count();

                // Get unread notifications for the authenticated admin/superadmin user
                $unreadNotifications = App\Models\Notification::where('is_read', 0)// Fetch notifications only for the logged-in user
                    ->latest() // Fetch latest notifications first
                    ->take(3) // Limit to 5 notifications
                    ->get();
            @endphp
            @if (Auth::user()->type == 'superadmin' || Auth::user()->type == 'admin')
                <li class="navbar-item dropdown header-notification">
                    <a class="navbar-nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                        aria-expanded="false">
                        <i class="far fa-bell"></i>
                        <div class="item-title d-md-none text-16 mg-l-10">Notification</div>
                        <span>{{ $unreadCount }}</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="item-header">
                            <h6 class="item-title">{{ $unreadCount }} Notifiacations</h6>
                        </div>
                        <div class="item-content">
                            @foreach ($unreadNotifications as $notification)
                                <div class="media notification-item" data-id="{{ $notification->id }}">
                                    <div class="item-icon bg-skyblue">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div class="media-body space-sm">
                                        <div class="post-title">{{ $notification->message }} in folder: {{ $notification->folder->folder_name}}</div>
                                    </div>
                                </div>
                            @endforeach
                            <!-- If no unread notifications, display a message -->
                            @if ($unreadNotifications->isEmpty())
                                <div class="media">
                                    <div class="media-body space-sm">
                                        <div class="post-title">No new notifications</div>
                                    </div>
                                </div>
                            @endif

                        </div>
                        <!-- Button to see all notifications -->
                        <div class="dropdown-footer">
                            <a href="{{ route('notifications.index') }}" class="btn btn-primary btn-block">See All
                                Notifications</a>
                        </div>
                    </div>
                </li>
            @endif
            {{-- Notifications End--}}
            {{-- Urgent Notification Start--}}
            @php
                // Get total count of unread notifications
                $unreadCount = App\Models\UrgentNotification::where('is_read', 0)->count();

                // Get unread notifications for the authenticated admin/superadmin user
                $unreadUNotifications = App\Models\UrgentNotification::where('is_read', 0)// Fetch notifications only for the logged-in user
                    ->latest() // Fetch latest notifications first
                    ->take(3) // Limit to 5 notifications
                    ->get();
            @endphp
            @if (Auth::user()->type == 'superadmin' || Auth::user()->type == 'admin')
                <li class="navbar-item dropdown header-notification">
                    <a class="navbar-nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div class="item-title d-md-none text-16 mg-l-10">Notification</div>
                        <span>{{ $unreadCount }}</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="item-header">
                            <h6 class="item-title">{{ $unreadCount }} Urgent Notifiacations</h6>
                        </div>
                        <div class="item-content">
                            @foreach ($unreadUNotifications as $notification)
                                <div class="media notification-item" data-id="{{ $notification->id }}">
                                    <div class="item-icon bg-skyblue">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div class="media-body space-sm">
                                        <div class="post-title">{{ $notification->message }} in folder: {{ $notification->folder->folder_name}}</div>
                                    </div>
                                </div>
                            @endforeach
                            <!-- If no unread notifications, display a message -->
                            @if ($unreadUNotifications->isEmpty())
                                <div class="media">
                                    <div class="media-body space-sm">
                                        <div class="post-title">No new notifications</div>
                                    </div>
                                </div>
                            @endif

                        </div>
                        <!-- Button to see all notifications -->
                        <div class="dropdown-footer">
                            <a href="{{ route('u-notifications.index') }}" class="btn btn-primary btn-block">See All</a>
                        </div>
                    </div>
                </li>
            @endif
            {{-- Urgent Notification End--}}
            {{-- Username and Logout Section --}}
            <li class="navbar-item dropdown header-admin">
                <a class="navbar-nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                    aria-expanded="false">
                    <div class="admin-title">
                        <h5 class="item-title">{{ auth()->user()->name }}</h5>
                        <span>{{ auth()->user()->type }}</span>
                    </div>
                    <div class="admin-img">
                        <img src="{{ asset('backend/img') }}/figure/user.png" alt="Admin">
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right">

                    <div class="item-content">
                        <ul class="logout-menu">
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="logout-button">
                                        <i class="flaticon-turn-off"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>

                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>
<script>
    document.querySelectorAll('.notification-item').forEach(item => {
        item.addEventListener('click', function() {
            var notificationId = this.getAttribute('data-id');

            console.log('Clicked notification with ID:', notificationId);

            // Send an AJAX request to mark the notification as read
            fetch(`/notifications/${notificationId}/read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Response from server:', data);

                    if (data.success) {
                        // Optionally, hide the notification or update the UI
                        this.style.display = 'none';

                        // Safely update the notification count
                        let notificationCountElement = document.querySelector(
                            '.navbar-nav-link span');
                        let notificationCount = parseInt(notificationCountElement.textContent);

                        if (notificationCount > 1) {
                            notificationCountElement.textContent = notificationCount - 1;
                        } else {
                            notificationCountElement.textContent = '0';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error marking notification as read:', error);
                });
        });
    });
</script>
