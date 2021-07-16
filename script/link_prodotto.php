  <?php
	add_shortcode('link_prodotto', function ($atts) {
		$a = shortcode_atts(array(
			'nome_prodotto' => 'nome_prodotto',
		), $atts);
		return get_site_url() . "\/prodotto/" . $a['nome_prodotto']  . "/?number=" . $_GET['number'];
	});



	function change_number_param_url()
	{

		if (isset($_SERVER['REQUEST_METHOD'])) {

			$method = $_SERVER['REQUEST_METHOD'];

			// GET requests
			if (strtoupper($method) === 'GET') {

				if (isset($_GET) && isset($_GET['number'])) {

					$_GET['number'] = str_pad($_GET['number'], 5, "0", STR_PAD_LEFT);

	?>
  				<script>
  					let queryParams = new URLSearchParams(window.location.search);
  					let param = "<?php echo $_GET['number']; ?>"

  					// Set new or modify existing parameter value. 
  					// queryParams.set("number", param.padStart(5, '0'));
  					queryParams.set("number", param);

  					// Replace current querystring with the new one.
  					history.replaceState(null, null, "?" + queryParams.toString());
  				</script>
  <?php

					return;
				}
			}
		}
	}

	add_action('parse_request', 'change_number_param_url', 1);
