<?php
namespace Core\Interfaces;

interface ModelInterface {
    public function getAll();
    public function where($column, $data, $columns = '*');
    public function create(array $data) : bool;
    public function update(int $id, array $data) : bool;
    public function delete(int $id) : bool;
}