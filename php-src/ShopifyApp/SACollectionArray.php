<?

namespace SA;

/**
 * Class - Shopify collection array object
 *
 * @author Joshua Grierson
 * @package SA
*/

class Collection_Array
{

  /**
  * @var payload
  */
  private $payload;

  /**
  * @var collections
  */
  private $collections;

  private function __construct ($payload)
  {
    $this->payload = $payload;
    $this->collections = null;

    if(!isset($payload['error']))
    {
      if(isset($payload['data']->custom_collections))
      {
        $this->collections = $payload['data']->custom_collections;
      }
      else
      {
        $this->collections = $payload['data']->smart_collections;
      }
    }
  }

  /**
  * Gets collection array of type SACollection
  *
  * @return Array
  */
  public function get_collections ()
  {
    $array = [];

    if(empty($this->collections))
    {
      return null;
    }

    foreach($this->collections as $collection)
    {
      $object = new stdClass();
      $object->custom_collection = $collection;

      $array[] = \SACollection::forge(['data' => $object]);
    }

    return $array;
  }

  /**
  * Filters array of collections based of property and its value
  *
  * @param value
  * @param property
  *
  * @return Array
  */
  public function filter_collections ($value, $property = 'id')
  {
    $array = [];

    if(empty($this->collections))
    {
      return null;
    }

    foreach($this->collections as $collection)
    {
      $vars = get_object_vars($collection);

      if($vars[$property] == $value)
      {
        $array[] = $collection;
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
