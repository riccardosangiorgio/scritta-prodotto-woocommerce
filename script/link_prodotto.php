<?php
add_shortcode( 'link_prodotto', function ($atts) {
	 $a = shortcode_atts( array(
 		'nome_prodotto' => 'nome_prodotto',
 	), $atts );
	return "https://uebsi.it/fivezero/prodotto/" . $a['nome_prodotto']  ."/?number=" . $_GET['number'];
} );