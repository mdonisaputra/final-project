<?php

namespace App\Http\Controllers;

use App\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{    
    public function __construct()
    {
        return $this->middleware('auth:api')->only(['store' , 'update' , 'delete']);
    }
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get data from table posts
        $news = News::latest()->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data News',
            'data'    => $news  
        ], 200);

    }
    
     /**
     * show
     *
     * @param  mixed $id
     * @return void
     */
    public function show($id)
    {
        //find post by ID
        $new = News::findOrfail($id);

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'Detail Data News',
            'data'    => $new 
        ], 200);

    }
    
    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {   
        $allRequest = $request->all();
        //set validation
        $validator = Validator::make($allRequest, [  //$request->all(), [
            'judul'   => 'required',
            'deskripsi' => 'required',
            'gambar' => 'required',
        ]);
        
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = auth()->user();

        //save to database
        $new = News::create([
            'judul'     => $request->judul,
            'user_id' =>$user->id,
            'deskripsi'   => $request->deskripsi,
            'gambar' => $request->gambar
        ]);

        //success save to database
        if($new) {

            return response()->json([
                'success' => true,
                'message' => 'News Created',
                'data'    => $new  
            ], 201);

        } 

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'News Failed to Save',
        ], 409);

    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $new
     * @return void
     */
    public function update(Request $request, $id) //, News $new)
    {
        $allRequest = $request->all();

        //set validation
        $validator = Validator::make($allRequest, [  //$request->all(), [
            'judul'   => 'required',
            'deskripsi' => 'required',
            'gambar' => 'required',
        ]);
        
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //find post by ID
        //$post = Post::findOrFail($post->id);
        $new = News::find($id);

        if($new) {
            $user = auth()->user();

            if($new->user_id != $user->id){
                return response()->json([
                    'success' => false,
                    'message' => 'News cannot be updated'
                ], 403);
            }
            
            $new->update([
                'judul'     => $request->judul,
                'deskripsi'   => $request->deskripsi,
                'gambar' => $request->gambar
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'News updated',
                'data' => $new
            ]);
        }

        //post tidak ditemukan
        return response()->json([
            'success' => false,
            'message' => 'News not found'
        ], 404);

    }
    
    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        //find post by ID
        $new = News::findOrfail($id);

        if($new) {

            $user = auth()->user();

            if($new->user_id != $user->id){
                return response()->json([
                    'success' => false,
                    'message' => 'News cannot be deleted'
                ], 403);
            }

            //delete post
            $new->delete();

            return response()->json([
                'success' => true,
                'message' => 'News deleted',
            ], 200);

        }

        //data post not found
        return response()->json([
            'success' => false,
            'message' => 'News not found',
        ], 404);
    }
}
