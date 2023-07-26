<?php
namespace rhinos\PhpFirebaseCloudMessaging;

use rhinos\PhpFirebaseCloudMessaging\Recipient\Recipient;

/**
 * @author rhinos
 */
class Message
{
	private $recipient = null;
	/*
	 * private $message = [
		'notification' => [
			'title' => 'Notification title',
			'body' => 'Notification body',
		],
		'android' => [
			'ttl' => '3600s',
			'priority' => 'normal',
			'notification' => [
				'title' => 'Notification title',
				'body' => 'Notification body'
			],
		],
		'apns' => [
			'headers' => [
				'apns-priority' => '10',
			],
			'payload' => [
				'aps' => [
					'alert' => [
						'title' => 'Notification title',
						'body' => 'Notification body',
					],
				],
			],
		],
		'webpush' => [
			'notification' => [
				'title' => 'Notification title',
				'body' => 'Notification body',
			],
		],
	];
	 */
	private $message = [
		'message' => []
	];


	public function __construct() {
	}

	/**
	 * where should the message go
	 *
	 * @param Recipient $recipient
	 *
	 * @return \rhinos\PhpFirebaseCloudMessaging\Message
	 */
	public function addRecipient(Recipient $recipient)
	{
		$this->recipient = $recipient->getToken();
		return $this;
	}

	public function getRecipient()
	{
		return $this->recipient;
	}

	/**
	 * @param Message $message
	 * @return $this
	 */
	public function setMessage(Message $message)
	{
		$this->message = $message;

		return $this;
	}

	public function getMessage()
	{
		return $this->message;
	}


	public function setNotification($title, $body)
	{
		$this->message['message'] = array (
			'notification' => [
				'title' => $title,
				'body' => $body,
			]
		);

		return $this;
	}


	public function setAndroidNotification($title, $body, $priority = 'normal')
	{
		if (!in_array($priority, array('normal', 'hight')))
			throw new \InvalidArgumentException('Message priority. Can take "normal" and "high" values.');

		$this->message['message'] = array (
			'android' => [
				'ttl' => '3600s',
				'priority' => $priority,
				'notification' => [
					'title' => $title,
					'body' => $body
				],
			]
		);

		return $this;
	}


	public function setApnsNotification($title, $body, $badge = 0)
	{
		$this->message['message'] = array (
			'apns' => [
				'headers' => [
					'apns-priority' => '10',
				],
				'payload' => [
					'aps' => [
						'alert' => [
							'title' => $title,
							'body' => $body,
						],
					],
				],
			]
		);

		if ($badge > 0)
			$this->message['message']['apns']['payload']['aps'] = array ('badge' => $badge);

		return $this;
	}


	public function setWebNotification($title, $body, $icon = false)
	{
		$this->message['message'] = array (
			'webpush' => [
				'notification' => [
					'title' => $title,
					'body' => $body,
				],
			]
		);

		if ($icon)
			$this->message['message']['webpush']['notification'] = array ('icon' => $icon);

		return $this;
	}



	/**
	 * @param $color String hexadecimal code
	 * @return $this
	 */
	public function setAndroidColor($color)
	{
		$this->message = array_merge($this->message, array (
				'message' => array(
					'android' => array (
						'notification' => array(
							'color' => $color
						)
					)
				)
			)
		);

		return $this;
	}

	public function setAndroidIcon($icon)
	{
		$this->message = array_merge($this->message, array (
				'message' => array(
					'android' => array (
						'notification' => array(
							'icon' => $icon
						)
					)
				)
			)
		);

		return $this;
	}


	/**
	 * @param $key
	 * @param $value
	 * @return $this
	 */
	public function setData($key, $value)
	{
		if (!isset($this->message['message']['data']))
			$this->message['message']['data'] = array();

		$this->message['message']['data'][$key] = $value;

		return $this;
	}
}