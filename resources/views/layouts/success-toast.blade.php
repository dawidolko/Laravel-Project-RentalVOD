@if (Session::has('successToast'))
<div id="themeToast" class="toast text-bg-success position-absolute top-50 start-50 translate-middle" role="alert"
aria-live="assertive" aria-atomic="true">
<div class="d-flex">
    <div class="toast-body">{{Session::get('successToast')}}</div>
    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
</div>
@endif
