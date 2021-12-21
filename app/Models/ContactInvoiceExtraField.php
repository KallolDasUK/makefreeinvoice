<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ContactInvoiceExtraField extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getFirstAttribute()
    {
        $text = $this->name;
        if (Str::contains($text, '/')) {
            $text = explode('/', $text)[0];
        }
        return $text;

    }

    public function getLastAttribute()
    {
        $text = $this->name;
        if (Str::contains($text, '/')) {
            $text = explode('/', $text)[1];
        } else {
            $text = '';
        }
        return $text;

    }

}
