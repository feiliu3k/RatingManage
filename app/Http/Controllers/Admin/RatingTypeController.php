<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\RatingTypeCreateRequest;
use App\Http\Requests\RatingTypeUpdateRequest;
use App\RatingType;


class RatingTypeController extends Controller
{
    protected $fields = [
        'rating_type' => '',
        'remark' => '',
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ratingTypes= RatingType::all();
        return view('admin.ratingType.index',compact('ratingTypes'));
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

        return view('admin.ratingtype.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ratingType = new RatingType();
        foreach (array_keys($this->fields) as $field) {
            $ratingType->$field = $request->get($field);
        }
        $ratingType->save();

        return redirect('/admin/ratingtype')
                        ->withSuccess("收视率类型 '$ratingType->rating_type' 新建完成.");
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ratingType = RatingType::findOrFail($id);
        $data = ['id' => $id];
        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $ratingType->$field);
        }

        return view('admin.ratingtype.edit', $data);
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
        $ratingType = RatingType::findOrFail($id);

        foreach (array_keys($this->fields) as $field) {
            $ratingType->$field = $request->get($field);
        }
        $ratingType->save();

        return redirect("/admin/ratingtype/$id/edit")
                        ->withSuccess("收视率类型更新成功.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ratingType = RatingType::findOrFail($id);
        $ratingType->delete();

        return redirect('/admin/ratingtype')
                        ->withSuccess("收视率类型 '$ratingType->rating_type' 删除成功.");
    }
}
