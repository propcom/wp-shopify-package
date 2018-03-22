<?

namespace SA;

/**
 * Class - Defines filters for collections
 *
 * @author Joshua Grierson
 * @package SA
*/

class Filters
{

  /**
  * @var payload
  */
  private $payload;

  /**
  * @var options
  */
  private $options;

  /**
  * @var filters
  */
  private $filters;

  public function __construct (\SAProductArray $products)
  {
    $this->payload = $products;

    foreach($this->payload->get_products() as $product)
    {
      foreach($product->get_options() as $option)
      {
        if($option->name === 'Title') continue;

        $this->options[$option->name] = $option;
      }
    }

    var_dump($this->options);
  }

  /**
  * Gets array of variants in collection
  */
  public function get_variants ()
  {
  }
}

?>
