<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Client extends Model
{
	protected $fillable = [
        'name', 'city', 'country', 'reservation_contact', 'cancellation_email'
    ];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('name', 'asc');
        });
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function calls()
    {
        return $this->hasMany('App\Session');
    }

    public function schedules()
    {
        return $this->hasMany('App\Schedule');
    }

    public function templates()
    {
        return $this->hasMany('App\QuestionTemplate');
    }

    public function company() {
        return $this->belongsTo('App\Company');
    }

    public function region() {
        return $this->belongsTo('App\Region');
    }

    public function category() {
        return $this->belongsTo('App\Category');
    }

    public function reservationContacts() {
        $contacts = explode(',', $this->reservation_contact);
        return $contacts;

    }

    public function cancellationEmails() {
        $emails = explode(',', $this->cancellation_email);
        return $emails;
    }
}
