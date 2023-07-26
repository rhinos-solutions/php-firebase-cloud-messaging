<?php
namespace rhinos\PhpFirebaseCloudMessaging\Recipient;

class Recipient
{
	private $to;

	public function setTo($to)
	{
		$this->to = $to;
		return $this;
	}
}