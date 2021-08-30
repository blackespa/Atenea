<ul class="nested">
    @foreach ($childs as $child)
        @if(count($child->childs))
            <li><span class="caret"></span><span class="dblclick" data-id="{{ $child->id }}"><i class="far fa-folder"></i> {{ $child->name }}</span>
                @include('menus.admin-treeChild', ['childs' => $child->childs])
            </li>
        @else
            <li class="dblclick" data-id="{{ $child->id }}"><i class="far fa-file"></i> {{ $child->name }}</li>
        @endif
    @endforeach
</ul>
