<?php

namespace App\Request;

final class Request
{
    private array $requestChain;
    private array $requestKeys;
    private array $headers;
    private string $rawBody;
    private array $keyParsedBody;
    private array $postData;
    private string $uri;
    private string $method = '';


    private const METHOD = ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'];


    public function __construct()
    {
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->requestKeys = $this->getUriKeys($this->uri);
        $this->requestChain = $this->setRequestChain($this->uri);
        $this->headers =getallheaders();
        $this->rawBody = file_get_contents('php://input');
        $this->keyParsedBody = $this->parsePostFileds();
        $this->postData = $_POST;
        $this->setMethod();
    }

    private function setMethod() {
        $method = $_SERVER["REQUEST_METHOD"];

        if (in_array($method, self::METHOD)) {
            $this->method = $method;
        } else {
            throw new \RuntimeException("Method not allowed: $method");
        }
    }

    private function setRequestChain($requestUri):array {
        $result = array();
        $uriAr = explode("/",$requestUri);

        foreach ($uriAr as $path) {
            if (strlen($path) > 0) {
                $result[] = $path;
            }
        }

        return $result;
    }


    private function getUriKeys($requestUri): array {
        $urlParts = parse_url($requestUri);
        $queryParams = array();

        if (isset($urlParts['query'])) {
            $query = $urlParts['query'];
            $query = html_entity_decode($query); // Декодируем HTML-экранированные символы
            parse_str($query, $queryParams);
        }

        return $queryParams;
    }


    private function parsePostFileds(): array {
        $result = array();

        if (strlen($this->rawBody) > 0) {
            $ar = explode("&", urldecode(html_entity_decode($this->rawBody)));

            foreach ($ar as $line) {
                $postData = explode("=", $line);
                if (count($postData) == 2) {
                    $result[$postData[0]] = $postData[1];
                }
            }
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getRequestKeys(): array
    {
        return $this->requestKeys;
    }

    public function getRequestKeyValue($keyName) {
        if (array_key_exists($keyName, $this->requestKeys)) {
            return $this->requestKeys[$keyName];
        }
    }


    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->rawBody;
    }

    public function getParsedBody(): array {
        return $this->keyParsedBody;
    }

    /**
     * @return array
     */
    public function getRequestChain(): array
    {
        return $this->requestChain;
    }

    public function getRequestChainString():string {
        $result = "";
        foreach ($this->requestChain as $block) {
            $result .= $block."->";
        }
        return substr($result,0,-2);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return array
     */
    public function getPostData(): array
    {
        return $this->postData;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

}