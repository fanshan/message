<?php

    namespace ObjectivePHP\Message\Request\Parameter\Container;

    use ObjectivePHP\Message\Request\HttpRequest;
    use ObjectivePHP\Message\Request\RequestInterface;
    use ObjectivePHP\Primitives\Collection\Collection;

    class HttpParameterContainer extends AbstractContainer
    {

        /**
         * @var RequestInterface
         */
        protected $request;

        /**
         * @var Collection
         */
        protected $params;

        /**
         * Constructor
         */
        public function __construct(RequestInterface $requestInterface)
        {
            $this->params = new Collection();
            $this->setGet($_GET);
        }

        public function get($param, $default = null, $origin = 'get')
        {
            return $this->params->get($origin)->get($param, $default);
        }

        public function fromGet($param = null, $default = null)
        {

            if(is_null($param))
            {
                return $this->params->get('get');
            }

            return $this->get($param, $default, 'get');
        }

        public function fromPost($param = null, $default = null)
        {
            if (is_null($param))
            {
                return $this->params->get('post');
            }

            return $this->get($param, $default, 'post');
        }

        public function fromEnv($var = null, $default = null)
        {
            if (is_null($var))
            {
                return $this->params->get('env');
            }

            return $this->get($var, $default, 'env');
        }

        public function fromFiles($file = null, $default = null)
        {
            if (is_null($file))
            {
                return $this->params->get('files');
            }

            return $this->get($file, $default, 'files');
        }

        public function setGet($getParams)
        {
            $params = Collection::cast($getParams);

            // make params with no values available as anonymous params
            $namedParams   = $params->copy()->filter();
            $unnamedParams = $params->copy()->filter(function ($value)
            {
                return !$value;
            })->flip()
            ;

            $params = $namedParams->merge($unnamedParams);

            $this->params['get'] = $params;

            return $this;
        }

        public function setPost($postParams)
        {
            $this->params['post'] = Collection::cast($postParams);
        }

        public function setFiles($files)
        {
            $this->params['files'] = Collection::cast($files);
        }

        public function setEnv($envVars)
        {
            $this->params['env'] = Collection::cast($envVars);
        }

        /**
         * @codeAssistHint
         * @return HttpRequest
         */
        public function getRequest()
        {
            return $this->request;
        }

    }