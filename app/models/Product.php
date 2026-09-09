<?php

class Product extends Model
{
    protected $table = 'products';
    protected $primary_key = 'id';

    protected $fillable = [
        'product_name',
        'description',
        'price',
        'quantity'
    ];

    protected $guarded = ['id'];

    protected $timestamps = false;
}