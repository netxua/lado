<?php
namespace Libraries\Baymax;
use Libraries\Baymax\Pie\Lists;
use Libraries\Baymax\Pie\User;
use Libraries\Baymax\Pie\Users;
use Libraries\Baymax\Pie\Website;
use Libraries\Baymax\Pie\Websites;
use Lang, Cache;

class core {
	const 	version = '1.0.0';
	private $timelife = 60; //60s
	private $prefix = '_lodo';
	public function __construct( $data = array() ) {
	}

	private function getVersion() {
		return self::version;
	}

	private function getTimelife() {
		return $this->timelife;
	}

	public function setTimelife( $timelife ) {
		$this->timelife = $timelife;
		return $this;
	}

	public function getMe() {
		$list = explode ('\\', get_class($this));
		return end($list);
	}

	protected function getPrefix() {
		return $this->prefix;
	}

	public function setPrefix( $prefix ) {
		$this->prefix = $prefix;
		return $this;
	}

	public function remember( $key, $callback, $time = '' ) {
		if ( empty($time) ) {
			$time = $this->getTimelife();
		}
		return Cache::remember($key, $time , function()  use ($callback) {
			if ( is_callable($callback) ) {
		        return call_user_func($callback);
		    }
            return '';
        });
	}

	public function pull( $key ) {}

	public function has( $key ) {}

	public function increment( $key, $callback ) {
		$amount = 1;
		if ( is_callable($callback) ) {
			$amount = call_user_func($callback);
		} else {
			$amount = $callback;
		}
		return $amount;
	}

	public function decrement( $key, $callback ) {
		$amount = 1;
		if ( is_callable($callback) ) {
			$amount = call_user_func($callback);
		} else {
			$amount = $callback;
		}
		return $amount;
	}

	public function put( $key, $callback, $time = '' ) {
		$rows = array();
		if ( is_callable($callback) ) {
			$rows = call_user_func($callback);
		} else {
			$rows = $callback;
		}
		return $rows;
	}

	public function add( $key, $callback, $time = '' ) {
		$rows = array();
		if ( is_callable($callback) ) {
			$rows = call_user_func($callback);
		} else {
			$rows = $callback;
		}
		return $rows;
	}

	public function forever( $key, $callback ) {
		$rows = array();
		if ( is_callable($callback) ) {
			$rows = call_user_func($callback);
		} else {
			$rows = $callback;
		}
		return $rows;
	}

	public function forget( $key ) {}

	public function flush() {}

	/* key */
	protected function gRString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    protected function getUIString( $len = 20 ){
        return $this->getPrefix() .'_'. max(0, date('Y')-2010) .'_'. $this->gRString($len) .'_'. date('mdHms');
    }

	private function _key( $len = 20 ) {
		return $this->getUIString( $len );
	}

	/* obj */
	public function getObject( $row, $cols = array(), $isFix = TRUE ) {
		$obj  = new \stdClass;
		$obj->_key = $this->_key();
		if ( !empty($cols['_key']) && !empty($row[$cols['_key']]) ) {
			$obj->_key = $row[$cols['_key']];
		}
		if ( !empty($row) ) {
			if ( is_object($row) ){
				$row = (array)$row;
			}
			if ( is_array($row) ) {
				foreach ( $row as $key => $val ) {
					if ( empty($cols) ) {
						$obj->{$key} = $val;
					} else {
						if ( !empty($cols[$key]) ) {
							$obj->{$cols[$key]} = $val;
						} else if ( $isFix ) {
							$obj->{$key} = $val;
						}
					}
				}
			}
		}
		return $obj;
	}

	/* obj */
	public function getUser() {
		$user = new User();
		return $user;
	}

	public function getUsers() {
		$users = new Users();
		return $users;
	}

	public function getWebsite() {
		$website = new Website();
		return $website;
	}

	public function getWebsites() {
		$websites = new Websites();
		return $websites;
	}

	public function getLists() {
		$lists = new Lists();
		return $lists;
	}
}
