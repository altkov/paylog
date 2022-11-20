<?php

namespace Query;

use DateTime;

class DateQuery {
    private DateTime $date;
    private ?DateTime $dateEnd;

    public function __construct(DateTime $date, DateTime $dateEnd = null) {
        $this->date = $date;

        $this->dateEnd = $dateEnd;
    }

    public function getSql() : string {
        if ($this->dateEnd !== null) {
            return "`date` BETWEEN '" . $this->format($this->date) . "' AND '" . $this->format($this->dateEnd) . "'";
        } else {
            return "`date` >= '" . $this->format($this->date) . "'";
        }
    }

    private function format(DateTime $date) {
        return $date->format('Y-m-d');
    }
}