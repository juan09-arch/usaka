<?php

namespace App\Http\Controllers;

use App\Models\DocumentArchive;
use App\Models\DocumentType;
use App\Models\InputFormat;
use App\Models\InputOption;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DocumentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.document_type.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.document_type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $result = [];
        $result['code'] = 400;

        $validation = Validator::make($request->all(), DocumentType::$rules, DocumentType::$messages);

        if (!$validation->fails()) {
            $saveDocumentType = DocumentType::saveDocumentType($request);

            if ($saveDocumentType) {
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
        $documentType = DocumentType::with(["input_format", "input_format.input_option"])->where("id", $id)->first();
        return view("pages.document_type.edit", compact("documentType"));
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

        $validation = Validator::make($request->all(), DocumentType::$rules, DocumentType::$messages);

        if (!$validation->fails()) {
            $saveDocumentType = DocumentType::updateDocumentType($request, $id);

            if ($saveDocumentType) {
                $result['message'] = "Berhasil mengupdate format dokumen!";
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
    public function destroy(DocumentType $documentType)
    {
        try {
            $isDocumentTypeEmpty = DocumentArchive::where('document_type_id', $documentType->id)->exists();
            if($isDocumentTypeEmpty){
                DB::rollback();
                $result['message'] = "Dokumen ini tidak kosong. Gagal menghapus dokumen!";
                return response()->json($result, 500);
            }
            DB::beginTransaction();
            foreach (InputFormat::where("document_type_id", $documentType->id)->get() as $eachInputFormat) {
                InputOption::where("input_format_id", $eachInputFormat->id)->delete();
                $eachInputFormat->delete();
            }
            $documentType->delete();

            DB::commit();
            $result['message'] = "Berhasil menghapus dokumen!";
            return response()->json($result, 200);
        } catch (Exception $e) {
            DB::rollback();
            $result['message'] = "Gagal menghapus dokumen!";
            return response()->json($result, 500);
        }
    }

    public function getDocumentTypeDatatable(Request $request)
    {
        return DataTables::of(DocumentType::select("*"))
            ->make(true);
    }
}
