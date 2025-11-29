<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
class Blog extends Model
{
use HasFactory;

    protected $table = 'blogs';

    protected $fillable = [
        'title',
        'slug',
        'image',
        'short_description',
        'long_description',
        'content',
        'status',
    ];

    // Auto-generate slug if not provided
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($blog) {
            if (empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }
        });

        static::updating(function ($blog) {
            if (empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }
        });
    }

    // Optional: Casting fields
    protected $casts = [
        'status' => 'boolean',
    ];
}
