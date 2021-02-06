<?php

namespace App\Http\Controllers;

use App\CashflowMember;
use App\CashflowProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CashflowProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $project = CashflowProject::where('user_id', Auth::id())->paginate(15);
            return api_response(200, $project, "List of projects");
        }
        return view('cashflow.index');
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if(empty($request->name)){
            return api_response(201, [], "Please add project name");
        }
        $project = CashflowProject::create([
           'title' => $request->name,
           'detail' => $request->detail
        ]);
        CashflowMember::firstOrCreate([
           'project_id'=> $project->id,
           'user_id'=> Auth::id()
        ]);
        return api_response(200, $project, "Project successfully saved");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CashflowProject  $cashflowProject
     * @return \Illuminate\Http\Response
     */
    public function show(CashflowProject $cashflowProject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CashflowProject  $cashflowProject
     * @return \Illuminate\Http\Response
     */
    public function edit(CashflowProject $cashflowProject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CashflowProject  $cashflowProject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CashflowProject $cashflowProject)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CashflowProject  $cashflowProject
     * @return \Illuminate\Http\Response
     */
    public function destroy(CashflowProject $cashflowProject)
    {
        //
    }
}
