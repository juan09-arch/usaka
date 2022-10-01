<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Project extends Model
{

    use HasFactory;

    protected $table = 'project';

    protected $guarded = "id";

    

    public static $rules = [
        'title' => 'required',
        'description' => 'required',
    ];

    public static $messages = [
        'title.required' => 'Title project tidak boleh kosong!',
        'description.required' => 'description project tidak boleh kosong!',
    ];

    public static function saveProject($request)
    {
        try {
            // dd($request->all());
            DB::beginTransaction();

            $project = new self;
            $project->title = $request->title;
            $project->description = $request->description;
            $project->save();

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public static function updateProject($request, $id)
{
    try {

        DB::beginTransaction();
        $project = self::where("id", $id)->first();
        $project->title = $request->title;
        $project->description = $request->description;
        $project->save();

        DB::commit();
        // dd(DB::commit());
        return true;
    } catch (Exception $e) {
        DB::rollBack();
        dd($e);
    }


}
    public function projectImage() {
        return $this->hasMany('App\Models\ProjectImage', 'id_project', 'id');
    }

}