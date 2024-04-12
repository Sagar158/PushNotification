<nav class="sidebar">
    <div class="sidebar-header">
      <a href="#" class="sidebar-brand">
        Noble<span>UI</span>
      </a>
      <div class="sidebar-toggler not-active">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
    <div class="sidebar-body">
      <ul class="nav">
        <li class="nav-item nav-category">Main</li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="link-icon" data-feather="box"></i>
            <span class="link-title">Dashboard</span>
          </a>
        </li>
        @can('viewAny',\App\Models\Slider::class)
        <li class="nav-item nav-category">Slides</li>
            <li class="nav-item">
                <a href="{{ route('slider.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="sliders"></i>
                    <span class="link-title">Slides</span>
                </a>
            </li>
        @endcan

        @can('viewAny',\App\Models\Faq::class)
        <li class="nav-item nav-category">Faqs</li>
            <li class="nav-item">
                <a href="{{ route('faq.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="help-circle"></i>
                    <span class="link-title">Faq's</span>
                </a>
            </li>
        @endcan
        @can('viewAny',\App\Models\Announcement::class)
        <li class="nav-item nav-category">Announcements</li>
            <li class="nav-item">
                <a href="{{ route('announcements.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="bell"></i>
                    <span class="link-title">Announcements</span>
                </a>
            </li>
        @endcan
        <li class="nav-item nav-category">User</li>
        @can('viewAny',\App\Models\User::class)
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#users" role="button" aria-expanded="false" aria-controls="users">
                <i class="link-icon" data-feather="users"></i>
                <span class="link-title">Manage Users</span>
                <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="users">
                <ul class="nav sub-menu">
                    @can('viewAny',\App\Models\User::class)
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link">Users</a>
                        </li>
                    @endcan
                    @can('viewAny',\App\Models\UserType::class)
                        <li class="nav-item">
                        <a href="{{ route('usertype.index') }}" class="nav-link">Permissions</a>
                        </li>
                    @endcan
                </ul>
                </div>
            </li>
        @endcan
      </ul>
    </div>
</nav>
