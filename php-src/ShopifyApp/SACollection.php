<?

namespace SA;

/**
 * Class - Shopify collection object
 *
 * @author Joshua Grierson
 * @package SA
*/

class SACollection
{

  /**
  * @var payload
  */
  private $payload;

  /**
  * @var collection
  */
  private $collection;

  private function __construct ($payload)
  {
    $this->payload = $payload;
    $this->collection = null;

    if(!isset($payload['error']))
    {
      if(isset($payload['data']->custom_collection))
      {
        $this->collection = $payload['data']->custom_collection;
      }
      else
      {
        $this->collection = $payload['data']->smart_collection;
      }
    }
  }

  /**
  * Gets collection image
  *
  * @return String
  */
  public function get_image ()
  {
    if(!isset($this->collection->image))
    {
      return null;
    }

    return $this->collection->image->src;
  }

  /**
  * Get collection body html
  *
  * @return String
  */
  public function get_body ()
  {
    return $this->collection->body_html;
  }

  /**
  * Gets collection object
  *
  * @return Object
  */
  public function get_collection ()
  {
    return $this->collection;
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
