<?

namespace WSP\Helpers;

/**
 * Class - Custom shortcodes for pulling through products to Frontend
 *
 * @author Joshua Grierson
 * @package WSP\Helpers
*/

class WSPShortcodes
{

  /**
  * Renders single product
  *
  * @param props
  *
  * @return String
  */
  public static function code_product ( $props )
  {

    $prop = shortcode_atts ( ['id' => null], $props );
    ob_start();

    if( $prop['id'] )
    {
      $product = Wordpress_Shopify_Api::forge( ENDPOINT_PRODUCT.'/'.$prop['id'].'.json' )->product();

      if( $product )
      {
        ?>
          <div id="wp_shopify-shortcode-product-<?= $product->get_product()->id ?>" class="wp_shopify__product">

            <div class="wrap">

              <a href="https://<?= get_option( 'prop_shopify' )['shop'].'.myshopify.com/products/'.$product->get_product()->handle ?>">
                <h2 class="title"><?= $product->get_product()->title ?></h2>
                <img src="<?= $product->get_main_image()->src ?>" alt="Product <?= $product->get_product()->title ?>" />
              </a>

            </div>

          </div>
        <?
      }
      else
      {
        ?><p>Product not found.</p><?
      }
    }

    return ob_get_clean();
  }

  /**
  * Renders products within a collection
  *
  * @param props
  *
  * @return String
  */
  public static function code_products ( $props )
  {
    $prop = shortcode_atts ( ['id' => null], $props );
    ob_start();

    if( $prop['id'] )
    {
      $products = Wordpress_Shopify_Api::forge( ENDPOINT_PRODUCTS, [ 'collection_id' => $prop['id'] ] )->products()->get_products();

      if( $products )
      {
        ?><div id="wp_shopify-shortcode-collection-<?= $prop['id'] ?>" class="wp_shopify__products"><div class="wrap"><?

        foreach( $products as $product )
        {
          ?>
            <div id="wp_shopify-shortcode-product-<?= $product->get_product()->id ?>" class="product">

              <a href="https://<?= get_option( 'prop_shopify' )['shop'].'.myshopify.com/products/'.$product->get_product()->handle ?>">
                <h2 class="title"><?= $product->get_product()->title ?></h2>
                <img src="<?= $product->get_main_image()->src ?>" alt="Product <?= $product->get_product()->title ?>" />
              </a>

            </div>
          <?
        }

        ?></div></div><?
      }
      else
      {
        ?><p>Collection not found.</p><?
      }
    }

    return ob_get_clean();
  }

  /*
  * Add custom shortcodes below
  *
  * code_[shortcode] ( $props ) {
  *   ob_start();
  *   ?><div>Html rendering</div><?
  *   return ob_get_clean();
  * }
  */
}

/*
* Add the above functions to shortcodes
*/
$methods = get_class_methods( new \WSPShortcodes() );

if( !empty($methods) )
{
  foreach( $methods as $method )
  {
    $shortcode = explode('_', $method);

    if( $shortcode[0] == 'code' )
    {
      add_shortcode($shortcode[1], ['Shopify_Shortcodes', $method] );
    }
  }
}

?>
