<?php

namespace App\Http\Controllers;

use App\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AnnounceController extends Controller
{    
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get data from table posts
        $announcements = Announcement::latest()->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Announcements',
            'data'    => $announcements  
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
        $announcement = Announcement::findOrfail($id);

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Announcement',
            'data'    => $announcement
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
            'judul'   => 'required',
            'deskripsi' => 'required',
            'file' => 'required',
        ]);
        
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //$user = auth()->user();

        //save to database
        $announcement = Announcement::create([
            'judul'     => $request->judul,
            //'user_id' =>$user->id
            'deskripsi'   => $request->deskripsi,
            'file' => $request->file
        ]);

        //success save to database
        if($announcement) {

            return response()->json([
                'success' => true,
                'message' => 'Announcement Created',
                'data'    => $announcement  
            ], 201);

        } 

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Announcement Failed to Save',
        ], 409);

    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $announcement
     * @return void
     */
    public function update(Request $request, Announcement $announcement)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'judul'   => 'required',
            'deskripsi' => 'required',
            'file' => 'required',
        ]);
        
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //find post by ID
        //$post = Post::findOrFail($post->id);
        $announcement = Announcement::find($id);

        if($announcement) {
            $user = auth()->user();

            if($announcement->user_id != $user->id){
                return response()->json([
                    'success' => false,
                    'message' => 'Announcement cannot be updated'
                ], 403);
            }
            
            $announcement->update([
                'judul'     => $request->judul,
                'deskripsi'   => $request->deskripsi,
                'file' => $request->file
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Announcement updated',
                'data' => $announcement
            ]);
        }

        //post tidak ditemukan
        return response()->json([
            'success' => false,
            'message' => 'Announcement not found'
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
        $announcement = Announcement::findOrfail($id);

        if($announcement) {

            $user = auth()->user();

            if($announcement->user_id != $user->id){
                return response()->json([
                    'success' => false,
                    'message' => 'Announcement cannot be deleted'
                ], 403);
            }

            //delete post
            $announcement->delete();

            return response()->json([
                'success' => true,
                'message' => 'Announcement deleted',
            ], 200);

        }

        //data post not found
        return response()->json([
            'success' => false,
            'message' => 'Announcement not found',
        ], 404);
    }
}
