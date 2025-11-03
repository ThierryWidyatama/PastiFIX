<div id="kt_aside" class="aside" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
    <!--end::Aside Toolbarl-->
    <!--begin::Aside menu-->
    @livewire('live-search', ['route' => request()->route()->getName()])
    <!--end::Aside menu-->
    <!--begin::Footer-->
    {{-- @livewire('AsideFooter') --}}
    <!--end::Footer-->
</div>
