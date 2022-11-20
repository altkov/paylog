<?php

namespace Model;

use Query\DateQuery;

class Expense extends Entry {
    protected static $type = 0;

    public static function getSum(DateQuery $date) : int {
        return parent::getSumWithType(self::$type, $date);
    }
}