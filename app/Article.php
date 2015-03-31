<?php namespace Laravel5Elasticsearch;

use Illuminate\Database\Eloquent\Model;

class Article extends Model {

    protected $fillable = [
        'title',
        'short_desc',
        'long_desc',
        'price',
        'vat'
    ];

	public function categories() {
        return $this->belongsToMany('Category', 'articles_2_category');
    }

}
