<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExcelStoreRequest;
use App\Http\Requests\ExcelUpdateRequest;
use App\Http\Resources\ExcelResource;
use App\Models\Excel;
use Carbon\Carbon;
use DB;
use Excel as ExcelExport;
use Illuminate\Http\Request;

class ExcelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ExcelResource::collection(Excel::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExcelStoreRequest $request)
    {
        return DB::transaction(function () use (&$request) {
            $inputs = collect($request->validated()['data']);
            $inputs = $inputs->map(function ($item, $key) {
                $item['fecha'] = date_create_from_format('d/m/Y h:i', $item['fecha']);
                return $item;
            });

            Excel::insert($inputs->toArray());

            return response()->json([], 201);
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExcelUpdateRequest $request, $id)
    {
        return DB::transaction(function () use (&$request, &$id) {
            $excel = Excel::findOrFail($id);
            $excel->update($request->validated());

            return response()->json([], 200);
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return DB::transaction(function () use (&$id) {
            $excel = Excel::findOrFail($id);
            $excel->delete();

            return response()->json([], 204);
        });
    }

    /**
     * Export all resources in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function export()
    {
        ExcelExport::create('Reporte ABC - Exportado el: ' . Carbon::now(), function ($excel) {
            $excel->sheet('Sheet', function ($sheet) {
                $sheet->fromArray(Excel::all(['albaran', 'destinatario', 'direccion', 'poblacion', 'cp', 'provincia', 'telefono', 'observaciones', 'fecha'])->toArray());
            });
        })->download('xls');
    }
}
