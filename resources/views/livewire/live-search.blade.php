<div>
    <div class="aside-toolbar flex-column-auto" id="kt_aside_toolbar">
        <div class="aside-search py-5">
            <div class="header-search d-flex align-items-center w-100">
                <form data-kt-search-element="form" class="w-100 position-relative" autocomplete="off">
                    <!--begin::Hidden input(Added to disable form autocomplete)-->
                    <input type="hidden" />
                    <!--end::Hidden input-->
                    <!--begin::Icon-->
                    <i class="ki-duotone ki-magnifier fs-2 search-icon position-absolute top-50 translate-middle-y ms-4">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <!--end::Icon-->
                    <!--begin::Input-->
                    <input type="text" class="search-input form-control ps-13 fs-7 h-40px " name="search"
                        value="" placeholder="Cari Menu" data-kt-search-element="input"
                        wire:model.live.debounce.1000ms="search" />
                    <!--end::Input-->
                    <!--begin::Spinner-->
                    <span class="position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-5"
                        data-kt-search-element="spinner">
                        <span class="spinner-border h-15px w-15px align-middle text-gray-500"></span>
                    </span>
                    <!--end::Spinner-->
                    <!--begin::Reset-->
                    <span
                        class="btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-4"
                        data-kt-search-element="clear">
                        <i class="ki-duotone ki-cross fs-2 fs-lg-1 me-0">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </span>
                    <!--end::Reset-->
                </form>

            </div>
            <div wire:loading>
                <div class="d-flex justify-content-center my-2">
                    <div class="text-muted">Loading ...</div>
                </div>
            </div>
        </div>
    </div>
    <div class="aside-menu flex-column-fluid">
        <!--begin::Aside Menu-->
        <div class="hover-scroll-overlay-y mx-3 my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true"
            data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="{default: '#kt_aside_toolbar, #kt_aside_footer', lg: '#kt_header, #kt_aside_toolbar, #kt_aside_footer'}"
            data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="5px">
            <!--begin::Menu-->
            <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
                id="#kt_aside_menu" data-kt-menu="true">

                @foreach ($modules as $module)
                    @include('partials.menu-item', ['module' => $module])
                @endforeach
            </div>
            <!--end::Menu-->
        </div>
        <!--end::Aside Menu-->
    </div>

</div>
</div>
