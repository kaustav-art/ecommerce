<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
    <meta charset="utf-8">
    <title><?= isset($title) ? html_escape($title) : 'Modave - Multipurpose eCommerce'; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="Modave Multipurpose eCommerce Store">

    <!-- Fonts -->
    <link rel="stylesheet" href="<?= base_url('assets/fonts/fonts.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/fonts/font-icons.css'); ?>">
    <!-- Font Awesome 7 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css">

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/swiper-bundle.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/animate.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/styles.css?v=' . (file_exists(FCPATH . 'assets/css/styles.css') ? filemtime(FCPATH . 'assets/css/styles.css') : '1.1')); ?>">

    <!-- Font Awesome Integration Helpers & Category Circle Rules -->
    <style>
        #header .nav-icon .nav-icon-item i[class*="fa-"] {
            font-size: 20px;
            color: #111;
            transition: color 0.2s ease;
        }
        #header .nav-icon .nav-icon-item:hover i[class*="fa-"] {
            color: var(--primary, #000);
        }
        .box-icon i[class*="fa-"] {
            font-size: 16px;
            line-height: 1;
        }
        .tf-icon-box .icon-box i[class*="fa-"] {
            font-size: 38px;
            color: #111;
        }
        /* Perfect Circle Category Images */
        .collection-circle .img-style {
            aspect-ratio: 1 / 1 !important;
            border-radius: 50% !important;
            overflow: hidden !important;
            background-color: #f7f7f7;
            -webkit-mask-image: -webkit-radial-gradient(white, black);
            isolation: isolate;
        }
        .collection-circle .img-style img,
        .collection-circle .img-style > img {
            width: 100% !important;
            height: 100% !important;
            aspect-ratio: 1 / 1 !important;
            object-fit: cover !important;
            object-position: center center !important;
            border-radius: 50% !important;
            display: block !important;
        }
    </style>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= base_url('assets/images/logo/favicon.png'); ?>">
    <link rel="apple-touch-icon-precomposed" href="<?= base_url('assets/images/logo/favicon.png'); ?>">
</head>
<body class="preload-wrapper">
    <!-- Scroll Top -->
    <button id="scroll-top">
        <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M3 11.9175L12 2.91748L21 11.9175H16.5V20.1675C16.5 20.3664 16.421 20.5572 16.2803 20.6978C16.1397 20.8385 15.9489 20.9175 15.75 20.9175H8.25C8.05109 20.9175 7.86032 20.8385 7.71967 20.6978C7.57902 20.5572 7.5 20.3664 7.5 20.1675V11.9175H3Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg> 
    </button>

    <div id="wrapper">
