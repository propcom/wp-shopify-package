<?

namespace SA;

/**
 * Class - Shopify product array
 *
 * @author Joshua Grierson
 * @package SA
*/

class SAProductArray
{

  /**
  * @var payload
  */
  private $payload;

  /**
  * @var products
  */
  private $products;

  private function __construct ($payload)
  {
    $this->payload = $payload;
    $this->products = null;

    if(!isset($payload['error']))
    {
      $this->products = $payload['data']->products;
    }
  }

  /**
  * Gets array of products
  *
  * @return Array
  */
  public function get_products ()
  {
    $array = [];

    if(empty($this->products))
    {
      return null;
    }

    foreach($this->products as $product)
    {
      $object = new stdClass();
      $object->product = $product;

      $array[] = Product::forge(['data' => $object]);
    }

    return $array;
  }

  /**
  * Filters products based of property and its value
  *
  * @param value
  * @param property
  *
  * @return Array
  */
  public function filter_products ($value, $property = 'id')
  {
    $array = [];

    if(empty($this->products))
    {
      return null;
    }

    foreach($this->products as $product)
    {
      $vars = get_object_vars($product);

      if($vars[$property] == $value)
      {
        $array[] = $product;
      }
    }

    return $array;
  }

  /**
  * Returns static instance
  *
  * @param payload
  *
  * @return Class
  */
  public static function forge ($payload)
  {
    return new static($payload);
  }
}

?>
