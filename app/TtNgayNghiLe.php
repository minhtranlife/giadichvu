<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TtNgayNghiLe extends Model
{
    protected $table = 'ttngaynghile';
    protected $fillable = [
        'id',
        'tungay',
        'denngay',
        'mota',
        'songaynghi'
    ];
}
