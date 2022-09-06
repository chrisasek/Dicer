(function ($) {
	'use_strict';
	// Equal Height
	$(window).on('load', 'resize', function (event) {
		$('.match-height').matchHeight({
			byRow: true,
		});
	});

	// tool tips
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	})

	$messagePoint = $('#mp_modal');
	// Messages module
	var Messaging = {
		showMessage: function ($title, $msg, $function) {
			$messagePoint.find('#mp_modal').text($title);
			$messagePoint.find('.modal-body').text($msg);
			return $messagePoint.modal('show').on('hidden.bs.modal', $function).promise();
		}
	}

	function reload2home(time = 5000) {
		setTimeout(function () { // wait for 5 secs(2)
			location.reload(); // then reload the page.(3)
		}, time);
	}

	function processHttpRequests(url, data, re) {
		if (url && data) {
			return $.ajax({
				url: url,
				data: data,
				cache: false,
				type: 'post',
				dataType: re
			}).promise();
		}
	}

	// pay with paystack
	function payWithPayStack1(datapay) {
		switch (datapay.type) {
			case 'pay':
				var handler = PaystackPop.setup({
					key: 'pk_test_769cf3bbc6f51fadd8edbe9f295a852c3e66c109', // test
					email: datapay.email, // the customer email
					amount: parseFloat(datapay.price) * 100,
					ref: datapay.ref, // unique reference use hash uniquw
					metadata: {
						custom_fields: [
							{
								display_name: "Mobile Number", // customer name
								variable_name: "mobile_number", // 
								value: datapay.phone // phone
							}
						]
					},
					callback: function (response) {
						// response object is returned!
						//console.log(response);
						var data = "req=" + datapay.req + "&ref=" + response.reference + "&data=" + JSON.stringify(datapay), url = 'controllers/verifytransactions.php';
						//console.log(data);
						processHttpRequests(url, data, 'html').then(function (results) {
							//console.log(results);
							if (typeof results === 'object') {
								var result = results;
							} else {
								var result = JSON.parse(results);
							}
							if (typeof result.success == 'boolean' && result.success) {
								console.log(result.message);
								Messaging.showMessage('Payment successful', result.message, function (e) {
									if (e.type == 'hidden') {
										window.location.reload(true);
									}
								});

							} else {
								console.log(results);
								if (typeof result == 'object') {
									var $obj_str = '';
									for (var i in result) {
										$obj_str += result[i] + ', ';
									}

									Messaging.showMessage('Errors', $obj_str, function (e) {
										if (e.type == 'hidden') {
											$this.text($previousText);
										}
									});
								}
							}
						});
					},
					onClose: function () {
						//alert('');
						Messaging.showMessage('Window Closed', 'Don\'t worry. We trust you can do all things later. Thank you for attempting to subscribe to a package', function (e) {
							if (e.type == 'hidden') {
								//$('#pnow').text('Order Now');
							}
						});
					}
				});
				break;

		}
		handler.openIframe();
	}

	// Validate inputs
	$('form').validate({
		// Check focus
		onfocusout: function (element) {
			//console.log(this.element(element));
			!this.element(element) || !$(element).val() || $(element).val() == 'default' ? $(element).addClass('red-border') : $(element).addClass('input-no-error');

		},
		// Set rules
		rules: {
			first_name: required = true,
			last_name: required = true,
			agree: required = true,
			dayof: required = true,
			timeofday: required = true,
			accname: required = true,
			bankname: required = true,
			amount: {
				required: true,
				number: true,
				min: 1000
			},
			address: {
				required: true,
				maxlength: 250
			},
			username: {
				required: true,
				maxlength: 50,
				minlength: 4
			},
			fullname: {
				required: true,
				minlength: 4,
				maxlength: 100,
				wordCount: ['2']
			},
			phone: {
				required: true,
				minlength: 11,
				maxlength: 14,
				number: true
			},
			password: {
				required: true,
				minlength: 6
			},
			password_again: {
				required: true,
				minlength: 6,
				equalTo: "#password"
			},
			email: {
				required: true,
				email: true
			},
			tandc: {
				required: true
			}
		},
		// Message for the rules
		messages: {
			first_name: "Please enter firstname",
			last_name: "please enter lastname",
			agree: "Please agree to this",
			dayof: "Must not be empty",
			timeofday: "Must not be empty",
			accname: "This is highly required",
			bankname: "This is highly required",
			username: {
				required: "Enter a username",
				maxlength: "Must not be longer than 100 characters",
				minlength: "Must consists of at least 4 characters"

			},
			address: {
				required: "Please provide your address",
				maxlength: "Address must not be longer than 250 characters."
			},
			fullname: {
				required: "Enter your full name starting with surname",
				minlength: "Must consists of al least 4 characters",
				maxlength: "Must not be longer than 100 characters",
				wordCount: 'Minimum of two words required'

			},
			phonenumber: {
				required: "Enter a phone number",
				minlength: 'This must be a valid phone number!',
				maxlength: "Must not be more than 14 digits",
				number: "Must not be a valid phone number"

			},
			password: {
				required: "Please provide password",
				minlength: "Password must be atleast 6 characters"
			},
			password_again: {
				required: "Confirm password is required",
				minlength: "confirm password must be atleast 6 characters",
				equalTo: "Please password must match"
			},
			tandc: {
				required: "Please accept our terms and conditions"
			},
			amount: {
				required: "Please this is required and must be filled out",
				number: "This field accepts only positive numbers",
				min: "Minimium Amount is 1000"
			}
		}

	});

	$('#toggler').on('click', function (e) {
		e.preventDefault();
		if ($('#' + $(this).data('toggle')).is(':visible')) {
			$('#' + $(this).data('toggle')).removeClass('d-block').addClass('d-none');
		} else {
			$('#' + $(this).data('toggle')).removeClass('d-none').addClass('d-block');
		}
	});
	
	$('.focus-area-s').on('click', function (e) {
		e.preventDefault();
		console.log($(this).find('.focus-area-desc'));
		$(this).find('.focus-area-desc').toggleClass('d-none');
	});

	// Slideshow
	$("#oniontabs-slideshow").owlCarousel({
		dots: true,
		lazyLoad: true,
		loop: true,
		center: true,
		autoplay: true,
		autoplayTimeout: 6000,
		autoplayHoverPause: true,
		animateIn: 'fadeIn',
		animateOut: 'fadeOut',
		items: 1,
		itemsDesktop: false,
		itemsDesktopSmall: false,
		itemsTablet: false,
		itemsMobile: false
	});

	// testimonial
	$("#partners-slideshow").owlCarousel({
		dots: false,
		lazyLoad: true,
		loop: true,
		center: true,
		autoplay: true,
		autoplayTimeout: 5000,
		autoplayHoverPause: true,
		responsive: {
			0: {
				items: 2,
				loop: true,
			},
			600: {
				items: 3,
				loop: true,
			},
			1000: {
				items: 5,
				loop: true,
			}
		}
	});

})(jQuery);