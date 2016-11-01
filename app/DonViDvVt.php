<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DonViDvVt extends Model
{
    protected $table = 'donvidvvt';
    protected $filltable = [
        'id',
        'tendonvi',
        'masothue',
        'diachi',
        'dienthoai',
        'giayphepkd',
        'fax',
        'email',
        'diadanh',
        'chucdanh',
        'nguoiky',
        'dknopthue',
        'setting',
        'dvxk',
        'dvxb',
        'dvxtx',
        'dvk',
        'toado',
        'ghichu',
        'trangthai',
        'tailieu'
    ];
}
