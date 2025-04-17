<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DashboardPreference extends Model
{

    use HasFactory;

    protected $table="dashboardpreferences";

    protected $fillable = [
        'IdDashboard',
        'Id_user',
        'days90',
        'ObjFat',
        'Top500',
        'Top1000',
        'ObjMargin'
        ];
}
