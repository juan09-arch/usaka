<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;
class TeamController extends Controller
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
        $team = Team::all();
        return view('pages.team.index', compact(['team']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.team.create');
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

        $validation = Validator::make($request->all(), Team::$rules, Team::$messages);

        if (!$validation->fails()) {
            try {
                // dd($request->all());
                DB::beginTransaction();
    
                $team = new Team();
                $team->name = $request->name;
                $team->role = $request->role;
                $team->description = $request->description;
    
                if ($image = $request->file('image')) {
                    $destinationPath = 'image/';
                    $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                    $image->move($destinationPath, $profileImage);
                    $team->image = "$profileImage";
                }
    
                $team->save(); 
    
                DB::commit();
                return redirect()->route('dashboard.team.index');
            } catch (Exception $e) {
                DB::rollBack();
            }
        }
        // $result['message'] = "{$validation->errors()->first()}";
        // return response()->json($result, 400);
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
        $team = Team::where("id", $id)->first();
        return view("pages.team.edit", compact("team"));
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
        
        dd($request);
     
        $validation = Validator::make($request->all(), Team::$rules, Team::$messages);

        if (!$validation->fails()) {
            try {

                $team= Team::find($id);
               

                $dataTeam = [
                    'name' => $request->name,
                    'role' => $request->role,
                    'description'=>$request->description,
                ];
    
                if ($image = $request->file('image') ) {
                    $destinationPath = 'image/';
                    $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                    $image->move($destinationPath, $profileImage);
                    $dataTeam['image'] = "$profileImage";
                }else{
                    unset($dataTeam['image']);
                }
                dd($dataTeam);
                $team->update($dataTeam);
    
            return redirect()->route('dashboard.team.index');
    
            } catch (Exception $e) {
                DB::rollback();
                dd($e);
    
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team, $id)
    {
        try {
            $team = Team::where("id", $id)->delete();
            // dd($team);
            // $team->delete();

            DB::commit();
            $result['message'] = "Berhasil menghapus team!";
            return response()->json($result, 200);
        } catch (Exception $e) {
            DB::rollback();
            $result['message'] = "Gagal menghapus team!";
            return response()->json($result, 500);
        }
    }

    public function getTeamDatatable(Request $request)
    {
        return DataTables::of(Team::select("*"))
            ->make(true);
    }
}
