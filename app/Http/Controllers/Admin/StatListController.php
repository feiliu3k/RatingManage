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
        'rt_id'=>1,
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


        $searchCondition=$this->_searchCondition;
        $searchCondition['b_date'] =Carbon::now(-8)->toDateString();
        $searchCondition['e_date'] =Carbon::now(-1)->toDateString();

        $statlist = StatList::with('rating', 'adplaylist')->orderBy('id', 'desc')->get();
        dd($statlist);
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
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * 按条件搜索
     */
    public function search(Request $request)
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
}
