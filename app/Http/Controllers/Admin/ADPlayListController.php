<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Services\UploadsManager;
use App\Http\Requests\UploadFileRequest;
use App\Http\Requests\UploadNewFolderRequest;
use Illuminate\Support\Facades\File;

use App\ADPlayList;
use App\RatingType;
use App\Fre;

use Excel;
use Carbon\Carbon;

class ADPlayListController extends Controller
{

    protected $fieldList = [
        'd_date'=>'',
        'b_time'=>'08:30',
        'f_id'=>1,
        'number'=>'',
        'len'=>'',
        'content'=>'',
        'belt'=>'',
        'ht_len'=>'',
    ];

    protected $_searchCondition = [
        'b_date'=>'',
        'e_date'=>'',
        'f_id'=>0,
        'b_time'=>'00:00',
        'e_time'=>'40:00',
        'number'=>'',
        'content'=>'',
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
        $searchflag=false;
        $fres= Fre::all();

        $fields=$this->fieldList;
        $fields['d_date'] =Carbon::now()->toDateString();
        $searchCondition=$this->_searchCondition;
        $searchCondition['b_date'] =Carbon::now(-8)->toDateString();
        $searchCondition['e_date'] =Carbon::now(-1)->toDateString();
        $adplaylists = ADPlayList::orderBy('d_date', 'desc')->orderBy('b_time', 'desc')
                ->paginate(config('rating.posts_per_page'));
        return view('admin.adplaylist.index',compact('adplaylists', 'fres', 'fields','searchCondition', 'searchflag'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $adplaylist = new ADPlayList();
        foreach (array_keys($this->fieldList) as $field) {
            $adplaylist->$field = $request->get($field);
        }
        $adplaylist->save();

        return redirect('/admin/adplaylist')
                        ->withSuccess("广告播出记录添加完成.");
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


        $adplaylist = ADPlayList::findOrFail($id);
        $fields = ['id' => $id];
        foreach (array_keys($this->fieldList) as $field) {
            $fields[$field] = old($field, $adplaylist->$field);
        }

        return view('admin.adplaylist.edit', compact( 'fres', 'fields'));
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
        $adplaylist = ADPlayList::findOrFail($id);

        foreach (array_keys($this->fieldList) as $field) {
            $adplaylist->$field = $request->get($field);
        }
        $adplaylist->save();

        return redirect("/admin/adplaylist")
                        ->withSuccess("广告播出记录更新成功.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $adplaylist = ADPlayList::findOrFail($id);
        $adplaylist->delete();

        return redirect('/admin/adplaylist')
                        ->withSuccess("广告播出记录删除成功.");
    }


    /**
     * 上传文件
     */
    public function fileExplorer(Request $request)
    {
        $folder = 'adplaylist';
        $data = $this->manager->folderInfo($folder);
        return view('admin.upload.index', $data);
    }


    /**
     * 导入广告播出记录
     */
    public function import(Request $request)
    {
        $filename=$request->get('adplaylist_filename');


        $filePath = 'public/uploads/'.$filename;

        Excel::selectSheetsByIndex(0)->load($filePath, function($reader) {
            $reader->noHeading();
            $data = $reader->toArray();
            $adplaylist_datas=array_slice($data,1);


            foreach ($adplaylist_datas as $adplaylist_data) {

                    $fre=Fre::where('fre',$adplaylist_data[3])->first();
                    $adplaylist=new ADPlayList;
                    $adplaylist->d_date=$adplaylist_data[1];
                    $adplaylist_time = explode('\'',$adplaylist_data[2]);

                    $adplaylist->b_time=$adplaylist_time[0].':'.$adplaylist_time[1];
                    $adplaylist->f_id=$fre->id;
                    $adplaylist->number=$adplaylist_data[4];
                    $adplaylist->len=$adplaylist_data[5];
                    $adplaylist->content=$adplaylist_data[6];
                    $adplaylist->belt=$adplaylist_data[7];
                    $adplaylist->ht_len=$adplaylist_data[8];

                    $adplaylist->save();
            }



        });
        return redirect('/admin/adplaylist')
                        ->withSuccess("收视率导入成功.");
    }

    /**
     * 按条件搜索
     */
    public function search(Request $request)
    {
        $searchflag=true;
        $fres= Fre::all();


        $fields=$this->fieldList;
        $fields['s_date'] =Carbon::now()->addHour()->toDateString();

        $searchCondition=$this->_searchCondition;

        foreach (array_keys($this->_searchCondition) as $field) {
            $searchCondition[$field] = $request->get($field);
        }


        $adplaylists = ADPlayList::whereBetween('d_date', [$searchCondition['b_date'], $searchCondition['e_date']])
                            ->where('b_time','>=',$searchCondition['b_time'])
                            ->where('b_time','<=',$searchCondition['e_time']);

        if (($searchCondition['f_id']!=0)){

            $adplaylists->where('f_id',$searchCondition['f_id']);

        }

        if (trim($searchCondition['content'])){
            $adplaylists->where('content','like','%'.trim($searchCondition['content'].'%'));

        }

        if (trim($searchCondition['number'])){
            $adplaylists->where('number','like','%'.trim($searchCondition['number']).'%');

        }


        $adplaylists=$adplaylists->orderBy('id', 'desc')
                                 ->paginate(config('rating.posts_per_page'));

        return view('admin.adplaylist.index',compact('adplaylists', 'fres','fields','searchCondition', 'searchflag'));
    }


        /**
     * 按条件删除
     */
    public function deleteByCondition(Request $request)
    {

        foreach (array_keys($this->_searchCondition) as $field) {
            $searchCondition[$field] = $request->get($field);
        }



        $adplaylists = ADPlayList::whereBetween('d_date', [$searchCondition['b_date'], $searchCondition['e_date']])
                            ->where('b_time','>=',$searchCondition['b_time'])
                            ->where('b_time','<=',$searchCondition['e_time']);

        if (($searchCondition['f_id']!=0)){

            $adplaylists->where('f_id',$searchCondition['f_id']);

        }

        if (trim($searchCondition['content'])){
            $adplaylists->where('content','like','%'.trim($searchCondition['content'].'%'));

        }

        if (trim($searchCondition['number'])){
            $adplaylists->where('number','like','%'.trim($searchCondition['number']).'%');

        }


        $adplaylists=$adplaylists->delete();

        return redirect('/admin/adplaylist')
                        ->withSuccess("广告播出记录删除成功.");

    }

}
