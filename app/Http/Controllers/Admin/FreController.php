<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\FreCreateRequest;
use App\Http\Requests\FreUpdateRequest;
use App\Fre;

class FreController extends Controller
{


    protected $fields = [
        'fre' => '',
        'dm' => '',
        'remark' => '',
        'xs' => '',
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fres = Fre::all();
        return view('admin.fre.index')->withFres($fres);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }

        return view('admin.fre.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FreCreateRequest $request)
    {
        $fre = new Fre();
        foreach (array_keys($this->fields) as $field) {
            $fre->$field = $request->get($field);
        }
        $fre->save();

        return redirect('/admin/fre')
                        ->withSuccess("频道 '$fre->fre' 新建完成.");
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fre = Fre::findOrFail($id);
        $data = ['id' => $id];
        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $fre->$field);
        }

        return view('admin.fre.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FreUpdateRequest $request, $id)
    {
        $fre = Fre::findOrFail($id);

        foreach (array_keys($this->fields) as $field) {
            $fre->$field = $request->get($field);
        }
        $fre->save();

        return redirect("/admin/fre/$id/edit")
                        ->withSuccess("频道更新成功.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fre = Fre::findOrFail($id);
        $fre->delete();

        return redirect('/admin/fre')
                        ->withSuccess("频道 '$fre->fre' 删除成功.");
    }
}
