<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectImage;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;

class ProjectImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $projectId = Project::where('id', $id)->first();
        return view('pages.projectImage.create', compact(['projectId']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $idProjek = $request->id_project;
        // dd($request->image);
      
        try { 

            foreach($request->file('image') as $img){
                $projectImage = new ProjectImage();
                $imageName = 'image-'.time().rand(1,1000).'.'.$img->extension();
                $img->move(public_path('image'), $imageName);
                $projectImage->image = $imageName;
                $projectImage->id_project = $request->id_project;
                
                $projectImage->save();
            }
        

        DB::commit();
        return redirect()->route('dashboard.project.show',[$idProjek]);
        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $projectImage = ProjectImage::where("id", $id)->first();
        return view("pages.projectImage.edit", compact("projectImage"));
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
        dd($request);
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
            $projectImage = ProjectImage::where("id", $id)->delete();
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

    public function getImageDatatable(Request $request)
    {
        return DataTables::of(ProjectImage::select("*"))
            ->make(true);
    }
}
