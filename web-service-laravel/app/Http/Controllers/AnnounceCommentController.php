<?php

namespace App\Http\Controllers;

use App\AnnounceComment;
use App\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AnnounceCommentController extends Controller
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
        $announcecomments = AnnounceComment::latest()->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Comment on Announcement',
            'data'    => $announcecomments  
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
        $announcecomment = AnnounceComment::findOrfail($id);

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Comment on Announcement',
            'data'    => $announcecomment 
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
            'announcement_id' => 'required',
        ]);
        
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //save to database
        $announcecomment = AnnounceComment::create([
            'isi'     => $request->isi,
            'announcement_id' => $request->announcement_id
        ]);

        //success save to database
        if($announcecomment) {

            return response()->json([
                'success' => true,
                'message' => 'Comment Created',
                'data'    => $announcecomment  
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
     * @param  mixed $announcecomment
     * @return void
     */
    public function update(Request $request, AnnounceComment $announcecomment)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'isi'   => 'required',
            'announcement_id' => 'required',//penyebab error (|announcements,id',)
        ]);
        
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //find post by ID
        $announcecomment = AnnounceComment::findOrFail($announcecomment->id);

        if($announcecomment) {

            $user = auth()->user();

            if($announcecomment->user_id != $user->id){
                return response()->json([
                    'success' => false,
                    'message' => 'Comment cannot be updated'
                ], 403);
            }

            //update post
            $announcecomment->update([
                'isi'     => $request->isi,
                'announcement_id' => $request->announcement_id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Comment updated',
                'data'    => $announcecomment  
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
        $announcecomment = AnnounceComment::findOrfail($id);

        if($announcecomment) {

            $user = auth()->user();

            if($announcecomment->user_id != $user->id){
                return response()->json([
                    'success' => false,
                    'message' => 'Comment cannot be deleted'
                ], 403);
            }

            //delete post
            $announcecomment->delete();

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