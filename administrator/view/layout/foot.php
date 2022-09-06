<script src="includes/js/jquery-3.3.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
<script src="includes/js/jquery.validate.min.js"></script>

<?php if ($user->isLoggedIn()) { ?>
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

  <script src="includes/js/demo/moment.js"></script>
  <script src="includes/js/demo/datetime-moment.js"></script>
  <script src="includes/js/demo/datatables.js"></script>

  <?php if (Input::get('page') && (Input::get('page') == 'blogs' && Input::get('action')) || Input::get('page') == 'page-about-us') { ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/js/bootstrap.bundle.min.js" SameSite=None></script>
    <script src="includes/vendors/summernote2/dist/summernote-bs4.min.js"></script>
  <?php } ?>
  <script src="includes/js/oniontabs-editor.js"></script>
  <script src="includes/vendors/slugit/jquery.slugit.min.js"></script>
  <script src="includes/js/dashboard.js"></script>
  <script>
    bsCustomFileInput.init()
  </script>
  <script src="dashboard.js"></script>
<?php } ?>

</body>

</html>