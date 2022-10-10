<?php
require_once __DIR__ . '/Tabela.php';

class Uloga extends Tabela {
	public $id;
	public $naziv;
	public $prioritet;
	
	public static function getByName($naziv) {
		$db = Database::getInstance();
		
		$query = 'SELECT * ' . 'FROM tip_korisnika ' . 'WHERE tip = :t';
		
		$params = [
			':t' => $naziv
		];
		
		$uloge = $db->select('Uloga', $query, $params);
		
		foreach($uloge as $uloga) {
			return $uloga;
		}
		return null;
	}
}