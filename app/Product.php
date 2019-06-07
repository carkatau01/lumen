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
    /**
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'created_by'
    ];

    /**
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'price', 'amount', 'created_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by')->select(['id', 'username']);
    }
}