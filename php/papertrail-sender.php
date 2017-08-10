<?php

class Papertrail_Sender {
	  public static function send_remote_syslog( $message, $system, $program, $papertrailUrl, $papertrailPort) {
				$sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
				foreach(explode("\n", $message) as $line) {
						$syslog_message = "<22>" . date('M d H:i:s ') . $system . ' ' . $program . ': ' . $line;
						socket_sendto($sock, $syslog_message, strlen($syslog_message), 0, $papertrailUrl, $papertrailPort);
				}
				socket_close($sock);
    }
}