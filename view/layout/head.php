<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Dicer">
  <base href="<?= SITE_URL ?>">

  <title>Dicer</title>
  <link rel="shortcut icon" href="media/icons/favicon.ico" type="image/x-icon">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet" SameSite=None>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/css/bootstrap.min.css" SameSite=None>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css" SameSite=None>

  <?php if ($user->isLoggedIn()) { ?>
    <link rel="stylesheet" type="text/css" href="includes/vendors/summernote2/dist/summernote-bs4.css">
    <link href="includes/vendors/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <?php } ?>

  <?php if (!Input::get('page') || Input::get('page') == 'home' || Input::get('page') == 'about-us' || Input::get('page') == 'our-programs') { ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" SameSite=None>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" SameSite=None>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" SameSite=None>
  <?php } ?>

  <link rel="stylesheet" href="includes/css/site.css">
  <link rel="stylesheet" href="includes/css/devices.css">
  <!--respons-->
  <script src="includes/js/respond.min.js"></script>
  <link rel="stylesheet" href="includes/css/sweetaleart2.min.css">
  <script src="includes/js/sweetalert2.all.min.js"></script>
  <script src="includes/js/myalerts.js"></script>
</head>

<body>