<?php

namespace App\Http\Controllers\Api;

use App\Helpers\FileHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ModelController extends BaseApiController
{
    public function __construct()
    {
    }
    
    public function upLoadModel(Request $request) {
        $data = $request->all();
        Log::info($data);
        if ($request->hasFile('model_json') && $request->hasFile('model_weights_bin')) {
            FileHelper::clearDir('model');
            FileHelper::saveFileToStorage('model', $request->model_json, 'model.json');
            FileHelper::saveFileToStorage('model', $request->model_weights_bin, 'model.weights.bin');
        }
        return $this->sendResponse('');
    }

    public function getModel(Request $request) {
        return response()->file('storage/model/model.json');
    }

    public function getModelWeight(Request $request) {
        return response()->file('storage/model/model.weights.bin');
    }
}
