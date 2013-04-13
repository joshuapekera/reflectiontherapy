<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	require_once 'aws.php';
	
	/**
	 * Create S3
	 * Creates an Amazon S3 object.
	 **/
	function create_s3($accessKey, $secretKey)
	{
		return new S3($accessKey, $secretKey);
	}