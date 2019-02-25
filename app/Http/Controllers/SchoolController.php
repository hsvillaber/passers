<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */


    //top students transactions
    public function index(Request $request)
    {
        return view('schoollist');
    }

    public function schoolslist(Request $request){
        //return 'hello';
        if ($request->input('client')) {
            return DB::table('passers')->select(
                [
                    'school',
                    DB::raw('count(*) AS results'),
                ]
            )->groupby('school')
                ->orderby(DB::raw('count(*)'), 'desc')
                ->get();
        }

        $columns = ['school', 'results'];

        $length = $request->input('length');
        $column = $request->input('column'); //Index
        $dir = $request->input('dir');
        $searchValue = $request->input('search');

        $query = DB::table('passers')->select(
            [
                'school',
                DB::raw('count(*) AS numofschool'),
            ]
        )->groupby('school')
            ->orderBy(DB::raw('count(*)'), 'desc');

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->orWhere('school', 'like', '%' . $searchValue . '%')
                    ->orWhere('numofschool', 'like', '%' . $searchValue . '%');
            });
        }

        $projects = $query->paginate('50');


        return ['data' => $projects, 'draw' => $request->input('draw')];
    }





}

