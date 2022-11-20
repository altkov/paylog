<?php

namespace Model;

use DateTime;
use DB;
use Query\DateQuery;

abstract class Entry {
    protected static function getSumWithType(int $type, DateQuery $dateQuery) : int {
        $sum = DB::get()->getValue('SELECT sum(value) FROM payment WHERE type = ' . $type . ' AND ' . $dateQuery->getSql());
        return $sum ?: 0;
    }

    public static function getAll(DateQuery $dateQuery) : array {
        $db = DB::get();
        $entryQuery = 'SELECT * FROM payment WHERE ' . $dateQuery->getSql() . ' ORDER BY `date` DESC;';
        $tagQuery = 'SELECT * FROM payments_tags;';

        $entries = $db->getAll($entryQuery . $tagQuery);

        $tags = $db->getNext();

        foreach ($entries as &$entry) {
            if (is_numeric($entry['category_id'])) {
                $entry['category'] = Category::get($entry['category_id']);
            } else {
                $entry['category'] = null;
            }
        }

        return $entries;
    }
}