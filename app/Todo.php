<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = ['title', 'user_id'];
    public function getByUserId($id)
    {
        return $this->where('user_id', $id)->get();
    }
}
