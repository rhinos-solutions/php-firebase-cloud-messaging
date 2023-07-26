<?php
namespace rhinos\PhpFirebaseCloudMessaging;

/**
 * @author rhinos
 */
class Client implements ClientInterface
{
	const DEFAULT_API_URL = 'https://fcm.googleapis.com/v1/projects/';

	private $projectId;
	private $httpClient;

	function __construct()
	{
		$this->httpClient = new \Google_Client();
	}

	/**
	 * add your server service account file here
	 *
	 * @param string $path
	 *
	 * @return \rhinos\PhpFirebaseCloudMessaging\Client
	 * @throws \Exception
	 */
	public function setServiceAccount($path)
	{
		if (file_exists($path) and is_file($path))
		{
			$this->httpClient->setAuthConfig($path);
			$this->httpClient->addScope('https://www.googleapis.com/auth/firebase.messaging');

			$this->httpClient = $this->httpClient->authorize();
		}
		else
			throw new \InvalidArgumentException("Unable to read service Account json file");

		return $this;
	}

	/**
	 * add your Firebase Project ID here
	 *
	 * @param string $projectId
	 *
	 * @return \rhinos\PhpFirebaseCloudMessaging\Client
	 */
	function setProject($projectId)
	{
		$this->projectId = $projectId;
		return $this;
	}

	/**
	 * sends your notification to the google servers and returns a guzzle repsonse object
	 * containing their answer.
	 *
	 * @param Message $message
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 * @throws \GuzzleHttp\Exception\RequestException
	 */
	public function send(Message $message)
	{
		$payload = $message->getMessage();
		$payload['message']['token'] = $message->getRecipient();

		return $this->httpClient->post(
			$this->getApiUrl(),
			[
				'json' => $payload
			]
		);
	}

	/**
	 * @return string
	 */
	private function getApiUrl()
	{
		return self::DEFAULT_API_URL . $this->projectId. '/messages:send';
	}
}