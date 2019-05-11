<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilePost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * 사용자가 이 요청을 할 수 있는 권한이 있는지 확인하십시오.
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    # 필요한 모든 의존성의 타입힌트 지정
    public function rules()
    {
        return [
            // 'file' => 'required|file|max:16384',
            'image' => 'required|image|max:16384',      # image파일만 + 16MB까지
            # 필요한 모든 의존성의 타입힌트 지정
        ];
    }
}
