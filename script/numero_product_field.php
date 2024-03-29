<?php

/**
 * Inserisci una textfield contente il numero passato com parametro GET
 * prima del box "variations" di WooCommerce.
 */
function add_numero_field()
{
    echo '<table class="variations" cellspacing="0" style="margin-bottom: 10px;">
          <tbody>
              <tr>
              <td class="label"><label for="numero">Numero</label></td>
              <td class="value">
                  <input type="number" name="numero" value="' . $_GET['number'] . '" style="width: 100%;" readonly/>
				  <a href="#" style="visibility: hidden;">Space</a>
              </td>
          </tr>                               
          </tbody>
      </table>';
}
add_action('woocommerce_before_variations_form', 'add_numero_field');

/**
 * Forza l'inserimento di un numero
 */
function numero_validation()
{
    if (empty($_REQUEST['numero'])) {
        wc_add_notice(__('Inserire un numero.', 'woocommerce'), 'error');
        return false;
    }
    return true;
}
add_action('woocommerce_add_to_cart_validation', 'numero_validation', 10, 3);

/**
 * Salva i dati (custom fields) quando il prodotto viene aggiunto al carrello.
 * Ogni configurazione e' univoca grazie a unique_key.
 */
function save_numero_field($cart_item_data, $product_id)
{
    if (isset($_REQUEST['numero'])) {
        $cart_item_data['numero'] = $_REQUEST['numero'];
        /* below statement make sure every add to cart action as unique line item */
        $cart_item_data['unique_key'] = md5(microtime() . rand());
    }
    return $cart_item_data;
}
add_action('woocommerce_add_cart_item_data', 'save_numero_field', 10, 2);

/**
 * Viene visualizzato il numero (custom fields) nel riepilogo dell'ordine.
 */
function render_meta_on_cart_and_checkout($cart_data, $cart_item = null)
{
    $custom_items = array();
    /* Woo 2.4.2 updates */
    if (!empty($cart_data)) {
        $custom_items = $cart_data;
    }
    if (isset($cart_item['numero'])) {
        $custom_items[] = array("name" => 'Numero', "value" => $cart_item['numero']);
    }
    return $custom_items;
}
add_filter('woocommerce_get_item_data', 'render_meta_on_cart_and_checkout', 10, 2);

function tshirt_order_meta_handler($item_id, $values, $cart_item_key)
{
    if (isset($values['numero'])) {
        wc_add_order_item_meta($item_id, "numero", $values['numero']);
    }
}
add_action('woocommerce_add_order_item_meta', 'tshirt_order_meta_handler', 1, 3);

/**
 * Modifica il link dei prodotti aggiunti al carrelo, 
 * inserendo il parametro number alla fine dell'URL.
 */
function filter_woocommerce_cart_item_permalink($product_get_permalink_cart_item, $cart_item, $cart_item_key)
{
    return $product_get_permalink_cart_item . "&number=" . $cart_item['numero'];
};
add_filter('woocommerce_cart_item_permalink', 'filter_woocommerce_cart_item_permalink', 10, 3);
