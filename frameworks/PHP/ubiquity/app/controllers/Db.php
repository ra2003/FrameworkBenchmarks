<?php
namespace controllers;

use Ubiquity\orm\DAO;
use models\World;

/**
 * Bench controller.
 */
class Db extends \Ubiquity\controllers\Controller {

	public function __construct() {}

	public function initialize() {
		\header('Content-Type: application/json');
		\Ubiquity\cache\CacheManager::startProd(\Ubiquity\controllers\Startup::$config);
	}

	public function index() {
		echo \json_encode((DAO::getById(World::class, [
			'id' => \mt_rand(1, 10000)
		], false))->_rest);
	}

	public function query($queries = 1) {
		$worlds = [];
		$queries = \min(\max($queries, 1), 500);
		for ($i = 0; $i < $queries; ++ $i) {
			$worlds[] = (DAO::getById(World::class, [
				'id' => \mt_rand(1, 10000)
			], false))->_rest;
		}
		echo \json_encode($worlds);
	}

	public function update($queries = 1) {
		$worlds = [];
		$queries = \min(\max($queries, 1), 500);
		for ($i = 0; $i < $queries; ++ $i) {
			$world = DAO::getById(World::class, [
				'id' => \mt_rand(1, 10000)
			], false);
			$world->randomNumber = \mt_rand(1, 10000);
			DAO::update($world);
			$worlds[] = $world->_rest;
		}
		echo \json_encode($worlds);
	}
}
