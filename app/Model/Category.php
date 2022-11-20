<?php

namespace Model;

use DB;
use Query\DateQuery;

class Category {
    private $id;
    private $name;

    private function __construct(int $id, string $name) {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return self[]
     * */
    public static function getAll() : array {
        $result = DB::get()->getAll('SELECT * FROM categories');
        $categories = [];

        foreach ($result as $category) {
            $categories[] = new Category($category['id'], $category['name']);
        }

        return $categories;
    }

    public static function get(int $id) : ?self {
        $category = DB::get()->getRow('SELECT * FROM categories WHERE id = ?', [$id]);

        if (!$category) {
            return null;
        }

        return new self($category['id'], $category['name']);
    }


    public function getID() : int {
        return $this->id;
    }

    public function getName() : string {
        return $this->name;
    }

    public function getTotalExpense(DateQuery $dateQuery) : int {
        return DB::get()->getValue('SELECT COALESCE(SUM(value), 0) as sum FROM payment WHERE category_id = ? AND ' . $dateQuery->getSql(), [$this->id])
            ?? 0;
    }
}