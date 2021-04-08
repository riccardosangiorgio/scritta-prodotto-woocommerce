<?php
add_action( 'wp_footer', function () {

	$terms = get_terms("pa_colore_scritta", [
    'taxonomy' => $taxonomy,
    'hide_empty' => false,
	]);
	
	function get_custom_fields ($term) {
		return (object) array_merge((array) $term, (array) get_option( "taxonomy_term_" . $term->term_id));
	}
	
	$colors = array_map('get_custom_fields', $terms);

?>
<script>

	const colors = JSON.parse('<?php echo json_encode($colors) ?>');
	
 function setColor (value ) {
 	const scritta = document.querySelector('.rs-number');
	scritta.style.color = selectElement.value;
	 
	const colorCode = colors.find(el => el.slug === value).color_code
	 
	return scritta.style.color = colorCode
 }
 
const selectElement = document.querySelector('#pa_colore_scritta');

document.addEventListener("DOMContentLoaded", function() {
  	if (window.location.pathname.split("/")[2] !== "prodotto") return;
   	setColor(selectElement.value);
});

if (window.location.pathname.split("/")[2] === "prodotto") {
	selectElement.addEventListener('change', (event) => {
  		setColor(event.target.value);
	});
}

</script>
<?php } );
