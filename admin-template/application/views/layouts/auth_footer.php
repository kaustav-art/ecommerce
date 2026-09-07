    <!-- Core JS -->
    <script src="<?= base_url('assets/vendor/libs/jquery/jquery.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/libs/popper/popper.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/js/bootstrap.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/libs/node-waves/node-waves.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/libs/@algolia/autocomplete-js.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/libs/pickr/pickr.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/libs/hammer/hammer.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/libs/i18n/i18n.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/js/menu.js'); ?>"></script>

    <!-- Vendors JS -->
    <script src="<?= base_url('assets/vendor/libs/@form-validation/popular.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/libs/@form-validation/bootstrap5.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/libs/@form-validation/auto-focus.js'); ?>"></script>

    <!-- Main JS -->
    <script src="<?= base_url('assets/js/main.js'); ?>"></script>

    <!-- Page JS -->
    <script src="<?= base_url('assets/js/pages-auth.js'); ?>"></script>
    <?php if (isset($extra_js)) echo $extra_js; ?>
  </body>
</html>
