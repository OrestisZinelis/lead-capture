<?php

namespace App\Models;

use Mongodb\Laravel\Eloquent\Model;

class Lead extends Model
{
    protected $connection = 'mongodb'; // Specify your MongoDB connection
    protected $collection = 'leads'; // Specify the collection name

    protected $fillable = [
        // Specify the fields that are mass-assignable
        'name',
        'email',
        'consent',
    ];
}
