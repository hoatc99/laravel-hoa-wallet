<!--  Import Js Files -->
<script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<!--  core files -->
<script src="{{ asset('assets/js/app.min.js') }}"></script>
<script src="{{ asset('assets/js/app.init.js') }}"></script>
<script src="{{ asset('assets/js/app-style-switcher.js') }}"></script>
<script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
<!--  lib files -->
<script src="{{ asset('assets/libs/bootstrap-switch/dist/js/bootstrap-switch.min.js') }}"></script>
<script src="{{ asset('assets/libs/inputmask/dist/jquery.inputmask.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap-datepicker/locales/bootstrap-datepicker.vi.min.js') }}"></script>
<script src="{{ asset('assets/libs/sortablejs/sortable.min.js') }}"></script>
<script src="{{ asset('assets/libs/toastrjs/dist/js/toastr.min.js') }}"></script>
<script src="{{ asset('assets/libs/moment.js/moment.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net/js/plug-ins/sorting/datetime-moment.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net/js/plug-ins/dataRender/datetime.js') }}"></script>
<!--  user customize -->
<script src="{{ asset('assets/js/apexcharts.js') }}"></script>
<script src="{{ asset('assets/js/datatable.js') }}"></script>
<script src="{{ asset('assets/js/toastr.js') }}"></script>

<script>
    const loadDatePicker = () => {
        $(".date-picker").datepicker({
            weekStart: 1,
            language: "vi",
            todayHighlight: true,
            autoclose: true,
            startDate: "01/01/2021",
            endDate: new Date(),
        }).datepicker("setDate", "0");

        $(".year-month-picker").datepicker({
            language: "vi",
            format: "yyyy/mm",
            minViewMode: 1,
            maxViewMode: 2,
            autoclose: true,
            startDate: "01/2021",
            endDate: new Date(),
        }).datepicker("setDate", "0");

        $(".year-picker").datepicker({
            language: "vi",
            format: "yyyy",
            minViewMode: 2,
            maxViewMode: 2,
            autoclose: true,
            startDate: "2021",
            endDate: new Date(),
        }).datepicker("setDate", "today");
    }

    $(() => {
        "use strict";
        $(".input-money").inputmask("currency", {
            radixPoint: ".",
            groupSeparator: ",",
            digits: 0,
            autoGroup: true,
            suffix: ',000',
        }).on('click focus', function() {
            let pos = $('.input-money').val().length - 3;
            $(this)[0].setSelectionRange(pos, pos);
        });

        loadDatePicker();

        if ({{ \Session::has('success') ? 'true' : 'false' }}) {
            renderToastr('success', '{{ \Session::get('success') }}');
        }

        if ({{ \Session::has('error') ? 'true' : 'false' }}) {
            renderToastr('error', '{{ \Session::get('error') }}');
        }
    });
</script>
