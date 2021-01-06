const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.setPublicPath("public");
// mix.disableNotifications();

mix.styles(
    [
        "resources/plugins/fontawesome-free/css/all.min.css",
        "resources/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css",
        "resources/plugins/bootstrap-switch/css/bootstrap3/bootstrap-switch.min.css",
        "resources/plugins/daterangepicker/daterangepicker.css",
        "resources/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css",
        "resources/plugins/dropify/dropify.min.css",
        "resources/plugins/ekko-lightbox/ekko-lightbox.css",
        "resources/plugins/icheck-bootstrap/icheck-bootstrap.min.css",
        "resources/plugins/overlayScrollbars/css/OverlayScrollbars.min.css",
        "resources/plugins/pace-progress/themes/yellow/pace-theme-minimal.css",
        "resources/plugins/select2/css/select2.min.css",
        "resources/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css",
        "resources/plugins/summernote/summernote-bs4.css",
        "resources/plugins/sweetalert2/sweetalert2.min.css",
        "resources/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css",
        "resources/plugins/tablesaw/tablesaw.css",
      //   "resources/plugins/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.css",
        "resources/plugins/toastr/toastr.min.css",
        "resources/css/ionicons/ionicons.min.css",
        "resources/css/adminlte.min.css",
        "resources/css/source-sans.css",
        "resources/css/app.css"
    ],
    "public/css/app.css"
);

mix.scripts(
    [
        "resources/plugins/jquery/jquery.min.js",
        // "resources/plugins/popper/popper.min.js",
        "resources/plugins/bootstrap/js/bootstrap.bundle.min.js",
        "resources/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js",
        "resources/plugins/bootstrap-switch/js/bootstrap-switch.min.js",
        "resources/plugins/bs-custom-file-input/bs-custom-file-input.min.js",
        "resources/plugins/daterangepicker/daterangepicker.js",
        "resources/plugins/datatables/jquery.dataTables.min.js",
        "resources/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js",
        "resources/plugins/dropify/dropify.min.js",
        "resources/plugins/ekko-lightbox/ekko-lightbox.min.js",
        "resources/plugins/highcharts/code/highcharts.js",
        "resources/plugins/highcharts/code/highcharts-more.js",
        "resources/plugins/moment/moment.min.js",
        "resources/plugins/jquery.inputmask.bundle.min.js",
        "resources/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js",
        "resources/plugins/pace-progress/pace.min.js",
        "resources/plugins/select2/js/select2.min.js",
        "resources/plugins/summernote/summernote-bs4.min.js",
        "resources/plugins/sweetalert2/sweetalert2.min.js",
        "resources/plugins/tablesaw/tablesaw.jquery.js",
      //   "resources/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js",
        "resources/plugins/toastr/toastr.min.js",
        "resources/js/adminlte.min.js",
        "resources/js/app.js",
        "resources/js/toolsuim.js"
    ],
    "public/js/app.js"
);
