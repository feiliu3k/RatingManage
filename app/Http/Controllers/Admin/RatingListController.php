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
        $data = $this->manager->folderInfo($folder);
        return view('admin.upload.index', $data);
    }


    /**
     * 导入收视率
     */
    public function import(Request $request)
    {
        $filename=$request->get('file');
        $rt_id=4;
        $filePath = 'public/uploads/'.$filename;
        Excel::selectSheetsByIndex(0)->load($filePath, function($reader) {
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
                    $rating->rt_id=1;
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

    }

    /**
     * 按条件搜索
     */
    public function deleteByCondition(Request $request)
    {

    }
}
