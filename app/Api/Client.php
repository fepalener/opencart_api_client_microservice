<?php

namespace App\Api;

use App\Api\Http\Headers;
use App\Api\Http\Response;
use App\Api\Http\RequestInterface;

class Client
{
    const VERSION = '1.0.0';

    /**
     * @var string
     */
    public $version = self::VERSION;
    
    /**
     * @var string
     */
    protected $apiUrl;

    /**
     * @var Collection
     */
    protected $headers;

    /**
     * Constructor
     * 
     * @param string $apiUrl
     * @param string $apiKey
     */
    public function __construct($apiUrl, $apiKey)
    {
        $this->apiUrl = rtrim($apiUrl, '/');
        
        $this->headers = new Headers([
            'Authorization'  => $apiKey,
            'User-Agent'     => 'api_client;php',
            'Content-Type'   => 'application/json; charset=utf-8',
            'Accept'         => 'application/json',
            'Accept-Version' => $this->version
        ]);
    }

    /**
     * Make API request call
     *
     * @param RequestInterface $request
     * @return Response
     *
     * @throws Exception\HttpConnectionErrorException
     * @throws Exception\UnknownErrorException
     * @throws Exception\InvalidResponseTypeException
     */
    public function makeRequest(RequestInterface $request)
    {
        $curl = curl_init($this->apiUrl . '/' . $request->getPath());
        
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 1,
            CURLOPT_CUSTOMREQUEST  => strtoupper($request->getMethod()),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_TIMEOUT        => 5
        ]);

        $headers = new Headers(
            array_merge($this->headers->getAll(), $request->getHeaders()->getAll())
        );

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers->getFormatedArray());

        if ($request->hasBody()) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $request->getBody());
        }
        
        $response = curl_exec($curl);

        if ($response === false) {
            switch (true) {
                case (in_array(curl_errno($curl), [6, 7, 28])):
                    throw new Exception\HttpConnectionErrorException;
                default:
                    throw new Exception\UnknownErrorException(
                        sprintf('cURL Error: %s ,code: %s', curl_error($curl), curl_errno($curl))
                    );
            }
        }

        $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        $responseBody    = substr($response, $headerSize);
        $responseHeaders = substr($response, 0, $headerSize);

        curl_close($curl);

        $responseHeaders = $this->getHeadersFromCurlResponse($responseHeaders);

        if (!preg_match('/application\/json/i', $responseHeaders->get('Content-Type'))) {
            throw new Exception\InvalidResponseTypeException;
        }

        return new Response($statusCode, $responseBody, $responseHeaders);
    }

    /**
     * @param array $responseHeders
     * @return Headers
     */
    protected function getHeadersFromCurlResponse($responseHeders)
    {
        $headers = [];

        // Split the string on every "double" new line.
        $arrRequests = explode("\r\n\r\n", $responseHeders);

        for ($index = 0; $index < count($arrRequests[0]); $index++) {
            foreach (explode("\r\n", $arrRequests[$index]) as $i => $line) {
                if ($i === 0) {
                    $headers['http_code'] = $line;
                } else {
                    list ($key, $value) = explode(': ', $line);
                    $headers[$key] = $value;
                }
            }
        }

        return new Headers($headers);
    }
}