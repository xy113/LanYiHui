<?php

namespace App\Http\Controllers\Minapp;

use App\Models\Collection;
use App\Models\Company;
use App\Models\Job;
use App\Models\PostItem;

class CollectionController extends BaseController
{
    public function add()
    {
        $data_id = $this->request->input('data_id');
        $data_type = $this->request->input('data_type');

        if ($data_type === 'job') {
            $job = Job::where('job_id', $data_id)->first();
            $company = Company::where('company_id', $job->company_id)->first();
            Collection::insert([
                'uid'=>$this->uid,
                'data_id'=>$data_id,
                'data_type'=>$data_type,
                'title'=>$job->title,
                'image'=>$company->company_logo,
                'created_at'=>time()
            ]);
        }

        if ($data_type === 'company') {
            $company = Company::where('company_id', $data_id)->first();
            Collection::insert([
                'uid'=>$this->uid,
                'data_id'=>$data_id,
                'data_type'=>$data_type,
                'title'=>$company->company_name,
                'image'=>$company->company_logo,
                'created_at'=>time()
            ]);
        }

        if ($data_type === 'article') {
            $postItem = PostItem::where('aid', $data_id)->first();
            Collection::insert([
                'uid'=>$this->uid,
                'data_id'=>$data_id,
                'data_type'=>$data_type,
                'title'=>$postItem->title,
                'image'=>$postItem->image,
                'created_at'=>time()
            ]);
        }

        return ajaxReturn();
    }


    public function get()
    {

    }

    public function batchget()
    {
        $data_type = $this->request->input('data_type');
        $offset = intval($this->request->input('offset'));
        $count = intval($this->request->input('count'));
        !$count && $count = 20;

        $condition = [
            'uid'=>$this->uid,
            'data_type'=>$data_type
        ];

        $items = Collection::where($condition)->offset($offset)->limit($count)->orderByDesc('id')
            ->get()->map(function ($item) {
                $item->image = image_url($item->image);
                return $item;
            });

        return ajaxReturn(['items'=>$items]);
    }
}
