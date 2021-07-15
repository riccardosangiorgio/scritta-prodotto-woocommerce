<?php
add_shortcode('link_prodotto', function ($atts) {
	$a = shortcode_atts(array(
		'nome_prodotto' => 'nome_prodotto',
	), $atts);
	return get_site_url() . "\/prodotto/" . $a['nome_prodotto']  . "/?number=" . str_pad($_GET['number'], 5, "0", STR_PAD_LEFT);
});
