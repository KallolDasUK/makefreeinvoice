<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GlobalSetting
 *
 * @property int $id
 * @property string|null $key
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|GlobalSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GlobalSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GlobalSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|GlobalSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GlobalSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GlobalSetting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GlobalSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GlobalSetting whereValue($value)
 * @mixin \Eloquent
 */
class GlobalSetting extends Model
{

    use HasFactory;

    protected $guarded = [];
}
