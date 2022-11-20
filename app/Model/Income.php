<?php

namespace Model;

use Query\DateQuery;

class Income extends Entry {
    protected static $type = 1;

    public static function getSum(DateQuery $dateQuery) : int {
        return parent::getSumWithType(self::$type, $dateQuery);
    }
}