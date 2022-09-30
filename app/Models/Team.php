<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Team extends Model
{
    use HasFactory;

    protected $table = 'team';

    protected $guarded = "id";

    public static $rules = [
        'name' => 'required',
        'role' => 'required',
        'description' => 'required',
    ];

    public static $messages = [
        'name.required' => 'Nama tidak boleh kosong!',
        'role.required' => 'Role tidak boleh kosong!',
        'description.required' => 'Keterangan tidak boleh kosong!',
    ];

    public static function saveTeam($request)
    {
        try {
            // dd($request->all());
            DB::beginTransaction();

            $team = new self;
            $team->name = $request->name;
            $team->role = $request->role;
            $team->description = $request->description;
            $team->save();

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }


}

public static function updateTeam($request, $id)
{
    // dd($request);
    try {

        DB::beginTransaction();
        $team = self::where("id", $id)->first();
        $team->name = $request->name;
        $team->role = $request->role;
        $team->description = $request->description;
        $team->save();

        DB::commit();
        // dd(DB::commit());
        return true;
    } catch (Exception $e) {
        DB::rollBack();
        dd($e);
    }
}

}