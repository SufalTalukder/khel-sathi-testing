<script type="text/javascript">
    function syncToastrToJqToast() {
        if (typeof toastr !== 'undefined' && typeof success === 'function') {
            toastr.success = function(msg) { success(msg); };
            toastr.error = function(msg) { error(msg); };
            toastr.warning = function(msg) { warning(msg); };
            toastr.info = function(msg) { info(msg); };
        }
    }
    syncToastrToJqToast();
    $(document).ready(syncToastrToJqToast);
</script>

@if($message = session()->get('success'))
<script type="text/javascript">
    $(document).ready(function() {
        if (typeof success === 'function') {
            success("{{ $message }}");
        } else if (typeof toastr !== 'undefined') {
            toastr.success("{{ $message }}");
        }
    });
</script>
@endif
@if($message = session()->get('error'))
<script type="text/javascript">
    $(document).ready(function() {
        if (typeof error === 'function') {
            error("{{ $message }}");
        } else if (typeof toastr !== 'undefined') {
            toastr.error("{{ $message }}");
        }
    });
</script>
@endif
@if($message = session()->get('warning'))
<script type="text/javascript">
    $(document).ready(function() {
        if (typeof warning === 'function') {
            warning("{{ $message }}");
        } else if (typeof toastr !== 'undefined') {
            toastr.warning("{{ $message }}");
        }
    });
</script>
@endif
@if($message = session()->get('info'))
<script type="text/javascript">
    $(document).ready(function() {
        if (typeof info === 'function') {
            info("{{ $message }}");
        } else if (typeof toastr !== 'undefined') {
            toastr.info("{{ $message }}");
        }
    });
</script>
@endif
@if($errors->any())
<script type="text/javascript">
    $(document).ready(function() {
        @foreach($errors->all() as $err)
        if (typeof error === 'function') {
            error("{{ $err }}");
        } else if (typeof toastr !== 'undefined') {
            toastr.error("{{ $err }}");
        }
        @endforeach
    });
</script>
@endif


@if(session()->has('success_marked'))
<script type="text/javascript">
    Swal.fire({
        position: 'top-end',
        //   icon: 'success',
        title: "{{session()->get('success_marked')}}",
        showConfirmButton: false,
        timer: 8000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    })
</script>
@endif

<div class="modal fade" id="query_form_reply" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabels" aria-hidden="true">
    <div class="modal-dialog modal-lg" id="prodiv">
        <div class="modal-content" id="query_form_reply_append">

        </div>
    </div>
</div>


<div class="modal fade" id="query_form_iamge" aria-labelledby="exampleModalLabels" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="query_form_image_append">

        </div>
    </div>
</div>