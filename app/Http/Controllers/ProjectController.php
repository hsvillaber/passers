<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

class ProjectController extends Controller
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
        if ($request->input('client')) {
            return DB::table('passers')->select('id', 'name_of_examinee', 'campus_eligibility', 'school', 'division')->get();
        }

        $columns = ['name_of_examinee', 'campus_eligibility', 'school', 'division'];

        $length = $request->input('length');
        $column = $request->input('column'); //Index
        $dir = $request->input('dir');
        $searchValue = $request->input('search');

        $query = DB::table('passers')->select('id', 'name_of_examinee', 'campus_eligibility', 'school', 'division')->orderBy($columns[$column], $dir);

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('name_of_examinee', 'like', '%' . $searchValue . '%')
                    ->orWhere('school', 'like', '%' . $searchValue . '%')
                    ->orWhere('division', 'like', '%' . $searchValue . '%');
            });
        }

        $projects = $query->paginate($length);

        if (!empty($request->input('firstname')) && !empty($request->input('lastname')) && !empty($request->input('campus')) && !empty($request->input('school')) && !empty($request->input('division')))
            return ['data' => $projects, 'draw' => $request->input('draw')];

        return ['data' => $projects, 'draw' => $request->input('draw')];
    }


    public function addstudent(Request $request)
    {
        if (!empty($request->input('firstname')) && !empty($request->input('lastname')) && !empty($request->input('campus')) && !empty($request->input('school')) && !empty($request->input('division'))) {
            $lastname = strtoupper($request->input('lastname'));
            $firstname = strtoupper($request->input('firstname'));
            $fullName = "$lastname, $firstname";
            DB::table('passers')->insert(
                [
                    'name_of_examinee' => $fullName,
                    'campus_eligibility' => strtoupper($request->input('campus')),
                    'school' => strtoupper($request->input('school')),
                    'division' => strtoupper($request->input('division'))
                ]
            );

            return redirect('/');
        }


        return 'Please try again by completing to fill up the form!';
    }


    //school transactions
    public function schoolview(Request $request)
    {
        //return 'hello';
        if ($request->input('client')) {
            return DB::table('passers')->select(
                [
                    DB::raw('(@cnt := @cnt + 1) AS position'),
                    'school',
                    DB::raw('count(*) AS results'),
                ]
            )->crossJoin(DB::raw('CROSS JOIN (SELECT @cnt := 0) AS dummy'))
                ->groupby('school')
                ->orderby(DB::raw('count(*)'), 'asc')
                ->get();
        }

        $columns = ['position', 'campus_eligibility', 'results'];

        $length = $request->input('length');
        $column = $request->input('column'); //Index
        $dir = $request->input('dir');
        $searchValue = $request->input('search');

        $query = DB::table('passers')->select(
            [
                DB::raw('(@cnt := @cnt + 1) AS position'),
                'school',
                DB::raw('count(*) AS numofschool'),
            ]
        )->crossJoin(DB::raw('CROSS JOIN (SELECT @cnt := 0) AS dummy'))
            ->groupby('school')
            ->orderBy($columns[$column], $dir);

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('position', 'like', '%' . $searchValue . '%')
                    ->orWhere('school', 'like', '%' . $searchValue . '%')
                    ->orWhere('numofschool', 'like', '%' . $searchValue . '%');
            });
        }

        $projects = $query->paginate($length);


        return ['data' => $projects, 'draw' => $request->input('draw')];
    }

}

