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

use Excel;
use Carbon\Carbon;

class RatingListController extends Controller
{

    protected $fieldList = [
        's_date'=>'',
        'f_id'=>1,
        'b_time'=>'00:00',
        'e_time'=>'40:00',
        'rt_id'=>1,
        'a_rating'=>0.0
    ];

    protected $_searchCondition = [
        'b_date'=>'',
        'e_date'=>'',
        'f_id'=>0,
        'b_time'=>'00:00',
        'e_time'=>'40:00',
        'rt_id'=>0
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

        $fields=$this->fieldList;
        $fields['s_date'] =Carbon::now()->addHour()->toDateString();
        $searchCondition=$this->_searchCondition;
        $searchCondition['b_date'] =Carbon::now()->toDateString();
        $searchCondition['e_date'] =Carbon::now()->addDay(7)->toDateString();
        $ratings = Rating::orderBy('s_date', 'desc')->orderBy('b_time', 'desc')
                ->paginate(config('rating.posts_per_page'));
        return view('admin.ratinglist.index',compact('ratings', 'fres', 'ratingTypes','fields','searchCondition', 'searchflag'));
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
        $ratingTypes= RatingType::all();
        $data = $this->manager->folderInfo($folder);
        $data['ratingTypes']=$ratingTypes;
        return view('admin.upload.index', $data);
    }


    /**
     * 导入收视率
     */
    public function import(Request $request)
    {
        $filename=$request->get('rating_filename');
        $rt_id=$request->get('rt_id');

        $filePath = 'public/uploads/'.$filename;

        Excel::selectSheetsByIndex(0)->load($filePath, function($reader) use($rt_id){
            $reader->noHeading();
            $data = $reader->toArray();

            $rating_dates=array_slice($data[0],1);

            $rating_fres=array_slice($data[1],1);
            while (list($key, $val) = each($rating_fres)){
                if (strpos($val,'新闻综合频道')){
                    $rating_fres[$key]='汕视一套';
                }
                else if (strpos($val,'生活经济频道')){
                    $rating_fres[$key]='汕视二套';
                }
                else if (strpos($val,'影视文艺频道')){
                    $rating_fres[$key]='汕视三套';
                }
                else if (strpos($val,'翠台')){
                    $rating_fres[$key]='翡翠';
                }
                else if (strpos($val,'港台')){
                    $rating_fres[$key]='本港';
                }
                else if (strpos($val,'凰卫')){
                    $rating_fres[$key]='凤凰';
                }
            }

            $rating_ratings=array_slice($data,3);
            foreach ($rating_ratings as $rating_rating) {
                $i=0;
                $aratings=array_slice($rating_rating,1);
                foreach ($aratings as $arating) {
                    $rating_date=$rating_dates[$i];
                    $fre=Fre::where('fre',$rating_fres[$i])->first();
                    $rating_time = explode('-',$rating_rating[1]);
                    $rating_btime=trim($rating_time[0]);
                    $rating_etime=trim($rating_time[1]);
                    $rating=new Rating;
                    $rating->s_date=$rating_date;
                    $rating->f_id=$fre->id;
                    $rating->b_time=$rating_btime;
                    $rating->e_time=$rating_etime;
                    $rating->rt_id=$rt_id;
                    $rating->a_rating=$arating;
                    $rating->save();
                    $i++;
                }

            }

        });
        return redirect('/admin/ratinglist')
                        ->withSuccess("收视率导入成功.");
    }

    /**
     * 按条件搜索
     */
    public function search(Request $request)
    {
        $searchflag=true;
        $fres= Fre::all();
        $ratingTypes= RatingType::all();

        $fields=$this->fieldList;
        $fields['s_date'] =Carbon::now()->addHour()->toDateString();
        $searchCondition=$this->_searchCondition;

        foreach (array_keys($this->_searchCondition) as $field) {
            $searchCondition[$field] = $request->get($field);
        }

        $ratings=null;

        if (($searchCondition['rt_id']==0) and ($searchCondition['f_id']==0)){
            $ratings = Rating::whereBetween('s_date', [$searchCondition['b_date'], $searchCondition['e_date']])
                            ->where('b_time','>=',$searchCondition['b_time'])
                            ->where('e_time','<=',$searchCondition['e_time'])
                            ->orderBy('id', 'desc')
                            ->paginate(config('rating.posts_per_page'));
        } else if ($searchCondition['rt_id']==0) {
            $ratings = Rating::whereBetween('s_date', [$searchCondition['b_date'], $searchCondition['e_date']])
                            ->where('b_time','>=',$searchCondition['b_time'])
                            ->where('e_time','<=',$searchCondition['e_time'])
                            ->where('f_id',$searchCondition['f_id'])
                            ->orderBy('id', 'desc')
                            ->paginate(config('rating.posts_per_page'));
        } else if ($searchCondition['f_id']==0){
            $ratings = Rating::whereBetween('s_date', [$searchCondition['b_date'], $searchCondition['e_date']])
                            ->where('b_time','>=',$searchCondition['b_time'])
                            ->where('e_time','<=',$searchCondition['e_time'])
                            ->where('rt_id',$searchCondition['rt_id'])
                            ->orderBy('id', 'desc')
                            ->paginate(config('rating.posts_per_page'));
        } else {
            $ratings = Rating::whereBetween('s_date', [$searchCondition['b_date'], $searchCondition['e_date']])
                            ->where('b_time','>=',$searchCondition['b_time'])
                            ->where('e_time','<=',$searchCondition['e_time'])
                            ->where('rt_id',$searchCondition['rt_id'])
                            ->where('f_id',$searchCondition['f_id'])
                            ->orderBy('id', 'desc')
                            ->paginate(config('rating.posts_per_page'));
        }

        return view('admin.ratinglist.index',compact('ratings', 'fres', 'ratingTypes','fields','searchCondition', 'searchflag'));
    }

    /**
     * 按条件删除
     */
    public function deleteByCondition(Request $request)
    {

        foreach (array_keys($this->_searchCondition) as $field) {
            $searchCondition[$field] = $request->get($field);
        }

        $ratings=null;

        if (($searchCondition['rt_id']==0) and ($searchCondition['f_id']==0)){
            $ratings = Rating::whereBetween('s_date', [$searchCondition['b_date'], $searchCondition['e_date']])
                            ->where('b_time','>=',$searchCondition['b_time'])
                            ->where('e_time','<=',$searchCondition['e_time'])
                            ->delete();
        } else if ($searchCondition['rt_id']==0) {
            $ratings = Rating::whereBetween('s_date', [$searchCondition['b_date'], $searchCondition['e_date']])
                            ->where('b_time','>=',$searchCondition['b_time'])
                            ->where('e_time','<=',$searchCondition['e_time'])
                            ->where('f_id',$searchCondition['f_id'])
                            ->delete();
        } else if ($searchCondition['f_id']==0){
            $ratings = Rating::whereBetween('s_date', [$searchCondition['b_date'], $searchCondition['e_date']])
                            ->where('b_time','>=',$searchCondition['b_time'])
                            ->where('e_time','<=',$searchCondition['e_time'])
                            ->where('rt_id',$searchCondition['rt_id'])
                            ->delete();
        } else {
            $ratings = Rating::whereBetween('s_date', [$searchCondition['b_date'], $searchCondition['e_date']])
                            ->where('b_time','>=',$searchCondition['b_time'])
                            ->where('e_time','<=',$searchCondition['e_time'])
                            ->where('rt_id',$searchCondition['rt_id'])
                            ->where('f_id',$searchCondition['f_id'])
                            ->delete();
        }



        return redirect('/admin/ratinglist')
                        ->withSuccess("收视率删除成功.");

    }
}
