<?php

namespace App\Http\Controllers\Applicants;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApplicantsController extends Controller
{
    public function index()
    {
        return view('Applicants.Dashboard.index');
    }

    // Downloads Permits View
    public function DownloadsIndex()
    {
        return view('Applicants.Downloads.index', [
            'ActiveTabMenu' => 'Downloads',
            'SubActiveMenu' => 'Permits'
        ]);
    }

    //Unified Application Form Download
    public function UnifiedApplicationFormDownload()
    {
        return view('Applicants.Downloads.unified-application-form', [
            'ActiveTabMenu' => 'Unified-Application-Form',
            'SubActiveMenu' => 'Permits'
        ]);
    }

    // Civil Permit Download
    public function CivilPermitDownload()
    {
        return view('Applicants.Downloads.civil-permit', [
            'ActiveTabMenu' => 'Civil-Permit',
            'SubActiveMenu' => 'Permits'
        ]);
    }

    // Architectural Permit Download
    public function ArchitecturalPermitDownload(){
        return view('Applicants.Downloads.architectural-permit', [
            'ActiveTabMenu' => 'Architectural-Permit',
            'SubActiveMenu' => 'Permits'
        ]);
    }

    public function ElectricalPermitIndex(){
        return view('Applicants.Downloads.electrical-permit', [
            'ActiveTabMenu' => 'Electrical',
            'SubActiveMenu' => 'Permit'
        ]);
    }

    public function PlumbingPermitIndex(){
        return view('Applicants.Downloads.plumbing-permit', [
            'ActiveTabMenu' => 'Plumbing',
            'SubActiveMenu' => 'Permit'
        ]);
    }

    public function ApplyIndex(){
        return view('Applicants.Apply.index',[
            'ActiveTabMenu' => 'Apply',
            'SubActiveMenu' => 'index'
        ]);
    }
}
