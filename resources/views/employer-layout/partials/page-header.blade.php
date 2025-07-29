@if(View::hasSection('header'))
    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
        <h1 class="h4">@yield('header')</h1>
    </div>
@endif
