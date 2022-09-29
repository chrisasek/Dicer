<?php
class Redirect
{
	public static function to($location = null)
	{
		if ($location) {
			if (is_numeric($location)) {
				switch ($location) {
					case 404:
						header('HTTP/1.0 404 Not Found');
						include('includes/errors/404.php');
						exit();
						break;
				}
			}
			header('Location: ' . $location);
			exit();
		}
	}

	public static function not($data, $location = null, $js = true)
	{
		if (!$data) {
			if (is_numeric($location)) {
				switch ($location) {
					case 404:
						header('HTTP/1.0 404 Not Found');
						include('includes/errors/404.php');
						exit();
						break;
				}
			}

			if ($js) {
				echo "<script>window.location.replace('{$location}');</script>";
				exit();
			}
			header('Location: ' . $location);
			exit();
		}
	}

	public static function to_js($location = null)
	{
		if ($location) {
			if (is_numeric($location)) {
				switch ($location) {
					case 404:
						header('HTTP/1.0 404 Not Found');
						include('includes/errors/404.php');
						exit();
						break;
				}
			}
			echo "<script>window.location.replace('{$location}');</script>";
			exit();
		}
	}
}
