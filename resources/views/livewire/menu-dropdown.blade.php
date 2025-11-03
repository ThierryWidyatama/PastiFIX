<div>
    <div class="menu">
        @if($modules->isNotEmpty())
            @foreach ($modules as $module)
                @include('partials.menu-item', ['module' => $module])
            @endforeach
        @endif
    </div>
</div>
