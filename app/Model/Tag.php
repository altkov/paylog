<?php

namespace Model;

use DB;

class Tag {
    private $id;
    private $name;

    private function __construct(int $id, string $name) {
        $this->name = $name;
        $this->id = $id;
    }

    public static function getAll() : \Generator|array {
        $tags = DB::get()->getAll('SELECT * FROM tag');

        foreach ($tags as $tag) {
            yield new self($tag['id'], $tag['name']);
        }

        return [];
    }

    public function getName() : string {
        return $this->name;
    }

    public function getID() : string {
        return $this->id;
    }
}