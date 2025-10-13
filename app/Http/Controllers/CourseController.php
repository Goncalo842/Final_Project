<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CourseController extends Controller
{
    //
    public function licenciatura()
    {
        return view('courses.licenciatura');
    }

    public function ctesp()
    {
        return view('courses.ctesp');
    }

    public function posgraduacao()
    {
        return view('courses.posgraduacao');
    }

    public function dm()
    {
        return view('courses.ctesp.DM');
    }

    public function cs()
    {
        return view('courses.ctesp.CS');
    }

    public function dmm()
    {
        return view('courses.ctesp.DMM');
    }

    public function ds()
    {
        return view('courses.ctesp.DS');
    }

    public function ig()
    {
        return view('courses.ctesp.IG');
    }

    public function ria()
    {
        return view('courses.ctesp.RIA');
    }

    public function rs()
    {
        return view('courses.ctesp.RS');
    }

    public function informatica()
    {
        return view('courses.licenciatura.informatica');
    }

    public function multimedia()
    {
        return view('courses.licenciatura.multimedia');
    }

    public function business()
    {
        return view('courses.posgraduacao.business');
    }

    public function cloud()
    {
        return view('courses.posgraduacao.cloud');
    }
}
