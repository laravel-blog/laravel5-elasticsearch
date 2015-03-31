<?php namespace Laravel5Elasticsearch;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

	public function articles() {
        return $this->belongsToMany('Category');
    }

}
