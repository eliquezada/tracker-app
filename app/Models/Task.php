<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'name', 'user_id', 'stopped_at', 'started_at'
    ];

    protected $dates = ['started_at', 'stopped_at'];

     /**
     * access to user
     * @return mixed
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to search by login user
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMine($query)
    {
        return $query->whereUserId(auth()->user()->id);
    }

    /**
     * Scope a query to get active tasks
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */

    public function scopeRunning($query)
    {
        return $query->whereNull('stopped_at');
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIdDescending($query)
    {
        return $query->orderByDesc('id');
    }

    /**
     * Scope a query to group by task name
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGroupName($query)
    {
        return $query->groupByRaw('name');
    }
}
