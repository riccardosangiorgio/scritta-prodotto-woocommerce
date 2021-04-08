<?php
function pa_colore_scritta_taxonomy_custom_fields($tag)
{
    // Check for existing taxonomy meta for the term you're editing  
    $t_id = $tag->term_id; // Get the ID of the term you're editing  
    $term_meta = get_option("taxonomy_term_$t_id"); // Do the check  
?>

    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="color_code"><?php _e('Codice colore'); ?></label>
        </th>
        <td>
            <input type="text" name="term_meta[color_code]" id="term_meta[color_code]" size="25" style="width:60%;" value="<?php echo $term_meta['color_code'] ? $term_meta['color_code'] : ''; ?>"><br />
            <span class="description"><?php _e('Codice colore in formato esadecimale.'); ?></span>
        </td>
    </tr>

<?php
}


// A callback function to save our extra taxonomy field(s)  
function save_taxonomy_custom_fields($term_id)
{
    if (isset($_POST['term_meta'])) {
        $t_id = $term_id;
        $term_meta = get_option("taxonomy_term_$t_id");
        $cat_keys = array_keys($_POST['term_meta']);
        foreach ($cat_keys as $key) {
            if (isset($_POST['term_meta'][$key])) {
                $term_meta[$key] = $_POST['term_meta'][$key];
            }
        }
        //save the option array  
        update_option("taxonomy_term_$t_id", $term_meta);
    }
}


// Add the fields to the "pa_colore_scritta" taxonomy, using our callback function  
add_action('pa_colore_scritta_edit_form_fields', 'pa_colore_scritta_taxonomy_custom_fields', 10, 2);

// Save the changes made on the "pa_colore_scritta " taxonomy, using our callback function  
add_action('edited_pa_colore_scritta', 'save_taxonomy_custom_fields', 10, 2);
