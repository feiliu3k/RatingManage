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
use App\ADPlayList;
use App\StatList;

use Excel;
use Carbon\Carbon;

class StatListController extends Controller
{

    protected $_searchCondition = [
        'b_date'=>'',
        'e_date'=>'',
        'f_id'=>0,
        'b_time'=>'00:00',
        'e_time'=>'40:00',
        'number'=>'',
        'content'=>'',
        'rt_id'=>0,
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
        $ratingTypes= RatingType::all();


        $searchCondition=$this->_searchCondition;
        $searchCondition['b_date'] =Carbon::now(-8)->toDateString();
        $searchCondition['e_date'] =Carbon::now(-1)->toDateString();

        $statlists = StatList::with('rating','rating.ratingType','rating.fre','adplaylist','adplaylist.fre')->orderBy('id', 'desc')->paginate(config('rating.posts_per_page'));

        return view('admin.statlist.index',compact('statlists', 'fres', 'ratingTypes', 'searchCondition', 'searchflag'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $statlist = StatList::findOrFail($id);
        $statlist->delete();

        return redirect('/admin/statlist')
                        ->withSuccess("收视率统计记录删除成功.");
    }

    /**
     * 上传文件
     */
    public function fileExplorer(Request $request)
    {
        $folder = 'statlist';
        $data = $this->manager->folderInfo($folder);
        return view('admin.upload.index', $data);
    }

    /**
     * 按条件搜索
     */
    public function search(Request $request)
    {
        $searchflag=true;
        $fres= Fre::all();
        $ratingTypes= RatingType::all();

        $searchCondition=$this->_searchCondition;

        foreach (array_keys($this->_searchCondition) as $field) {
            $searchCondition[$field] = $request->get($field);
        }


        $statlists = StatList::join('adplaylists','adplaylists.id', '=', 'statlists.a_id')->whereBetween('adplaylists.d_date', [$searchCondition['b_date'], $searchCondition['e_date']])
                            ->where('adplaylists.b_time','>=',$searchCondition['b_time'])
                            ->where('adplaylists.b_time','<=',$searchCondition['e_time']);


        if (($searchCondition['f_id']!=0)){
            $statlists->where('adplaylists.f_id',$searchCondition['f_id']);
        }

        if (trim($searchCondition['content'])){
            $statlists->where('adplaylists.content','like','%'.trim($searchCondition['content'].'%'));
        }

        if (trim($searchCondition['number'])){
            $statlists->where('adplaylists.number','like','%'.trim($searchCondition['number']).'%');
        }

        $statlists = $statlists->join('ratings','ratings.id', '=', 'statlists.r_id');

        if (($searchCondition['rt_id']!=0)){
            $statlists->where('ratings.rt_id',$searchCondition['rt_id']);
        }



        $statlists=$statlists->orderBy('adplaylists.d_date', 'desc')->orderBy('adplaylists.b_time','desc')
                          ->paginate(config('rating.posts_per_page'));
        //dd($statlists);
        return view('admin.statlist.index',compact('statlists', 'fres', 'ratingTypes', 'searchCondition', 'searchflag'));
    }

    /**
     * 按条件删除
     */
    public function deleteByCondition(Request $request)
    {
        $searchflag=true;
        $fres= Fre::all();
        $ratingTypes= RatingType::all();

        $searchCondition=$this->_searchCondition;

        foreach (array_keys($this->_searchCondition) as $field) {
            $searchCondition[$field] = $request->get($field);
        }


        $statlists = StatList::join('adplaylists','adplaylists.id', '=', 'statlists.a_id')->whereBetween('adplaylists.d_date', [$searchCondition['b_date'], $searchCondition['e_date']])
                            ->where('adplaylists.b_time','>=',$searchCondition['b_time'])
                            ->where('adplaylists.b_time','<=',$searchCondition['e_time']);


        if (($searchCondition['f_id']!=0)){
            $statlists->where('adplaylists.f_id',$searchCondition['f_id']);
        }

        if (trim($searchCondition['content'])){
            $statlists->where('adplaylists.content','like','%'.trim($searchCondition['content'].'%'));
        }

        if (trim($searchCondition['number'])){
            $statlists->where('adplaylists.number','like','%'.trim($searchCondition['number']).'%');
        }

        $statlists = $statlists->join('ratings','ratings.id', '=', 'statlists.r_id');

        if (($searchCondition['rt_id']!=0)){
            $statlists->where('ratings.rt_id',$searchCondition['rt_id']);
        }

        $statlists=$statlists->delete();
        return redirect('/admin/statlist')
                        ->withSuccess("收视率统计记录删除成功.");

    }

    /**
     * 按条件统计
     */
    public function stat(Request $request)
    {
        $searchflag=true;

        $searchCondition=$this->_searchCondition;

        foreach (array_keys($this->_searchCondition) as $field) {
            $searchCondition[$field] = $request->get($field);
        }


        $statlists = StatList::whereBetween('d_date', [$searchCondition['b_date'], $searchCondition['e_date']])
                            ->where('b_time','>=',$searchCondition['b_time'])
                            ->where('b_time','<=',$searchCondition['e_time']);

        if (($searchCondition['f_id']!=0)){

            $statlists->where('f_id',$searchCondition['f_id']);

        }

       if (($searchCondition['rt_id']!=0)){

            $statlists->where('rt_id',$searchCondition['rt_id']);

        }

        if (trim($searchCondition['content'])){
            $statlists->where('content','like','%'.trim($searchCondition['content'].'%'));

        }

        if (trim($searchCondition['number'])){
            $statlists->where('number','like','%'.trim($searchCondition['number']).'%');

        }


        $statlists=$statlists->orderBy('d_data', 'desc')->orderBy('b_time','desc')
                                 ->paginate(config('rating.posts_per_page'));

        return view('admin.statlist.index',compact('statlists', 'searchCondition', 'searchflag'));
    }

    /**
     * 下载文件
     */
    public function download(Request $request){
        return response()->download(realpath(base_path('public/uploads/statlist/')).'/'.$request->statlist_filename,
            $request->statlist_filename);
    }

}
