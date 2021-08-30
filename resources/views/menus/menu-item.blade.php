@if ( $item['submenu'] == [] )
    <li class="nav-item">
        <a href="#" class="nav-link" data-type="user">{{ $item['name'] }}</a>
    </li>
@else
    @if($level == 0)
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="{{ 'menu-'.$item['id'] }}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $item['name'] }}</a>
            <ul class="dropdown-menu" aria-labelledby="{{ 'menu-'.$item['id'] }}">
                @foreach ($item['submenu'] as $submenu)
                    @if ( $submenu['submenu'] == [] )
                        <li><a class="dropdown-item" href="#" data-id="{{ $submenu['id'] }}" data-type="user">{{ $submenu['name'] }}</a></li>
                    @else
                        @include('menus.menu-item' , ['item' => $submenu , 'level' => ($level + 1)] )
                    @endif
                @endforeach
            </ul>
        </li>
    @else
        <li>
            <a class="dropdown-item dropdown-toggle" href="#" id="{{ 'menu-'.$item['id'] }}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $item['name'] }}</a>
            <ul class="dropdown-menu" aria-labelledby="{{ 'menu-'.$item['id'] }}">
                @foreach ($item['submenu'] as $submenu)
                    @if ( $submenu['submenu'] == [] )
                        <li><a class="dropdown-item" href="#" data-id="{{ $submenu['id'] }}" data-type="user">{{ $submenu['name'] }}</a></li>
                    @else
                        @include('menus.menu-item' , ['item' => $submenu , 'level' => ($level + 1)] )
                    @endif
                @endforeach
            </ul>
        </li>
    @endif
@endif
