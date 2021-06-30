<div class="side-bar">
    <div class="user-info">
        @if(!empty(auth('web')->user()->image_url))
            <img class="img-profile img-circle img-responsive center-block"
                 src="{{ auth('web')->user()->image_url }}" alt="avatar">
        @endif
        <ul class="meta list list-unstyled">
            <li class="email"><a>{{ auth('web')->user()->fullname }}</a></li>
            <li class="activity">Last logged
                in {{ auth('web')->user()->updated_at->format('d/m/Y H:i A') }}</li>
        </ul>
    </div>
    <nav class="side-menu">
        <ul class="nav">
            <li class="@if($active_menu == '') active @endif">
                <a href="{{ base_url('member') }}">
                    <span class="fa fa-user"></span> Profile
                </a>
            </li>
            <li class="@if($active_menu == 'update-profile') active @endif">
                <a href="{{ base_url('member/update-profile') }}">
                    <span class="fa fa-cog"></span> Settings
                </a>
            </li>
            <li class="@if($active_menu == 'change-password') active @endif">
                <a href="{{ base_url('member/change-password') }}">
                    <span class="fa fa-key"></span> Change password
                </a>
            </li>
            @if(!empty($manifest['nav_site']))
                @foreach($manifest['nav_site'] as $item)
                    <li class="@if($active_menu == $item['url']) active @endif">
                        <a href="{{ base_url($item['url']) }}">
                            <i class="nav-icon {{ $item['icon'] }}"></i> {{ trans($item['title']) }}
                        </a>

                        @if(!empty($item['child']))
                            <ul class="nav-dropdown-items">
                                @foreach($item['child'] as $itemChild)
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ admin_url($itemChild['url'])}}">
                                            <i class="nav-icon {{ $itemChild['icon'] }}"></i>
                                            {{ trans($itemChild['title']) }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            @endif

            <li>
                <a href="{{ base_url('member/logout') }}">
                    <span class="fa fa-sign-out"></span> Logout
                </a>
            </li>
        </ul>
    </nav>
</div>