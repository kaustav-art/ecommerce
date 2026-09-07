<!doctype html>

<html
  lang="en"
  class="layout-wide customizer-hide"
  dir="ltr"
  data-skin="default"
  data-bs-theme="light"
  data-assets-path="<?= base_url('assets/'); ?>"
  data-template="vertical-menu-template">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Demo: Not Authorized - Pages | Materialize - Bootstrap Dashboard PRO</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/'); ?>img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
      rel="stylesheet" />

    <link rel="stylesheet" href="<?= base_url('assets/'); ?>vendor/fonts/iconify-icons.css" />

    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css -->

    <link rel="stylesheet" href="<?= base_url('assets/'); ?>vendor/libs/node-waves/node-waves.css" />

    <link rel="stylesheet" href="<?= base_url('assets/'); ?>vendor/libs/pickr/pickr-themes.css" />

    <link rel="stylesheet" href="<?= base_url('assets/'); ?>vendor/css/core.css" />
    <link rel="stylesheet" href="<?= base_url('assets/'); ?>css/demo.css" />

    <!-- Vendors CSS -->

    <link rel="stylesheet" href="<?= base_url('assets/'); ?>vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- endbuild -->

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="<?= base_url('assets/'); ?>vendor/css/pages/page-misc.css" />

    <!-- Helpers -->
    <script src="<?= base_url('assets/'); ?>vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js. -->
    <script src="<?= base_url('assets/'); ?>vendor/js/template-customizer.js"></script>

    <!--? Config: Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file. -->

    <script src="<?= base_url('assets/'); ?>js/config.js"></script>
  </head>

  <body>
    <!-- Content -->

    <!-- Not Authorized -->
    <div class="misc-wrapper">
      <h1 class="mb-2 mx-2" style="font-size: 6rem; line-height: 6rem">401</h1>
      <h4 class="mb-2">You are not authorized! ðŸ”</h4>
      <p class="mb-3 mx-2">You donâ€™t have permission to access this page. Go Home!</p>
      <div class="d-flex justify-content-center mt-12">
        <img
          src="<?= base_url('assets/'); ?>img/illustrations/misc-not-authorized-object.png"
          alt="misc-not-authorized"
          class="img-fluid misc-object d-none d-lg-inline-block"
          width="190" />
        <img
          src="<?= base_url('assets/'); ?>img/illustrations/misc-bg-light.png"
          alt="misc-not-authorized"
          class="misc-bg d-none d-lg-inline-block"
          data-app-light-img="illustrations/misc-bg-light.png"
          data-app-dark-img="illustrations/misc-bg-dark.png" />
        <div class="d-flex flex-column align-items-center">
          <img
            src="<?= base_url('assets/'); ?>img/illustrations/misc-not-authorized-illustration.png"
            alt="misc-not-authorized"
            class="img-fluid z-1"
            width="160" />
          <div>
            <a href="<?= site_url('dashboard'); ?>" class="btn btn-primary text-center my-10">Back to home</a>
          </div>
        </div>
      </div>
    </div>
    <!-- /Not Authorized -->

    <!-- / Content -->

    <!-- Core JS -->

    <!-- build:js assets/vendor/js/theme.js  -->

    <script src="<?= base_url('assets/'); ?>vendor/libs/jquery/jquery.js"></script>

    <script src="<?= base_url('assets/'); ?>vendor/libs/popper/popper.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/js/bootstrap.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/libs/node-waves/node-waves.js"></script>

    <script src="<?= base_url('assets/'); ?>vendor/libs/@algolia/autocomplete-js.js"></script>

    <script src="<?= base_url('assets/'); ?>vendor/libs/pickr/pickr.js"></script>

    <script src="<?= base_url('assets/'); ?>vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="<?= base_url('assets/'); ?>vendor/libs/hammer/hammer.js"></script>

    <script src="<?= base_url('assets/'); ?>vendor/libs/i18n/i18n.js"></script>

    <script src="<?= base_url('assets/'); ?>vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->

    <script src="<?= base_url('assets/'); ?>js/main.js"></script>

    <!-- Page JS -->
  </body>
</html>
