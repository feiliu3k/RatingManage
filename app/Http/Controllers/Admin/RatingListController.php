<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Services\UploadsManager;
use App\Http\Requests\UploadFileRequest;
use App\Http\Requests\UploadNewFolderRequest;
use Illuminate\Support\Facades\File;

use App\Rating;
use App\RatingType;
use App\Fre;
use Carbon\Carbon;

class RatingListController extends Controller
{

    protected $fieldList = [
        's_date'=>'',
        'f_id'=>1,
        'b_time'=>'00:00',
        'e_time'=>'00:00',
        'rt_id'=>1,
        'a_rating'=>0.0
    ];

    protected $manager;

    public function __construct(UploadsManager $manager)
    {
        $this->manager = $manager;

    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fres= Fre::all();
        $ratingTypes= RatingType::all();

        $fields=$this->fieldList;
        $fields['s_date'] =Carbon::now()->addHour()->toDateString();
        $ratings = Rating::orderBy('id', 'desc')
                ->paginate(config('rating.posts_per_page'));
        return view('admin.ratinglist.index',compact('ratings', 'fres', 'ratingTypes','fields'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rating = new Rating();
        foreach (array_keys($this->fieldList) as $field) {
            $rating->$field = $request->get($field);
        }
        $rating->save();

        return redirect('/admin/ratinglist')
                        ->withSuccess("收视率添加完成.");
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
        $fres= Fre::all();
        $ratingTypes= RatingType::all();

        $rating = Rating::findOrFail($id);
        $fields = ['id' => $id];
        foreach (array_keys($this->fieldList) as $field) {
            $fields[$field] = old($field, $rating->$field);
        }

        return view('admin.ratinglist.edit', compact( 'fres', 'ratingTypes','fields'));

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
        $rating = Rating::findOrFail($id);

        foreach (array_keys($this->fieldList) as $field) {
            $rating->$field = $request->get($field);
        }
        $rating->save();

        return redirect("/admin/ratinglist")
                        ->withSuccess("收视率更新成功.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rating = Rating::findOrFail($id);
        $rating->delete();

        return redirect('/admin/ratinglist')
                        ->withSuccess("收视率删除成功.");
    }

    /**
     * 上传文件
     */
    public function fileExplorer(Request $request)
    {
        $folder = 'rating';
        dd($request);
        $data = $this->manager->folderInfo($folder);
        return view('admin.upload.index', $data);
    }

    /**
     * 上传文件
     */
    public function upload(UploadFileRequest $request)
    {
        $file = $_FILES['file'];
        $fileName = $request->get('file_name');
        $fileName = $fileName ?: $file['name'];
        $path = str_finish($request->get('folder'), '/') . $fileName;
        $content = File::get($file['tmp_name']);

        $result = $this->manager->saveFile($path, $content);

        if ($result === true) {
            return redirect()
                    ->back()
                    ->withSuccess("文件 '$fileName' 上传成功.");
        }

        $error = $result ? : "上传文件文件出错.";
        return redirect()
                ->back()
                ->withErrors([$error]);
    }

    /**
     * 导入收视率
     */
    public function import(Request $request)
    {

    }

    /**
     * 按条件搜索
     */
    public function search(Request $request)
    {

    }

    /**
     * 按条件搜索
     */
    public function deleteByCondition(Request $request)
    {

    }
}
