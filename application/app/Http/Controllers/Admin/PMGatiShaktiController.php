<?php

namespace App\Http\Controllers\Admin;

use App\Events\SmsMail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CoachingCamp;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PMGatiShaktiController extends Controller
{
    public function dashboard(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $divisions = DB::table('hostel_division_master')
            ->select('id', 'division_name');
        $districts = DB::table('cities')
            ->join('hostel_div_district_mapping','cities.id','=','hostel_div_district_mapping.district_id')
            ->where('cities.state_id', 23)
            ->select('cities.id','cities.city')
            ->distinct();
        $stadiums = DB::table('studium_master')
            ->select('studium_master.*');
        // Division Admin
        if ($admin->admin_role == 2) {
            $divisions->where('id', $admin->division_id);
            $districts->where('hostel_div_district_mapping.division_id',$admin->division_id);
            $stadiums->join('hostel_div_district_mapping','studium_master.district_id','=','hostel_div_district_mapping.district_id')
            ->where('hostel_div_district_mapping.division_id',$admin->division_id);
        }
        // District Admin
        elseif ($admin->admin_role == 9) {
            $districts->where('cities.id',$admin->district_id);
            $stadiums->where('studium_master.district_id',$admin->district_id);
            $divisions->whereIn('id',
                DB::table('hostel_div_district_mapping')
                    ->where('district_id', $admin->district_id)
                    ->select('division_id')
            );
        }
        // Apply filters within authorized scope
        if ($request->filled('division_id')) {
            $divisions->where('id', $request->division_id);
            $districts->where('hostel_div_district_mapping.division_id',$request->division_id);
            $stadiums->whereIn('studium_master.district_id',
                DB::table('hostel_div_district_mapping')
                    ->where('division_id', $request->division_id)
                    ->select('district_id')
            );
        }
        if ($request->filled('district_id')) {
            $districts->where('cities.id',$request->district_id);
            $stadiums->where('studium_master.district_id',$request->district_id);
        }
        if ($request->filled('stadium_id')) {
            $stadiums->where('studium_master.id',$request->stadium_id);
        }
        $divisions = $divisions
            ->orderBy('division_name')
            ->get();
        $districts = $districts
            ->orderBy('cities.city')
            ->get();
        $stadiums = $stadiums
            ->get();
        return view('admin.pm_gatishakti.dashboard', compact('divisions','districts','stadiums'));
    }

}
