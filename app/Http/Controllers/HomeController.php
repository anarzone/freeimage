<?php

namespace App\Http\Controllers;

use App\Jobs\SaveImage;
use App\Media;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Cache;
use Predis\Client as Predis;

class HomeController extends Controller
{
    private $baseUrl = "https://pixabay.com/api/";

    public function index(Request $request){
        return view('pages.index');
    }

    public function getSavedImages(){
        $images = Media::paginate(5);
        return view('pages.saved', compact('images'));
    }

    public function search(Request $request){
        $fullPath = $this->baseUrl.'?key='.env('PIXABAY_API_KEY').'&q='.$request->searchInput.'&image_type=photo';
        $input = $request->searchInput;

        if(Cache::has($input)){
            $redis = new Predis();
            $redis->select(1);

            $redis_prefix = config('database.redis.options.prefix');
            $cache_prefix = config('cache.prefix');

            $data = [
                'remaining_time' => $redis->ttl($redis_prefix.$cache_prefix.':'.$input),
                'content' => Cache::get($input)
            ];
        }else{
            $client = new \GuzzleHttp\Client();
            $searchRequest = $client->get($fullPath);
            $content = json_decode($searchRequest->getBody()->getContents());
            Cache::put($input, $content, now()->addHours(24));

            $data = [
                'remaining_time' => 0,
                'content' => $content
            ];
        }

        return response([
            'message' => 'Retrieved images',
            'data' => $data,
            'status' => Response::HTTP_OK
        ],Response::HTTP_OK);
    }

    public function store(Request $request){
        $imageUrl = $request->url;
        $contents = file_get_contents($imageUrl);
        $name = substr($imageUrl, strrpos($imageUrl, '/') + 1);

        $thumbnail = Image::make(file_get_contents($imageUrl))
                                    ->resize(320, 240);

        Storage::disk('public')->put(Media::MAIN_PATH.'/'.Media::STANDARD_PATH.'/'.$name, $contents);
        Storage::disk('public')->put(Media::MAIN_PATH.'/'.Media::THUMBNAIL_PATH.'/'.$name, $thumbnail->encode());

        SaveImage::dispatch($name);

        return response([
            'message' => 'Image has been stored successfully',
            'data' => [],
            'status' => Response::HTTP_OK
        ],Response::HTTP_OK);
    }
}
