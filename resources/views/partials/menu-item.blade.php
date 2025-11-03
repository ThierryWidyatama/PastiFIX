<!-- Partials: menu-item.blade.php -->
@php
    // Check if the current module or any of its children are active.
    $isActive = request()->is($module->link) || request()->segment(1) == $module->link || $module->child->contains(function ($child) {
        return request()->is($child->link) || request()->segment(1) == $child->link || $child->child->contains(function ($subChild) {
            return request()->is($subChild->link) || request()->segment(1) == $subChild->link;
        });
    });
@endphp
<style>

</style>
@if ($module->child->isNotEmpty() && $module->permission->first()->publish == 1 && $module->is_category == null)
    <!-- Module with children -->
    <div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1 {{ $isActive ? 'show' : '' }}">
        <span class="menu-link">
            <span class="menu-icon">
                {!! $module->icon !!}
            </span>
            <span class="menu-title">{{ $module->name }}</span>
            <span class="menu-arrow"></span>
        </span>

        <!-- Recursive: Loop through child modules -->
        <div class="menu-sub menu-sub-accordion">
            @foreach ($module->child->sortBy('order') as $child)
                @include('partials.menu-item', ['module' => $child])
            @endforeach
        </div>
    </div>
@elseif ($module->is_category == 1 && $module->permission->first()->publish == 1)
    <!-- Category with children -->
    <div class="menu-item mb-1">
        <a class="menu-link" style="pointer-events: none;">
            <span class="menu-title text-white">{{ $module->name }}</span>
        </a>
    </div>
    @foreach ($module->child->filter(fn($child) => $child->permission->first()?->publish == 1)->sortBy('order') as $item)
        @include('partials.menu-item', ['module' => $item])
    @endforeach
@elseif ($module->permission && $module->permission->first() && $module->permission->first()->publish == 1)
    <!-- Standalone child without further children -->
    <div class="menu-item mb-1">
        <a class="menu-link {{ $isActive ? 'active' : '' }}" href="/{{ $module->link ?? '#' }}">
            <span class="menu-icon">
                {!! $module->icon !!}
            </span>
            <span class="menu-title">{{ $module->name }}</span>
        </a>
    </div>
@endif

