<?php

class Moodle {
	
    private $apikey;
    private $salt;
    private $url;
	
	private $userdata = null;
	
	const F_GET_USER_BY_FIELD = "core_user_get_users_by_field";
	const F_CREATE_USER = "core_user_create_users";
	
	/**
	 * @var Curl
	 */
	private $curl;
    
    public function __construct(){
        $moodle = elgg_get_plugin_from_id('moodle');
        $this->url    = $moodle->getSetting('server_url');
        $this->salt   = $moodle->getSetting('security_salt');
        $this->apikey = $moodle->getSetting('apikey');
		$this->curl = new Curl(array(
			'debug' => true
		));
		
		if($this->salt == null || strlen($this->salt) == 0)
		{
			$this->salt = $this->randString();
			$moodle->setSetting('security_salt', $this->salt);
		}
    }
    
    /**
     * generate random string 
     * $length is desired string length 
     */
    protected function randString($length = 25){
        $chars = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numChars = strlen($chars);
        $string = "";
        for ($i = 0; $i < $length; $i++) {
            $string .= $chars[mt_rand(0, $numChars - 1)];
        }
		return $string;
    }
	
	protected function query($function, array $params = array(), $method = "post")
	{
		if(false == in_array($method, array("get","put","post","delete")))
		{
			throw new Exception("bad method");
		}		
		$url = "{$this->url}/webservice/rest/server.php?wstoken={$this->apikey}&wsfunction={$function}&moodlewsrestformat=json";
		
		echo "###############################################<br/>\n";
		echo "moodle query started<br/>\n";
		echo "url: $url\n<br/>\n";
		echo "params: ". var_export($params, true)."\n<br/>\n";
		
		ob_get_level() && ob_flush(); flush();
		
		$response =  json_decode($this->curl->$method($url, $params));		
		
		echo "response: ". var_export($response, true)."\n<br/>\n";
		echo "###############################################<br/>\n";
		return $response;
	}
	
	public function getUserData()
	{
		if($this->userdata == null)
		{
			$this->userdata = $this->loadUserData();
		}
		return $this->userdata;
	}

    /**
	 * create password for current user
	 */
    protected function passCreate($email){
        return md5($email . $this->salt);
    }    
    
    private function loadUserData(){
		
		$returnValue = new stdClass();
		$logged_user = get_loggedin_user();
		
		$name = trim(preg_replace("/[ ]{2,100}/", " ", $logged_user->name));				
		$name_arr = explode(" ", $name);
				
		$returnValue->username = $logged_user->username;
		$returnValue->firstname = (isset($name_arr[0]) && strlen($name_arr[0]) > 0) ? $name_arr[0] : "Anonymous";
		$returnValue->lastname = isset($name_arr[1]) ? $name_arr[1] : "Anonymous";
		$returnValue->email = $logged_user->email;
		$returnValue->password = $this->passCreate($logged_user->email);

        return $returnValue;
    }
    
    public function userCheck(){		
        $userdata = $this->getUserData();		
		$response = $this->query(self::F_GET_USER_BY_FIELD, array("email" => $userdata->email));		
		return count($response) == 1;			
    }
	
	public function getUrl()
	{
		return $this->url;
	}
	
	public function getSalt()
	{
		return $this->salt;
	}
    
    /**
	 * Create user in moodle
     */
    public function userCreate(){
		$this->query(
			self::F_CREATE_USER, 
			array(
				'users' => array($this->getUserData())
			)
		);
		return true;
    }    
}
