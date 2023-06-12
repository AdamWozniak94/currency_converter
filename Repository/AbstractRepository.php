<?php

abstract class AbstractRepository
{
    protected mysqli $mysqli;

    public function __construct()
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try {
            $this->mysqli = new mysqli("localhost", "root", "", "currency_converter");
            $this->mysqli->set_charset("utf8mb4");
        } catch (Exception $e) {
            error_log($e->getMessage());
            die();
        }
    }

    abstract public function fetchAllRows();
}