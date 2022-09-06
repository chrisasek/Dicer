 <!-- Add Message communication point by modal-->
 <div class="modal fade" id="mp_modal" tabindex="-1" role="dialog" aria-labelledby="messagePoint" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
     <div class="modal-content gbg rounded-0">
       <div class="modal-header bg-success py-2 rounded-0">
         <h5 class="modal-title text-light" id="message_modal_title">Thank You</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
       <div class="modal-body">
       </div>
       <div class="modal-footer py-2 mt-4">
         <span id='ms_action_point' class="mr-auto"></span>
         <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
       </div>
     </div>
   </div>
 </div>

 <script src="includes/js/jquery-3.3.1.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/js/bootstrap.bundle.min.js" SameSite=None></script>
 <script src="includes/js/jquery.validate.min.js"></script>
 <?php if ($user->isLoggedIn()) { ?>
   <script src="includes/vendors/datatables/jquery.dataTables.min.js"></script>
   <script src="includes/vendors/datatables/dataTables.bootstrap4.min.js"></script>
   <script src="includes/js/demo/moment.js"></script>
   <script src="includes/js/demo/datetime-moment.js"></script>
   <script src="includes/js/demo/datatables.js"></script>

   <script src="includes/vendors/summernote2/dist/summernote-bs4.min.js"></script>
   <script src="includes/js/oniontabs-editor.js"></script>
   <script src="includes/vendors/slugit/jquery.slugit.min.js"></script>
   <script src="includes/js/dashboard.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js" SameSite="None"></script>
    <script>bsCustomFileInput.init()</script>
 <?php } ?>

 <?php if (!Input::get('page') || Input::get('page') == 'home' || Input::get('page') == 'about-us' ||Input::get('page') == 'our-programs') { ?>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js" SameSite=None></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" SameSite=None></script>
 <?php } ?>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight-min.js"></script>
 <script src="includes/js/site.js"></script>


 </body>

 </html>