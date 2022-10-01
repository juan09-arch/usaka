<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\DocumentType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $document_type = DocumentType::all();
        $project = Project::all();
        return view('pages.project.index', compact(['document_type','project']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.project.create');
        // return view('pages.project.index', compact(['document_type','project']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = [];
        $result['code'] = 400;

        $validation = Validator::make($request->all(), Project::$rules, Project::$messages);

        if (!$validation->fails()) {
            $saveProject = Project::saveProject($request);

            if ($saveProject) {
                $result['message'] = "Berhasil menambahkan format dokumen!";
                return response()->json($result, 200);
            }
        }


        $result['message'] = "{$validation->errors()->first()}";
        return response()->json($result, 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::find($id)->first();

        return view('pages.project.show', compact(['project']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::where("id", $id)->first();
        return view("pages.project.edit", compact("project"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $result = [];
        $result['code'] = 400;

        $validation = Validator::make($request->all(), Project::$rules, Project::$messages);

        if (!$validation->fails()) {
            $saveProject = Project::updateProject($request, $id);

            if ($saveProject) {
                $result['message'] = "Berhasil mengupdate project!";
                return response()->json($result, 200);
            }
        }

        $result['message'] = "{$validation->errors()->first()}";
        return response()->json($result, 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $project = Project::where("id", $id)->delete();
            // dd($project);
            // $project->delete();

            DB::commit();
            $result['message'] = "Berhasil menghapus project!";
            return response()->json($result, 200);
        } catch (Exception $e) {
            DB::rollback();
            $result['message'] = "Gagal menghapus project!";
            return response()->json($result, 500);
        }
    }
}
