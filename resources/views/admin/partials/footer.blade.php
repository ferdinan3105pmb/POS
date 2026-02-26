    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
        integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(document).on('submit', 'form', function() {
                $('button').attr('disabled', 'disabled');
            });
        });
    </script>
    <script>
        $(document).ready(function(e) {
            $('.datepicker').datepicker({
                format: 'dd-mm-yyyy',
                orientation: 'bottom'
            });
            $('.date').datepicker({
                startDate: "-14m",
                // endDate: "+2m",
                format: "dd-mm-yyyy",
                orientation: 'auto bottom',
                autoclose: true
            });
        });

        function showError(data) {
            $('.invalid-feedback').remove();
            $.each(data, function(idx, item) {
                $('#' + idx).addClass('is-invalid');
                $('#' + idx).parent().append('<div class="invalid-feedback">' + item + '</div>')
            })
        }
    </script>
    @stack('js')
    </body>

    </html>