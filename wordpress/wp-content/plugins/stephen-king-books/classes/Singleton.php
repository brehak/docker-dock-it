<?php

namespace SKB;

abstract class Singleton
{
	protected static $instance;

	abstract protected function __construct();

	private function __clone(){}

	public static function getInstance(){
		if(!isset(static::$instance)){
			static::$instance = new static();
		}
		return static::$instance;
	}
}