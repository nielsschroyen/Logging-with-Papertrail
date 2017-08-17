<?php
namespace PapertrailForWP;
class Papertrail_Sender {
	public function send_remote_syslog( $message, $system, $program, $papertrailUrl, $papertrailPort) {
		try {
			$client = stream_socket_client("tcp://$papertrailUrl:$papertrailPort",$errno, $errstr);			
			foreach(explode("\n", $message) as $line) {
				  $syslog_message = "<22>" . date('M d H:i:s ') . $system . " " . $program . ": " .  $line ."\n";
				  fwrite($client,$syslog_message);	
			}
			fclose($client);	
		} catch (\Exception $e) {
			//Ignore exception for now
		}
	}
}