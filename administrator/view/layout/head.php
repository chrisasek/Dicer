<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Dicer">
  <meta name="generator" content="Hugo 0.98.0">
  <meta name="theme-color" content="#712cf9">
  <base href="<?= SITE_ADMIN_URL ?>">
  <title>Administrator | Dicer</title>
  <link rel="shortcut icon" href="<?= SITE_URL; ?>assets/icons/favicon.ico" type="image/x-icon">
  <link rel="icon" href="<?= SITE_URL; ?>assets/icons/favicon.ico" type="image/x-icon">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet" SameSite=None>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <?php if ($user->isLoggedIn()) { ?>
    <?php if (Input::get('page') && (Input::get('page') == 'blogs' && Input::get('action')) || Input::get('page') == 'page-about-us') { ?>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/css/bootstrap.min.css" SameSite=None>
      <link rel="stylesheet" type="text/css" href="assets/vendors/summernote2/dist/summernote-bs4.css">
    <?php } ?>

    <link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="assets/css/dashboard.css" rel="stylesheet">
  <?php } ?>

  <!--respons-->
  <script src="assets/js/respond.min.js"></script>
  <link rel="stylesheet" href="assets/css/sweetaleart2.min.css">
  <script src="assets/js/sweetalert2.all.min.js"></script>
  <script src="assets/js/myalerts.js"></script>

  <!-- Custom styles for this template -->
</head>

<body>