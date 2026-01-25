<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role'
    ];

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
    public function investments()
    {
        return $this->hasMany(Investment::class, 'investor_id');
    }
    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function transactions()
    {
        return $this->hasManyThrough(Transaction::class, Wallet::class);
    }
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
    // في موديل User

    public function supportConversations()
    {
        return $this->hasMany(SupportConversation::class);
    }
    public function getUpcomingPaymentsAttribute()
    {
        return $this->investments()
            ->where('investments.status', 'pending')
            ->join('projects', 'investments.project_id', '=', 'projects.id')
            ->sum(DB::raw('investments.amount * (projects.interest_rate / 100)'));
    }

    public function getLatestConversationAttribute()
    {
        return $this->supportConversations()->latest()->first();
    }
}
