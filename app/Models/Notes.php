<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    use HasFactory;


    protected $fillable = ['title', 'content']; // Add other fillable attributes
    protected $encrypt = ['content'];


    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->encrypt)) {
            $this->attributes[$key] = encrypt($value);
        } else {
            parent::setAttribute($key, $value);
        }
    }

    public function getAttribute($key)
    {
        if (in_array($key, $this->encrypt) && !empty($this->attributes[$key])) {
            return decrypt($this->attributes[$key]);
        }

        return parent::getAttribute($key);
    }
}
