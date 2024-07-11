<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    const SPAM = 'spam';
    const PENDING = 'pending';
    const APPROVE = 'approve';
}
