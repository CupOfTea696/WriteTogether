<?PHP

namespace Mailgun\Connection;

use Guzzle\Http\Client as Guzzle;
use Mailgun\MailgunClient;

use Mailgun\Connection\Exceptions\GenericHTTPError;
use Guzzle\Http\QueryAggregator\DuplicateAggregator;
use Guzzle\Http\QueryAggregator\PhpAggregator;
use Mailgun\Connection\Exceptions\InvalidCredentials;
use Mailgun\Connection\Exceptions\NoDomainsConfigured;
use Mailgun\Connection\Exceptions\MissingRequiredParameters;
use Mailgun\Connection\Exceptions\MissingEndpoint;

/**
 * This class is a wrapper for the Guzzle (HTTP Client Library).
 */
class RestClient {

    /**
     * @var string
     */
	private $apiKey;

    /**
     * @var Guzzle
     */
	protected $mgClient;

    /**
     * @var bool
     */
	protected $hasFiles = False;

    /**
     * @param string $apiKey
     * @param string $apiEndpoint
     * @param string $apiVersion
     * @param bool $ssl
     */
	public function __construct($apiKey, $apiEndpoint, $apiVersion, $ssl){
		$this->apiKey = $apiKey;
		$this->mgClient = new Guzzle($this->generateEndpoint($apiEndpoint, $apiVersion, $ssl));
		$this->mgClient->setDefaultOption('curl.options', array('CURLOPT_FORBID_REUSE' => true));
		$this->mgClient->setDefaultOption('auth', array (API_USER, $this->apiKey));
		$this->mgClient->setDefaultOption('exceptions', false);
		$this->mgClient->setUserAgent(SDK_USER_AGENT . '/' . SDK_VERSION);
	}

    /**
     * @param string $endpointUrl
     * @param array $postData
     * @param array $files
     * @return \stdClass
     * @throws GenericHTTPError
     * @throws InvalidCredentials
     * @throws MissingEndpoint
     * @throws MissingRequiredParameters
     */
	public function post($endpointUrl, $postData = array(), $files = array()){
		$request = $this->mgClient->post($endpointUrl, array(), $postData);

		if(isset($files["message"])){
			$this->hasFiles = True;
			foreach($files as $message){
				$request->addPostFile("message", $message);
			}
		}

		if(isset($files["attachment"])){
			$this->hasFiles = True;
			foreach($files["attachment"] as $attachment){
				// Backward compatibility code
				if (is_array($attachment)){
					$request->addPostFile("attachment",
										  $attachment['filePath'], null,
										  $attachment['remoteName']);
				}
				else{
					$request->addPostFile("attachment", $attachment);
				}
			}
		}

		if(isset($files["inline"])){
			$this->hasFiles = True;
			foreach($files["inline"] as $inline){
				// Backward compatibility code
				if (is_array($inline)){
					$request->addPostFile("inline",
										  $inline['filePath'], null,
										  $inline['remoteName']);
				}
				else{
					$request->addPostFile("inline", $inline);
				}
			}
		}

		/*
			This block of code is to accommodate for a bug in Guzzle.
			See https://github.com/guzzle/guzzle/issues/545.
			It can be removed when Guzzle resolves the issue.
		*/

		if($this->hasFiles){
			$request->getPostFields()->setAggregator(new PhpAggregator());
		}

		else{
			$request->getPostFields()->setAggregator(new DuplicateAggregator());
		}

		$response = $request->send();
		return $this->responseHandler($response);
	}

    /**
     * @param string $endpointUrl
     * @param array $queryString
     * @return \stdClass
     * @throws GenericHTTPError
     * @throws InvalidCredentials
     * @throws MissingEndpoint
     * @throws MissingRequiredParameters
     */
	public function get($endpointUrl, $queryString = array()){
		$request = $this->mgClient->get($endpointUrl);
		if(isset($queryString)){
			foreach($queryString as $key=>$value){
				$request->getQuery()->set($key, $value);
			}
		}
		$response = $request->send();
		return $this->responseHandler($response);
	}

    /**
     * @param string $endpointUrl
     * @return \stdClass
     * @throws GenericHTTPError
     * @throws InvalidCredentials
     * @throws MissingEndpoint
     * @throws MissingRequiredParameters
     */
	public function delete($endpointUrl){
		$reest = $this->mgClient->delete($endpointUrl);
		$response = $request->send();
		return $this->responseHandler($response);
	}

    /**
     * @param string $endpointUrl
     * @param array $putData
     * @return \stdClass
     * @throws GenericHTTPError
     * @throws InvalidCredentials
     * @throws MissingEndpoint
     * @throws MissingRequiredParameters
     */
	public function put($endpointUrl, $putData){
		$request = $this->mgClient->put($endpointUrl, array(), $putData);
		$request->getPostFields()->setAggregator(new DuplicateAggregator());
		$response = $request->send();
		return $this->responseHandler($response);
	}

    /**
     * @param \Guzzle\Http\Message\Response $responseObj
     * @return \stdClass
     * @throws GenericHTTPError
     * @throws InvalidCredentials
     * @throws MissingEndpoint
     * @throws MissingRequiredParameters
     */
	public function responseHandler($responseObj){
		$httpResponseCode = $responseObj->getStatusCode();
		if($httpResponseCode === 200){
			$data = (string) $responseObj->getBody();
			$jsonResponseData = json_decode($data, false);
			$result = new \stdClass();
			// return response data as json if possible, raw if not
			$result->http_response_body = $data && $jsonResponseData === null ? $data : $jsonResponseData;
		}
		elseif($httpResponseCode == 400){
			throw new MissingRequiredParameters(EXCEPTION_MISSING_REQUIRED_PARAMETERS . $this->getResponseExceptionMessage($responseObj));
		}
		elseif($httpResponseCode == 401){
			throw new InvalidCredentials(EXCEPTION_INVALID_CREDENTIALS);
		}
		elseif($httpResponseCode == 404){
			throw new MissingEndpoint(EXCEPTION_MISSING_ENDPOINT  . $this->getResponseExceptionMessage($responseObj));
		}
		else{
			throw new GenericHTTPError(EXCEPTION_GENERIC_HTTP_ERROR, $httpResponseCode, $responseObj->getBody());
		}
		$result->http_response_code = $httpResponseCode;
		return $result;
	}

    protected function getResponseExceptionMessage(\Guzzle\Http\Message\Response $responseObj){
        $body = (string)$responseObj->getBody();
        $response = json_decode($body);
        if (json_last_error() == JSON_ERROR_NONE && isset($response->message)) {
            return " " . $response->message;
        }
    }

    /**
     * @param string $apiEndpoint
     * @param string $apiVersion
     * @param bool $ssl
     * @return string
     */
	private function generateEndpoint($apiEndpoint, $apiVersion, $ssl){
		if(!$ssl){
			return "http://" . $apiEndpoint . "/" . $apiVersion . "/";
		}
		else{
			return "https://" . $apiEndpoint . "/" . $apiVersion . "/";
		}
	}
}