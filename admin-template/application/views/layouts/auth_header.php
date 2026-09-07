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
    <title><?= isset($title) ? html_escape($title) : 'Authentication | Materialize'; ?></title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/favicon/favicon.ico'); ?>" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
      rel="stylesheet" />

    <link rel="stylesheet" href="<?= base_url('assets/vendor/fonts/iconify-icons.css'); ?>" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/libs/node-waves/node-waves.css'); ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/vendor/libs/pickr/pickr-themes.css'); ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/core.css'); ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/demo.css'); ?>" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css'); ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/vendor/libs/@form-validation/form-validation.css'); ?>" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/pages/page-auth.css'); ?>" />

    <!-- Helpers -->
    <script src="<?= base_url('assets/vendor/js/helpers.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/js/template-customizer.js'); ?>"></script>
    <script src="<?= base_url('assets/js/config.js'); ?>"></script>
  </head>

  <body>
