<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compare extends Model
{
    public $timestamp = false;
    protected $fillable = ['idProduct','session_id'];
    protected $primaryKey = 'idCompare';
    protected $table = 'compare';
}
