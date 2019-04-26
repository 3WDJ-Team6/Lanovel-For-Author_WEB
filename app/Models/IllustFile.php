<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IllustFile extends Model
{
    protected $table = 'illust_files';
    protected $fillable = [
        'num_of_illust', 'url_of_illustration', 'name_of_illustration', 'folderPath', 'savename_of_illustration'
    ];

    // 새 일러스트 파일 저장
    public function storeIllustFile(array $illust_file_info)
    {
        IllustFile::insert($illust_file_info);
    }

    /**
     * 하나의 일러스트 작품은 여러 일러스트 파일을 가질 수 있다.
     */
    public function illustration_lists()
    {
        return $this->belongsTo('App\Models\IllustrationList', 'num_of_illust');
    }
}
