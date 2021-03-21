<?php

namespace App\Models;

use Core\Databases\DatabaseB;
use Core\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'id',
        'image',
        'title',
        'description',
        'created_at',
        'updated_at'
    ];

    /**
     * Override default DB connection if needed
     */
    public function setDatabaseConnection()
    {
        parent::$DB = DatabaseB::getInstance();
    }
}