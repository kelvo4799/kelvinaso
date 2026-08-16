<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

#[Fillable(['name', 'email', 'password', 'role', 'referral_code'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected static function booted(): void
    {
        static::creating(function (User $user) {
            if (empty($user->referral_code)) {
                $user->referral_code = 'REF-' . strtoupper(Str::random(6));
            }
        });
    }

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

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function stacks()
    {
        return $this->hasMany(Stack::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function referrals()
    {
        return $this->hasMany(Referral::class, 'referrer_id');
    }

    public function getReferralLinkAttribute(): string
    {
        return url('/?ref=' . $this->referral_code);
    }
}
