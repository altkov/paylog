<?php

namespace Query;

abstract class Query {
    abstract public function getSql() : string;
}