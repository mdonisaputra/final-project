<?php

namespace App\Http\Controllers;

use App\NewsComment;
use App\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsCommentController extends Controller
{   
    public function __construct()
    {
        return $this->middleware('auth:api')->except(['index' , 'show']);
    } 
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get data from table posts
        $newscomments = NewsComment::latest()->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Comment on News',
            'data'    => $newscomments  
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
        $newscomment = NewsComment::findOrfail($id);

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Comment on News',
            'data'    => $newscomment 
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
        //set validation
        $validator = Validator::make($request->all(), [
            'isi'   => 'required',
            'new_id' => 'required',
        ]);
        
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //save to database
        $newscomment = NewsComment::create([
            'isi'     => $request->isi,
            'new_id' => $request->new_id
        ]);

        //success save to database
        if($newscomment) {

            return response()->json([
                'success' => true,
                'message' => 'Comment Created',
                'data'    => $newscomment  
            ], 201);

        } 

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Comment Failed to Save',
        ], 409);

    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $newscomment
     * @return void
     */
    public function update(Request $request, $id)//, NewsComment $newscomment)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'isi'   => 'required',
            //'new_id' => 'required',
        ]);
        
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //find post by ID
        $newscomment = NewsComment::find($id); //OrFail($newscomment->id);

        if($newscomment) {

            $user = auth()->user();

            if($newscomment->user_id != $user->id){
                return response()->json([
                    'success' => false,
                    'message' => 'Comment cannot be updated'
                ], 403);
            }

            //update post
            $newscomment->update([
                'isi'     => $request->isi,
                //'new_id' => $request->new_id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Comment updated',
                'data'    => $newscomment  
            ], 200);

        }

        //data post not found
        return response()->json([
            'success' => false,
            'message' => 'Comment not found',
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
        $newscomment = NewsComment::findOrfail($id);

        if($newscomment) {

            $user = auth()->user();

            if($newscomment->user_id != $user->id){
                return response()->json([
                    'success' => false,
                    'message' => 'Comment cannot be deleted'
                ], 403);
            }

            //delete post
            $newscomment->delete();

            return response()->json([
                'success' => true,
                'message' => 'Comment deleted',
            ], 200);

        }

        //data post not found
        return response()->json([
            'success' => false,
            'message' => 'Comment not found',
        ], 404);
    }
}