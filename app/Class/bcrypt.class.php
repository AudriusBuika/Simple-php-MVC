<?php
/*
	# bcrypt class
*/
class bcrypt{
	
		public function hashing_password($password) {
				$options = array('cost' => '07','salt' => sha1("oPm7Zq2iY5".md5(time().mt_rand(1,100000000))."Qz8239ExP1"));
				$hash = password_hash($password, PASSWORD_BCRYPT, $options);
				$hash = explode("$2y$07$",$hash);
			return $hash['1'];
		}
		public function verify($password, $hash_data) {
				if(password_verify($password, "$2y$07$".$hash_data))
					return true;
				else
					return false;
		}
}
?>