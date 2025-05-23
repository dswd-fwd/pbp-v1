<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function familyMembers() :HasMany
    {
        return $this->hasMany(FamilyProfile::class);
    }

    public function economicActivities()
    {
        return $this->hasMany(UserEconomicActivity::class);
    }

    public function otherSourceAnswers()
    {
        return $this->hasMany(OtherSourceAnswer::class);
    }

    public static function totalSubmission() {
        return static::where('role', 'member')->count();
    }

    public static function submissionByRegion()
    {
        return static::selectRaw("
                TRIM(BOTH ')' FROM SUBSTRING_INDEX(SUBSTRING_INDEX(refregion.regDesc, '(', -1), ')', 1)) AS region,
                COUNT(users.id) AS total
            ")
            ->join('refregion', 'users.refregion_id', '=', 'refregion.id')
            ->where('users.role', 'member')
            ->groupBy('region')
            ->orderBy('region')
            ->get();
    }
    
    public function region()
    {
        return $this->belongsTo(Region::class, 'refregion_id');
    }

}
