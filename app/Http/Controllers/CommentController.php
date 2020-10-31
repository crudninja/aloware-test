<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Comment;
use Inspections\Spam;
use Exception;

class CommentController extends Controller
{
    /**
     * Get Comments for pageId
     *
     * @return Comments
     */
    public function index($pageId)
    {
        $comments = Comment::where('page_id',$pageId)->get();
        $commentsData = [];
        
        foreach ($comments as $key) {
            $name = $key->name;
            $replies = $this->replies($key->id);
            $reply = 0;

            if(sizeof($replies) > 0){
                $reply = 1;
            }

            array_push($commentsData,[
                "name" => $name,
                "commentid" => $key->id,
                "comment" => $key->comment,
                "reply" => $reply,
                "replies" => $replies,
                "date" => $key->created_at->toDateTimeString()
            ]);
        }
        $collection = collect($commentsData);
        return $collection->sortBy('created_at');
    }

    protected function replies($commentId)
    {
        $comments = Comment::where('reply_id',$commentId)->get();
        $replies = [];

        foreach ($comments as $key) {
            $name = $key->name;

            array_push($replies,[
                "name" => $name,
                "commentid" => $key->id,
                "comment" => $key->comment,
                "date" => $key->created_at->toDateTimeString()
            ]);

        }
        
        $collection = collect($replies);
        return $collection->sortBy('created_at');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            #resolve(Spam::class)->detect($request->comment);

            $this->validate($request, [
            'comment' => 'required',
            'reply_id' => 'filled',
            'page_id' => 'filled',
            'name' => 'required',
            ]);
            $comment = Comment::create($request->all());

            if($comment)
                return [ "status" => "true","commentId" => $comment->id ];
        } catch (Exception $e) {
            return [ "status" => "false","message" => $e->getMessage() ];
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $commentId
     * @param  $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $commentId,$type)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}