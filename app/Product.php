<?php
/**
 * Created by PhpStorm.
 * User: artemy
 * Date: 6/7/19
 * Time: 3:21 AM
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    public function user()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
}