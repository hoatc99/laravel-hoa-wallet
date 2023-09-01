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
<script src="{{ asset('assets/libs/@claviska/jquery-minicolors/jquery.minicolors.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap-switch/dist/js/bootstrap-switch.min.js') }}"></script>
<script src="{{ asset('assets/libs/inputmask/dist/jquery.inputmask.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap-material-datetimepicker/node_modules/moment/moment.js') }}"></script>
<script src="{{ asset('assets/libs/daterangepicker/daterangepicker.js') }}"></script>

<script>
    $(() => {
        "use strict";
        $("#input_amount").inputmask("currency", {
            radixPoint: ".",
            groupSeparator: ",",
            digits: 0,
            autoGroup: true,
            suffix: ',000',
        }).on('click focus', function() {
            let newPosition = $('#input_amount').val().length - 3;
            $(this)[0].setSelectionRange(newPosition, newPosition);
        });

        $(".singledate").daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            autoApply: true,
            locale: {
                format: 'DD/MM/YYYY',
                "daysOfWeek": [
                    "CN",
                    "Hai",
                    "Ba",
                    "Tư",
                    "Năm",
                    "Sáu",
                    "Bảy"
                ],
                monthNames: [
                    "Tháng Một",
                    "Tháng Hai",
                    "Tháng Ba",
                    "Tháng Tư",
                    "Tháng Năm",
                    "Tháng Sáu",
                    "Tháng Bảy",
                    "Tháng Tám",
                    "Tháng Chín",
                    "Tháng Mười",
                    "Tháng Mười Một",
                    "Tháng Mười Hai",
                ],
                firstDay: 1,
            },
            minDate: "01/01/2021",
            maxDate: moment(),
        });
    });
</script>
