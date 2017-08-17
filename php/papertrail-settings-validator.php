<?php
namespace PapertrailForWP;
class PapertrailSettingsValidator{
  private $errors = [];
  public static $Fields = [
              "host" => [
                "Id" => "host",
                "Name" => "Host",                  
                "Validators" => ["NotEmpty"],
              ],
              "port" => [
                "Id" => "port",
                "Name" => "Port",                  
                "Validators" => ["NotEmpty"],
              ],
              "system" => [
                "Id" => "system",
                "Name" => "System",                  
                "Validators" => ["NotEmpty"],
              ],
              "program" => [
                "Id" => "program",
                "Name" => "Program",                  
                "Validators" => ["NotEmpty"],
              ],
              "protocol" => [
                "Id" => "protocol",
                "Name" => "Connection protocol",                  
                "Validators" => ["NotEmpty"],
              ]
            ];

  public function __construct($settings){
    $this->settings = $settings;
  }

  public function is_valid(){
    $this->validate();
    return \count($this->errors) == 0;
  }

  public function validate(){
    foreach (PapertrailSettingsValidator::$Fields as &$field) {
      $this->validate_field($field);
    }
    return $this->errors;
  }

  private function validate_field($field){
    foreach ($field["Validators"]  as &$validatorName) {
      $this->validate_field_by_validator_name($field, $validatorName);
    }
  }

  private function validate_field_by_validator_name($field, $validatorName){
    $validatorFunction = "isValid".$validatorName;
    if(!$this->$validatorFunction($this->getValue($field["Id"]))){
      array_push($this->errors, ["field"=>$field,
        "error"=>$validatorName
      ]);
    }
  }

  private function isValidNotEmpty($value){
    return isset($value) && !empty($value);
  }

  private function getValue($fieldId){
    if(array_key_exists($fieldId, $this->settings))
    {
      return $this->settings[$fieldId];      
    }
    return null;
  }
}