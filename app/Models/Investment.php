<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    protected $fillable = [
        'project_id',      // أضفه هنا
        'investor_id',
        'amount',
        'status',
        'paid_at',
    ];
    /**
     * Cast date attributes to Carbon instances to ensure ->format() works safely.
     */
    protected $casts = [
        'paid_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function investor()
    {
        return $this->belongsTo(User::class, 'investor_id');
    }
    // في موديل User أو Investor

}
