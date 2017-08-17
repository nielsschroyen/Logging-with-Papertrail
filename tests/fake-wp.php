  <?php
  class FakeWP{
    public static $options;

    public static function setDefaults(){
        FakeWP::$options =   [
                              "host" => "host",
                              "port" => "port",
                              "system" => "system",
                              "program" => "program"
                            ];
    }
  }

function get_option() {
  return FakeWP::$options;
}

function esc_attr($attr){
  return $attr;
}