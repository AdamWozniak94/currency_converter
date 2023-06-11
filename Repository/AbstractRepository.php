<?php

abstract class AbstractRepository
{
    protected mysqli $mysqli;

    public function __construct()
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try {
            $this->mysqli = new mysqli("localhost", "root", "", "currency_converter");
        } catch (Exception $e) {
            echo $e->getMessage();
            die();
        }
    }

    abstract public function fetchAllRows();
}