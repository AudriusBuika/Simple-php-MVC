<?php

/**
	* Route system
*/
class Route
{
	private $_listUri = array();
	private $_controllers = array();
	private $_GETData = array();
	private $_method = array();
	private $_trim = '/\^$';
		

	public function add($uri, $function)
	{
		$uri = trim($uri, $this->_trim);
		$this->_listUri[] = $uri;
		$this->_method[] = $function['method'];
		//['method' => 'SEND', 'controller' => 'sajanas@index']

		$controller = explode('@', $function['controller']);
		$this->_controllers[] = ['controllerName' => $controller[0], 'function' => $controller[1]];

	}
	private function checkClass($class, $method)
	{
		if(class_exists($class)) {
			foreach (get_class_methods($class) as $key => $value)
			{
				if($method == $value)
				{
					return true;
				}
			}
		}
		return false;
	}
	private function urlGET($link)
	{
			preg_match_all("/\{(.*?)\:(.*?)\}/", $link, $matches);
		return $matches;
	}
	private function checkRealLink($realLink, $fakeLink)
	{
		$rEx = explode('/', $realLink);
		$fEx = explode('/', $fakeLink);
		$viso = count($rEx);

		if($viso == count($fEx))
		{
				for ($i=0; $i < $viso; $i++)
					if(!($rEx[$i] == $fEx[$i] || preg_match("/\{(.*?)\:(.*?)\}/", $fEx[$i]) == true))
						return false;
			return true;
		}else
			return false;
	}
	private function addValid($data, $validMethod)
	{
			if($validMethod == 'int')
				return preg_replace("/[^0-9]/", "", $data);
			else if($validMethod == 'letter')
				return preg_replace("/[^A-Za-z]/", "", $data);
		return $data;
	}
	public function start()
	{
		global $_POST;

		$uri = isset($_REQUEST['url']) ? $_REQUEST['url'] : '/';
		$uri = trim($uri, $this->_trim);
		$replacementValues = array();
		# List through the stored URI's

		foreach ($this->_listUri as $listKey => $listUri)
		{
			$realURL = explode('/', $uri); // Array ( [0] => profile [1] => AUDRIUS )
			$fakeURL = explode('/', $listUri); //Array ( [0] => profile [1] => {karve:letter} )

			//echo "key: $listKey - value: $listUri --  #^$listUri$# $uri<br/>";

			if($this->checkRealLink($uri, $listUri))
			{
				if($this->_method[$listKey] == 'GET') {

					if(preg_match("/\{(.*?)\:(.*?)\}/", $listUri))
					{
							$Data = $this->urlGET($listUri);

								$j = 0;
									for ($i=0; $i < count($realURL); $i++)
									{ 
										if(preg_match("/\{(.*?)\:(.*?)\}/", $fakeURL[$i]))
										{
											//echo "ą. {$Data[1][$j]} => $realURL[$i] <- $fakeURL[$i]<br/>";
											$this->_GETData[ $Data[1][$j] ] = $this->addValid($realURL[$i], $Data[2][$j]);
											$j++;
										}
									}
							$nowGetData = (object)$this->_GETData;
					}

				}
				else if($this->_method[$listKey] == 'POST')
				{

					$nowPostData = (object)$_POST;

				}
				else if($this->_method[$listKey] == 'SEND')
				{

					if(preg_match("/\{(.*?)\:(.*?)\}/", $listUri))
					{
							$Data = $this->urlGET($listUri);

								$j = 0;
									for ($i=0; $i < count($realURL); $i++)
									{
										if(preg_match("/\{(.*?)\:(.*?)\}/", $fakeURL[$i]))
										{
											//echo "ą. {$Data[1][$j]} => $realURL[$i] <- $fakeURL[$i]<br/>";
											$this->_GETData[ $Data[1][$j] ] = $this->addValid($realURL[$i], $Data[2][$j]);
											$j++;
										}
									}
							$nowGetData = (object)$this->_GETData;
					}
					$nowPostData = (object)$_POST;

				}

					if($this->checkClass($this->_controllers[$listKey]['controllerName'], $this->_controllers[$listKey]['function']))
					{
						$cObj = new $this->_controllers[$listKey]['controllerName'];
							$cObj->POST = $nowPostData;
							$cObj->GET = $nowGetData;
						$cObj->{$this->_controllers[$listKey]['function']}();
					}else
						die("<html><head><title>ERROR!</title></head><style>body {background-color:black;font-family: Tahoma;}</style><body><h1 style='text-align:center;color: red;'>Toks Controller neegzistuoja!</h1></body></html>");
				break;
			}

		}
		
	}
}
$route = new Route();

