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

<script>
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

        $(".date-picker").datepicker({
            weekStart: 1,
            language: "vi",
            todayHighlight: true,
            autoclose: true,
            startDate: "01/01/2021",
            endDate: new Date(),
        }).datepicker("setDate", "today");

        $(".year-month-picker").datepicker({
            language: "vi",
            format: "mm/yyyy",
            minViewMode: 1,
            maxViewMode: 2,
            autoclose: true,
            startDate: "01/2021",
            endDate: new Date(),
        }).datepicker("setDate", "today");
    });
</script>
