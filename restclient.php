<?php

/** REST Full Client
 * 
 */
class Restclient
{

    private $HTTP_ERROR_CODES=array(
	// [Informational 1xx]
	100=>"Continue",
	101=>"Switching Protocols",

	//[Successful 2xx]
	200=>"OK",
	201=>"Created",
	202=>"Accepted",
	203=>"Non-Authoritative Information",
	204=>"No Content",
	205=>"Reset Content",
	206=>"Partial Content",

	//[Redirection 3xx]
	300=>"Multiple Choices",
	301=>"Moved Permanently",
	302=>"Found",
	303=>"See Other",
	304=>"Not Modified",
	305=>"Use Proxy",
	306=>"(Unused)",
	307=>"Temporary Redirect",

	//[Client Error 4xx]
	400=>"Bad Request",
	401=>"Unauthorized",
	402=>"Payment Required",
	403=>"Forbidden",
	404=>"Not Found",
	405=>"Method Not Allowed",
	406=>"Not Acceptable",
	407=>"Proxy Authentication Required",
	408=>"Request Timeout",
	409=>"Conflict",
	410=>"Gone",
	411=>"Length Required",
	412=>"Precondition Failed",
	413=>"Request Entity Too Large",
	414=>"Request-URI Too Long",
	415=>"Unsupported Media Type",
	416=>"Requested Range Not Satisfiable",
	417=>"Expectation Failed",

	//[Server Error 5xx]
	500=>"Internal Server Error",
	501=>"Not Implemented",
	502=>"Bad Gateway",
	503=>"Service Unavailable",
	504=>"Gateway Timeout",
	505=>"HTTP Version Not Supported"
    );

    const GET='get';
    const GET_REST='getREST';
    const POST='post';
    const PUT='put';
    const PATCH='patch';
    const DELETE='delete';

    public function getMethodGet(){
	return self::GET;
    }

    public function getMethodPost(){
	return self::POST;
    }

    public function getMethodPUT(){
	return self::PUT;
    }

    public function getMethodPatch(){
	return self::PATCH;
    }

    public function getMethodDelete(){
	return self::DELETE;
    }

    public function getMethodGetRest(){
	return self::GET_REST;
    }
	
    /**
     * Instance de Codeigniter
     * @var object
     */
    private $CI;

    /**
     * Configuration Array
     */
    private $config = array(
        'port'          => NULL,
        'auth'          => FALSE,
        'auth_type'     => 'basic',
        'auth_username' => '',
        'auth_password' => '',
        'header'        => FALSE,
        'cookie'        => FALSE,
        'timeout'       => 10,
        'result_assoc'  => TRUE,
        'cache'         => FALSE,
        'tts'           => 3600,
	'verbose'	=> FALSE,
	'custom_cer'	=> ''
    );

    private $verboseInfo='';

    /**
     * Information Array
     */
    private $info = array();

    /**
     * Errno integer
     */
    private $errno;

    /**
     * Error String
     */
    private $error;

    /**
     * Output Value Array
     */
    private $output_value = array();

    /**
     * Output Header Array
     */
    private $output_header = array();

    /**
     * Input Value String
     */
    private $input_value;

    /**
     * Input Header String
     */
    private $input_header;

    /**
     * Http Code Integer|NULL
     */
    private $http_code;

    /**
     * Conent Type String|NULL
     */
    private $content_type;

    /**
     * Constructor with Configuration Array
     */
    public function __construct(array $config = array(), $endPoint='')
    {

	$this->logger=Logger::getLogger('REST_CLIENT');

        // Initialize the configuration, if exists
        if (substr($endPoint, 0, 7) === 'http://' ||
            substr($endPoint, 0, 8) === 'https://'){
            $this->endPoint=$endPoint;
        }else{
            //Endpoint error
        }

        $this->initialize($config);
    }

    /**
     * Initialize with Configuration Array
     */
    public function initialize(array $config = array())
    {
        // If there is no configuration file
        if (empty($config)) {
            return;
        }

        $this->config = array_merge($this->config, (isset($config['restclient'])) ? $config['restclient'] : $config);
    }

    /**
     * GET Method
     * @param type $url
     * @param array $data
     * @param array $options
     * @return string|boolean
     */
    public function get($url, $data = array(), $options = array())
    {
	$this->logger->debug($url);

        $this->config['header']['codiceChiamata'] = $this->getGUID();
	$data = json_decode(json_encode($data->getDatatoSend()), true);
	$url = $this->endPoint."$url?".http_build_query($data);
        return $this->_query('get', $url, $data, $options);
    }

	/**
     * Requ�te GET
     * @param type $url
     * @param array $data
     * @param array $options
     * @return string|boolean
     */
    public function getREST($url, $data = array(), $options = array())
    {
	$this->logger->debug($url);

        $this->config['header']['codiceChiamata'] = $this->getGUID();
	$url = $this->endPoint."$url/".rawurlencode(implode('/', $data->getDatatoSend()));
	return $this->_query('get', $url, $data, $options);
    }


    /**
     * Requ�te POST
     * @param type $url
     * @param array $data
     * @param array $options
     * @return string|boolean
     */
    public function post($url, $data = array(), $options = array())
    {
	$this->logger->info($url);

        $this->config['header']['codiceChiamata'] = $this->getGUID();
	$data = json_encode($data->getDatatoSend());
	return $this->_query('post', $this->endPoint.$url, $data, $options);
    }


    public function postFormData($url, $data = array(), $options = array())
    {
	$this->logger->info($url);

        $this->config['header']['codiceChiamata'] = $this->getGUID();
	return $this->_query('post', $this->endPoint.$url, $data->getDatatoSend(), $options);
    }

    /**
     * Requ�te PUT
     * @param type $url
     * @param array $data
     * @param array $options
     * @return string|boolean
     */
    public function put($url, $data = array(), $options = array())
    {
	$this->logger->debug($url);

        $this->config['header']['codiceChiamata'] = $this->getGUID();
	$data = json_encode($data->getDatatoSend());
	return $this->_query('put', $this->endPoint.$url, $data, $options);
    }

	public function putRest($url, $data = array(), $options = array())
    {
		$this->logger->debug($url);

		$this->config['header']['codiceChiamata'] = $this->getGUID();
		$data = json_encode($data);
        return $this->_query('put', $this->endPoint.$url, $data, $options);
    }

    /**
     * Requ�te PATCH
     * @param type $url
     * @param array $data
     * @param array $options
     * @return string|boolean
     */
    /*public function patch($url, $data = array(), $options = array())
    {
        return $this->_query('patch', $url, $data, $options);
    }*/

    public function patch($url, $data = array(), $options = array())
    {
        $this->logger->debug($url);

        $this->config['header']['codiceChiamata'] = $this->getGUID();
	    $data = json_encode($data->getDatatoSend());
        return $this->_query('patch', $this->endPoint.$url, $data, $options);
    }

    public function patchRest($url, $data = array(), $options = array())
    {
        $this->logger->debug($url);

        $this->config['header']['codiceChiamata'] = $this->getGUID();
	    $data = json_encode($data->getDatatoSend());
        return $this->_query('patch', $this->endPoint.$url, $data, $options);
    }
    /**
     * Requ�te DELETE
     * @param type $url
     * @param array $data
     * @param array $options
     * @return string|boolean
     */
    /*public function delete($url, $data = array(), $options = array())
    {
        return $this->_query('delete', $url, $data, $options);
    }*/

    public function delete($url, $data = array(), $options = array())
    {
        $this->logger->debug($url);

        $this->config['header']['codiceChiamata'] = $this->getGUID();
	    $data = json_encode($data->getDatatoSend());
        return $this->_query('delete', $this->endPoint.$url, $data, $options);
    }

    public function deleteRest($url, $data = array(), $options = array())
    {
        $this->logger->debug($url);

        $this->config['header']['codiceChiamata'] = $this->getGUID();
	    $data = json_encode($data->getDatatoSend());
        return $this->_query('delete', $this->endPoint.$url, $data, $options);
    }

    /**
     * R�cup�re les cookies
     * @return array
     */
    public function get_cookie()
    {
        $cookies = array();

        // Recherche dans les en-t�tes les cookies
        preg_match_all('/Set-Cookie: (.*?);/is', $this->input_header, $data, PREG_PATTERN_ORDER);

        // Si il y a des cookies
        if (isset($data[1])) {
            foreach ($data[1] as $i => $cookie) {
                if (!empty($cookie)) {
                    list($key, $value) = explode('=', $cookie);
                    $cookies[$key] = $value;
                }
            }
        }

        return $cookies;
    }

    /**
     * Les derni�res informations de la requ�te
     * @return array
     */
    public function info()
    {
        return $this->info;
    }

    /**
     * Le dernier code de retour http
     * @return interger|NULL
     */
    public function http_code()
    {
        return $this->http_code;
    }
    public function errno()
    {
        return $this->errno;
    }
    public function error()
    {
        return $this->error;
    }

    /**
     * Mode debug
     * @param  boolean $return retournera l'information plut�t que de l'afficher
     * @return string le code HTML
     */
    public function debug($return = FALSE)
    {
        $input = "=============================================<br/>".PHP_EOL;
        $input .= "=============================================<br/>".PHP_EOL;
        $input .= "<h1>Debug</h1>".PHP_EOL;
        $input .= "=============================================<br/>".PHP_EOL;
        $input .= "<h2>Envoi</h2>".PHP_EOL;
        $input .= "=============================================<br/>".PHP_EOL;
        $input .= "<h3>En-tete</h3>".PHP_EOL;
        $input .= "<pre>".PHP_EOL;
        $input .= print_r($this->output_header, TRUE);
        $input .= "</pre>".PHP_EOL;
        $input .= "<h3>Valeur</h3>".PHP_EOL;
        $input .= "<pre>".PHP_EOL;
        $input .= print_r($this->output_value, TRUE);
        $input .= "</pre>".PHP_EOL;
        $input .= "<h3>Informations</h3>".PHP_EOL;
        $input .= "</pre>".PHP_EOL;
        $input .= print_r($this->info, TRUE);
        $input .= "</pre><br/>".PHP_EOL;
        $input .= "=============================================<br/>".PHP_EOL;
        $input .= "<h2>Response</h2>".PHP_EOL;
        $input .= "=============================================<br/>".PHP_EOL;
        $input .= "<h3>En-tete</h3>".PHP_EOL;
        $input .= "<pre>".PHP_EOL;
        $input .= print_r($this->input_header, TRUE);
        $input .= "</pre>".PHP_EOL;
        $input .= "<h3>Valeur</h3>".PHP_EOL;
        $input .= "<pre>".PHP_EOL;
        $input .= print_r($this->input_value, TRUE);
        $input .= "</pre>".PHP_EOL;
        $input .= "=============================================<br/>".PHP_EOL;

        // Si il y a des erreurs
        if (!empty($this->error)) {
            $input .= "<h3>Errors</h3>".PHP_EOL;
            $input .= "<strong>Code:</strong> ".$this->errno."<br/>".PHP_EOL;
            $input .= "<strong>Message:</strong> ".$this->error."<br/>".PHP_EOL;
            $input .= "=============================================<br/>".PHP_EOL;
        }

        // Type de sortie
        if ($return) {
            return $input;
        } else {
            echo $input;
        }
    }

    /**
     * Envoi la requ�te
     * @param string $method
     * @param string $url
     * @param array $data
     * @param array $options
     * @return string|boolean
     */
    private function _query($method, $url, $data = array(), array $options = array())
    {

		$this->logger->info($url);
		$this->logger->debug(print_r($data, true));


		// Initialise la configuration, si elle existe
        $this->initialize($options);

        // Initialisation
        $this->output_header = array();
        $this->output_value = array();
        $this->input_header = '';
        $this->input_value = '';
        $this->http_code = NULL;
        $this->content_type = NULL;

        // Si le cache est activ�
        if ($this->config['cache']) {
            // Parse l'URL
            $url_indo = parse_url($url);

            // D�finition de l'api
            $api = 'rest'.str_replace('/', '_', $url_indo['path']);

            // D�finition de la cl�
            $cache_key = (isset($url_indo['query'])) ? "{$api}_".md5($url_indo['query']) : "{$api}";

            // Si la m�thode est de type GET
            if ($method == 'get') {
                // Si il existe une cl�
                if ($result = $this->CI->cache->get($cache_key)) {
                    return $result;
                }

                // Si la m�thode n'est pas de type GET
            } else {
                // Si l'arbre de cl�s existe
                if ($keys = $this->CI->cache->get($api)) {
                    if (is_array($keys)) {
                        // Parcours les cl�s pour les supprimer
                        foreach ($keys as $key) {
                            $this->CI->cache->delete($key);
                        }
                    }

                    // Supprime l'arbre de cl�s
                    $this->CI->cache->delete($api);
                }
            }
        }

        // Cr�ation d'une nouvelle ressource cURL
        $curl = curl_init($url);


        // Configuration de l'URL et d'autres options
        curl_setopt($curl, CURLOPT_URL, $url);

        // Si le port est sp�cifi�
        if (!empty($this->config['port'])) {
            curl_setopt($curl, CURLOPT_PORT, $this->config['port']);
        }

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->config['timeout']);
        //curl_setopt($curl, CURLOPT_FAILONERROR, TRUE);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($curl, CURLOPT_FILETIME, TRUE);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, strtoupper($method));
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, TRUE);
        curl_setopt($curl, CURLOPT_HEADER, FALSE);
        curl_setopt($curl, CURLOPT_HEADERFUNCTION, array($this, '_headers'));
        curl_setopt($curl, CURLOPT_COOKIESESSION, TRUE);
		/*
		curl_setopt($curl, CURLOPT_PROXY, '192.168.100.1:8080');
		curl_setopt($curl, CURLOPT_PROXYUSERPWD, 'dominio\user:password');
		curl_setopt($curl, CURLOPT_PROXYPORT, 8080);
		curl_setopt($curl, CURLOPT_PROXYAUTH, CURLAUTH_NTLM);
		*/

		if($this->config['custom_cer']!=''){
			curl_setopt($curl, CURLOPT_CAINFO, $this->config['custom_cer']);
			curl_setopt($curl, CURLOPT_FILETIME, TRUE);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		}

		if($this->config['verbose']) {
			curl_setopt($curl, CURLOPT_VERBOSE, TRUE);
			curl_setopt($curl, CURLOPT_STDERR, $verbose = fopen('php://temp', 'rw+'));
		}

        // Si il y a une authentification
        if ($this->config['auth']) {
            switch ($this->config['auth_type']) {
                // Authentification http basic
                case 'basic':
                    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                    curl_setopt($curl, CURLOPT_USERPWD, "{$this->config['auth_username']}:{$this->config['auth_password']}");
                    break;
                case 'bearer':
                    //echo 'preparo la richiesta con il bearer token: '.$this->config['bearer_token'];
                    // curl_setopt($curl, CURLOPT_HTTPHEADER,  "Authorization: Bearer ".$this->config['bearer_token']);
                    $this->config['header']['Authorization']='Bearer '.$this->config['bearer_token'];
                    break;
            }
        }

        // Si il y a des headers
        if (!empty($this->config['header']) && is_array($this->config['header'])) {
            // Ajoute les en-t�tes
            foreach ($this->config['header'] as $key => $value) {
                $this->output_header[] = "$key: $value";
            }
        }

        // R�f�rence du data
        $this->output_value =& $data;

        // Encodage des datas
        switch ($method) {
            case 'post':
            case 'patch':
            case 'delete':
                curl_setopt($curl, CURLOPT_POST, TRUE);
                if (!empty($data)) {
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                break;
            case 'put':
            /*case 'delete':
                if (!empty($data)) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, (is_array($data)) ? http_build_query($data) : $data);
                }
                break;*/
            case 'get':
            default:
        }

        // D�finition des headers d'envoi
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->output_header);

        // Si y il a un cookie
        if (!empty($this->config['cookie']) && is_array($this->config['cookie'])) {
            $cookies = array();

            foreach ($this->config['cookie'] as $key => $value) {
                $cookies[] = "$key=$value";
            }

            curl_setopt($curl, CURLOPT_COOKIE, implode(";", $cookies));
        }

        // R�cup�ration de l'URL et affichage sur le naviguateur
        $response = curl_exec($curl);

		if($this->config['verbose']) {
			!rewind($verbose);
			$this->verboseInfo="Verbose information:\n".stream_get_contents($verbose)."\n";
			//echo "Verbose information:\n", !rewind($verbose), stream_get_contents($verbose), "\n";
		}

        // R�cup�ration du code http
        $this->http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // R�cup�ration du type de contenu
        $this->content_type = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);

        // Information sur la requete
        $this->info = curl_getinfo($curl);

		$this->logger->info('HTTP_CODE: '.curl_getinfo($curl, CURLINFO_HTTP_CODE).' TOTAL_TIME: '.curl_getinfo($curl, CURLINFO_TOTAL_TIME));
		$this->logger->debug('NAMELOOKUP_TIME: '.curl_getinfo($curl, CURLINFO_NAMELOOKUP_TIME).' CONNECT_TIME: '.curl_getinfo($curl, CURLINFO_CONNECT_TIME));
		$this->logger->debug('SSL_VERIFYRESULT: '.curl_getinfo($curl, CURLINFO_SSL_VERIFYRESULT));

        // Gestion des erreurs
        if ($response === FALSE) {
            $this->errno = curl_errno($curl);
            $this->error = curl_error($curl);
            return FALSE;
        }

        // Fermeture de la session cURL
        curl_close($curl);

        // Si le contenu est du json
        if (strstr($this->content_type, 'json')) {
            $result = json_decode($response, $this->config['result_assoc']);
        // Si autre format
        } else {
            $result = $response;
        }

        // R�f�rence de la r�ponse
        $this->input_value = & $response;

        // Si le cahche est activ� et que la m�thode est de type GET
        if ($this->config['cache'] && $method == 'get') {
            // Si la cl� existe dans le noeud
            if (!$keys = $this->CI->cache->get($api) OR ! isset($keys[$cache_key])) {
                // R�cup�re les cl�s existantes
                $keys = (is_array($keys)) ? $keys : array();

                // Enregistre la cl�
                $keys[$cache_key] = $cache_key;

                // Sauvegarde les cl�s
                $this->CI->cache->save($api, $keys, $this->config['tts']);
            }

            // Sauvegarde les donn�es
            $this->CI->cache->save($cache_key, $result, $this->config['tts']);
        }

		if($this->http_code!=200){
			$result=new StdClass();
			$result->CodEsito=$this->http_code;
			$result->DescEsito=$this->HTTP_ERROR_CODES[$this->http_code];
			$result->TraceGuid=$this->config['header']['codiceChiamata'];
			$result->ErrorsDetail=array();
			$result->Payload=array();
		}

        // Retourne les r�sultats
        return $result;
    }

    /**
     * R�cup�re les en-t�tes
     * @param resource $curl
     * @param string $data
     * @return integer
     */
    public function _headers($curl, $data)
    {
        if (!empty($data)) {
            $this->input_header .= $data;
        }

        return strlen($data);
    }

    public function getGUID($trim = true)
    {
	$retVal;
	if (function_exists('com_create_guid'))
	{
		$retVal = com_create_guid();
	}
	else
	{
		mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
		$charid = strtoupper(md5(uniqid(rand(), true)));
		$hyphen = chr(45);// "-"
		$uuid = chr(123)// "{"
			.substr($charid, 0, 8).$hyphen
			.substr($charid, 8, 4).$hyphen
			.substr($charid,12, 4).$hyphen
			.substr($charid,16, 4).$hyphen
			.substr($charid,20,12)
			.chr(125);// "}"
		$retVal = $uuid;
	}
	if ($trim === true)
		$retVal = trim($retVal, '{}');
	    
	return $retVal;
    }

    public function getVerboseInfo(){
	return $this->verboseInfo;
    }
}

?>
