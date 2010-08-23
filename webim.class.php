<?php

/**
 * WebIM PHP Lib
 *
 * Author: Hidden <zzdhidden@gmail.com>
 * Date: Mon Aug 23 15:15:41 CST 2010
 *
 *
 * @TODO: offline, presence, message, status, members, join, leave
 */

require_once('util.php');
require_once('http_client.php');

class WebIM
{
	/**
	 *
	 * @param object $user
	 * 	-id:
	 * 	-nick:
	 * 	-show:
	 * 	-status:
	 *
	 * @return
	 *
	 */
	var $user;
	var $domain;
	var $apikey;
	var $host;
	var $port;
	var $client;

	/**
	 * New
	 *
	 * @param object $user
	 * 	-id:
	 * 	-nick:
	 * 	-show:
	 *
	 * @param string $domain
	 * @param string $apikey
	 * @param string $host
	 * @param string $port
	 *
	 */

	function WebIM($user, $domain, $apikey, $host, $port = 8000){
		$this->user = $user;
		$this->domain = $domain;
		$this->apikey = $apikey;
		$this->host = $host;
		$this->port = $port;
		$this->client = new HttpClient($this->host, $this->port);
	}

	/**
	 * User online
	 *
	 * @param string $buddy_ids
	 * @param string $room_ids
	 *
	 * @return array
	 * 	-success: true
	 * 	-ticket:
	 * 	-buddies: [&buddyInfo]
	 * 	-rooms: [&roomInfo]
	 * 	-error_msg:
	 *
	 */
	function online($buddy_ids, $room_ids){
		$data = array(
			'rooms'=> $room_ids, 
			'buddies'=> $buddy_ids, 
			'domain' => $this->domain, 
			'apikey' => $this->apikey, 
			'name'=> $this->user['id'], 
			'nick'=> $this->user['nick'], 
			'show' => $this->user['show']
		);
		$this->client->post('/presences/online', unicode_val($data));
		$cont = $this->client->getContent();
		$da = json_decode($cont);
		if($this->client->status != "200" || empty($da->ticket)){
			return array("success" => false, "error_msg" => $cont);
		}else{
			$buddies = array();
			foreach($da->buddies as $id => $show){
				$buddies[] = array("id" => $id, "nick" => $id, "show" => $show);
			}
			$rooms = array();
			foreach($da->roominfo as $id => $count){
				$rooms[] = array("id" => $id, "nick" => $id, "count" => $count);
			}
			return array("success" => true, "ticket" => $da->ticket, "buddies" => $buddies, "rooms" => $rooms);
		}
	}

	/**
	 * Check if can connect im server or not.
	 *
	 * @return array
	 * 	-success: true
	 * 	-error_msg:
	 *
	 */

	function check_connect(){
		$data = array(
			'rooms'=> "", 
			'buddies'=> "", 
			'domain' => $this->domain, 
			'apikey' => $this->apikey, 
			'name'=> $this->user['id'], 
			'nick'=> $this->user['nick'], 
			'show' => $this->user['show']
		);
		$this->client->post('/presences/online', unicode_val($data));
		$cont = $this->client->getContent();
		$da = json_decode($cont);
		if($this->client->status != "200" || empty($da->ticket)){
			return array("success" => false, "error_msg" => $cont);
		}else{
			return array("success" => true, "ticket" => $da->ticket);
		}
	}
}

?>
