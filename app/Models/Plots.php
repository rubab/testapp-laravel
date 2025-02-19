<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plots extends Model
{
    use HasFactory;

    protected $connection = "mysql";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'batch',
        'city',
        'society',
        'block',
        'marla',
        'plot_size',
        'price',
        'status',
    ];
}
