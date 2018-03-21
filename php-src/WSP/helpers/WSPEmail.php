<?php

namespace WSP\Helpers;

/**
 * Class - Email helper to send emails to customer
 *
 * @author Joshua Grierson
 * @package WSP\Helpers
*/

class Email_Helper
{

  /**
  * @var email
  */
  private $email;

  /**
  * @var mailer
  */
  private $mailer;

  /**
  * @var logged_in
  */
  private $logged_in;

  /**
  * @var email_temp
  */
  private $email_temp = 'abandoned-checkout.php';

  /**
  * @var user_meta_key
  */
  private $user_meta_key = '_ws_user_meta';

  public function __construct ( $logged_in, $email )
  {
    $this->logged_in = $logged_in;
    $this->email = $email;
    $this->mailer = plugin_dir_path( dirname( __FILE__ ) ).'mailer/'.$this->email_temp;
  }

  /**
  * Sends email
  *
  * @param subject
  * @param contents
  *
  * @return Boolean
  */
  public function send_email ( $subject, $contents )
  {
    global $info, $image;

    $info = (object)$contents;
    $image = $this->image_uri( get_template_directory().'/assets/img/logo.png' );

    $email_obj = new stdClass();

    if( $this->email && $this->logged_in && file_exists( $this->mailer ) )
    {
      $email_obj->to = $this->email;
      $email_obj->subject = $subject;

      $email_obj->body = $this->get_email_contents( $this->mailer );

      $email_obj->headers = [

        'Content-Type: text/html; charset=UTF-8',
        'From: '.get_option( 'prop_site' )['email']

      ];

      return wp_mail( $email_obj->to, $email_obj->subject, $email_obj->body, $email_obj->headers );
    }

    return false;
  }

  /**
  * Sets user status in meta
  *
  * @param status
  * @param unique_key
  *
  * @return Boolean
  */
  public function set_status ( $status = true, $unique_key = 0 )
  {
    $args = [

      'search' => $this->email,
      'search_columns' => [ 'user_email' ]

    ];

    $user = new WP_User_Query( $args );

    if( !empty($user->results) )
    {
      $added = add_user_meta( $user->results[0]->ID, $this->user_meta_key.'_'.$unique_key, $status );

      if($added)
      {
        return true;
      }
    }

    return false;
  }

  /**
  * Gets user status from meta
  *
  * @param unique_key
  *
  * @return Boolean
  */
  public function get_status ( $unique_key = 0 )
  {
    $args = [

      'search' => $this->email,
      'search_columns' => [ 'user_email' ]

    ];

    $user = new WP_User_Query( $args );

    if( !empty($user->results) )
    {
      return get_user_meta( $user->results[0]->ID, $this->user_meta_key.'_'.$unique_key );
    }

    return false;
  }

  /**
  * Gets email contents from template file
  *
  * @param temp
  *
  * @return String
  */
  public function get_email_contents ($temp)
  {
    if( is_file($temp) )
    {
      ob_start();
      include_once $temp;
      return ob_get_clean();
    }

    return null;
  }

  /**
  * Get image uri
  *
  * @param path
  *
  * @return String
  */
  public function image_uri ($path)
  {
    if( ($type = pathinfo($path, PATHINFO_EXTENSION)) )
    {
      $data = file_get_contents($path);

      return 'data:image/'.$type.';base64,'.base64_encode($data);
    }
  }
}

?>
