{{--<nav class="side-nav">--}}
{{--    <ul>--}}
{{--        <li>--}}
{{--            <a href="{{ route('dashboard') }}"--}}
{{--               class="side-menu @if(request()->route()->getName() === 'dashboard') side-menu--active @endif">--}}
{{--                <div class="side-menu__icon"><i data-lucide="home"></i></div>--}}
{{--                <div class="side-menu__title">--}}
{{--                    Dashboard--}}
{{--                </div>--}}
{{--            </a>--}}
{{--        </li>--}}
{{--        <li>--}}
{{--            <a href="{{ route('role.index') }}"--}}
{{--               class="side-menu @if(request()->is('role*')) side-menu--active @endif">--}}
{{--                <div class="side-menu__icon"><i data-lucide="list"></i></div>--}}
{{--                <div class="side-menu__title"> Role Management</div>--}}
{{--            </a>--}}
{{--        </li>--}}
{{--        <li>--}}
{{--            <a href="{{ route('user.index') }}"--}}
{{--               class="side-menu @if(request()->is('user*')) side-menu--active @endif">--}}
{{--                <div class="side-menu__icon"><i data-lucide="user"></i></div>--}}
{{--                <div class="side-menu__title"> User Management</div>--}}
{{--            </a>--}}
{{--        </li>--}}
{{--    </ul>--}}
{{--</nav>--}}
<nav class="side-nav">
    <ul>
        @foreach($menu as $item)
            <li>
                <a class="side-menu"
                   @if($item->last()->count() == 0) href="{{ $item->get('link')  }}  @endif">
                    <div class="side-menu__icon">
                        <i class="" data-lucide="{{ $item->get('icon') }}"></i>
                    </div>
                    <div class="side-menu__title">
                        {{ $item->get('name') }}
                        @if($item->last()->count() > 0)
                            <div class="side-menu__sub-icon"><i data-lucide="chevron-down"></i>
                            </div>
                        @endif
                    </div>
                </a>
                <ul>
                    @foreach($item->last() as $childItem)
                        <li class="">
                            <a @if($childItem->last()->count() == 0) href="{{ $childItem->get('link') }}"
                               @endif class="side-menu">
                                <div class="side-menu__icon mx-0"><i
                                        data-lucide="{{ $childItem->get('icon') }}"></i>
                                </div>
                                <div class="side-menu__title">
                                    {{ $childItem->first() }}
                                    @if($childItem->last()->count() > 0)
                                        <div class="side-menu__sub-icon">
                                            <i data-lucide="chevron-down"></i>
                                        </div>
                                    @endif
                                </div>
                            </a>
                            @if($childItem->last()->count() > 0)
                                <ul>
                                    @foreach($childItem->last() as $child)
                                        <li class="">
                                            <a href="{{ $child->get('link') }}" class="side-menu">
                                                <div class="side-menu__icon mx-0"><i
                                                        data-lucide="{{ $child->get('icon') }}"></i>
                                                </div>
                                                <div class="side-menu__title">
                                                    {{ $child->first() }}
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach

    </ul>
</nav>
