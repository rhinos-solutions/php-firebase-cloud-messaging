<?php
namespace rhinos\PhpFirebaseCloudMessaging;


/**
 *
 * @author rhinos
 *
 */
interface ClientInterface
{

	/**
	 * add your server service account file here
	 *
	 * @param string $path
	 *
	 * @return \rhinos\PhpFirebaseCloudMessaging\Client
	 */
	function setServiceAccount($path);

	/**
	 * add your Firebase Project ID here
	 *
	 * @param string $projectId
	 *
	 * @return \rhinos\PhpFirebaseCloudMessaging\Client
	 */
	function setProject($projectId);


	/**
	 * sends your notification to the google servers and returns a guzzle repsonse object
	 * containing their answer.
	 *
	 * @param Message $message
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 * @throws \GuzzleHttp\Exception\RequestException
	 */
	function send(Message $message);

}
