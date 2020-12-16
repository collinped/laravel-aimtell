<?php


namespace Collinped\Aimtell;

use Exception;
use Collinped\Aimtell\Exception\AuthorizationException;
use Collinped\Aimtell\Exception\NetworkErrorException;
use Collinped\Aimtell\Exception\RequestException;
use Collinped\Aimtell\Exception\UnexpectedErrorException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;

abstract class ResourceBase
{
    protected Aimtell $aimtell;

    protected Client $client;

    public ?string $siteId;

    public function __construct(Aimtell $aimtell)
    {
        $this->aimtell = $aimtell;

        $this->client = new Client([
            'base_uri' => 'https://api.aimtell.com',
        ]);
    }

    public function setSiteId($siteId) {
        $this->siteId = $siteId;
    }

    public function all(array $query = array())
    {
        $siteId = (isset($query['site_id']) ? $query['site_id'] : $this->siteId);

        return $this->sendRequest(
            'GET',
            $this->resourceName() . 's/' . strval($siteId), // Plural for All Endpoint on Aimtell API
            $query
        );
    }

    public function create(array $data, array $headers = null)
    {
        if (array_key_exists('site_id', $data))
            $this->siteId = $data['site_id'];

        return $this->sendRequest(
            'POST',
            $this->resourceName() . ($this->siteId ? '/' . strval($this->siteId) : ''),
            array(),
            $data,
            $headers
        );
    }

    public function update($id, array $data, array $headers = null)
    {
        return $this->sendRequest(
            'PUT',
            $this->resourceName() . '/' . strval($id),
            array(),
            $data,
            $headers
        );
    }

    public function find($id)
    {
        return $this->sendRequest(
            'GET',
            $this->resourceName().'/'.strval($id)
        );
    }

    public function delete($id)
    {
        return $this->sendRequest(
            'DELETE',
            $this->resourceName().'/'.strval($id)
        );
    }

    protected function resourceName(): string
    {
        $class = explode('\\', get_called_class());
        return $this->camelToUnderscore(array_pop($class));
    }

    protected function camelToUnderscore($string, $us = "-"): string
    {
        $patterns = [
            '/([a-z]+)([0-9]+)/i',
            '/([a-z]+)([A-Z]+)/',
            '/([0-9]+)([a-z]+)/i'
        ];
        $string = preg_replace($patterns, '$1'.$us.'$2', $string);
        $string = strtolower($string);
        return $string;
    }

    protected function sendRequest($method, $path, array $query = array(), array $body = null, array $headers = null)
    {
        $path = $this->getPath($path, $query);
        $options = $this->getOptions($body, $headers);

        try {
            $response = $this->client->request($method, $path, $options);
        } catch (ConnectException $e) {
            // @codeCoverageIgnoreStart
            throw new NetworkErrorException($e->getMessage());
            // @codeCoverageIgnoreEnd
        } catch (GuzzleException $e) {
            if (!$e->hasResponse()) {
                throw new UnexpectedErrorException('An Unexpected Error has occurred: ' . $e->getMessage());
            }

            $responseErrorBody = strval($e->getResponse()->getBody());
            $errorMessage = $this->errorMessageFromJsonBody($responseErrorBody);
            $statusCode = $e->getResponse()->getStatusCode();

//            if ($statusCode === 403)
//                throw new AuthorizationException($errorMessage, 403);

            if ($statusCode === 401)
                throw new AuthorizationException($errorMessage, 401);

            if ($statusCode === 400)
                throw new RequestException($errorMessage, 400);

            throw new UnexpectedErrorException('An Unexpected Error has occurred: ' . $e->getMessage());
        } catch (Exception $e) {
            throw new UnexpectedErrorException('An Unexpected Error has occurred: ' . $e->getMessage());
            // @codeCoverageIgnoreEnd
        }

        return json_decode($response->getBody(), true);
    }

    protected function getPath($path, array $query = array())
    {
        $path = '/prod/'.$path;
        $queryString = '';
        if (!empty($query)) {
            $queryString = '?'.http_build_query($query);
        }
        return $path.$queryString;
    }

    protected function getOptions(array $body = null, array $headers = null): array
    {
        $options = array(
            'headers' => array(
                'Accept' => 'application/json; charset=utf-8',
                'X-Authorization-Api-Key' => $this->aimtell->getApiKey(),
            ),
        );

        if ($headers) {
            $options['headers'] = array_merge($options['headers'], $headers);
        }

        if ($whiteLabelId = $this->aimtell->getWhiteLabelId()) {
            $options['headers']['Aimtell-Whitelabel-ID'] = $whiteLabelId;
        }

        if (!$body) {
            return $options;
        }

        $body = $this->stringifyBooleans($body);
        $options['body'] = json_encode($body);

        return $options;
    }

    /*
     * Because guzzle uses http_build_query it will turn all booleans into '' and '1' for
     * false and true respectively. This function will turn all booleans into the string
     * literal 'false' and 'true'
     */
    protected function stringifyBooleans($body): array
    {
        return array_map(function($value) {
            if (is_bool($value)) {
                return $value ? 'true' : 'false';
            } else if (is_array($value)) {
                return $this->stringifyBooleans($value);
            }
            return $value;
        }, $body);
    }

    protected function errorMessageFromJsonBody($body): string
    {
        $response = json_decode($body, true);
        if (is_array($response) && array_key_exists('error', $response)) {
            $error = $response['error'];

            return $error['message'];
        }
        // @codeCoverageIgnoreStart
        // Pokemon handling is tough to test... "Gotta catch em all!"
        return 'An Internal Error has occurred';
        // @codeCoverageIgnoreEnd
    }
}
