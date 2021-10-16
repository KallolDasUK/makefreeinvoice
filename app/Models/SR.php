<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SR
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $name
 * @property string|null $photo
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $address
 * @property int|null $client_id
 * @property int|null $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|SR newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SR newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SR query()
 * @method static \Illuminate\Database\Eloquent\Builder|SR whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SR whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SR whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SR whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SR whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SR whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SR wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SR wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SR whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SR whereUserId($value)
 * @mixin \Eloquent
 */
class SR extends Model
{


    protected $table = 's_rs';

    protected $guarded = [];


}
