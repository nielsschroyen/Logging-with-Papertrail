  <?php
  class FakeWP{
    public static $options;

    public static function setDefaults(){
        FakeWP::$options =   [
                              "host" => "host",
                              "port" => "port",
                              "system" => "system",
                              "program" => "program",
                              "protocol" => "udp"
                            ];
    }
  }

function get_option($option) {
  if($option == 'siteurl'){
    return "http://www.testwordpress.com";
  }

  return FakeWP::$options;
}

function esc_attr($attr){
  return $attr;
}

function get_bloginfo(){
  return "MyWordPress";
}