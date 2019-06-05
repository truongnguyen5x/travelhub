<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Plan;
use App\Comment;
use App\Image;
use App\User;
use App\UserRequest;
use App\Follow;
use App\Participant;
use App\Marker;
use App\Events\CommentRedisEvent;

class DetailPlanController extends Controller
{


    public function postComment(Request $request)
    {
        if($request->parentCommentId != null)
        {
            $parentComment = Comment::find($request->parentCommentId);
            if($parentComment == null)
            {
                return response()->json([], 400);
            }
        }

        $plan = Plan::find($request->planId);
        $owner = false;
        if($request->userId == $plan->user_id)
        {
            $owner = true;
        }

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $comment = new Comment;

        if($request->address != null)
        {
            $marker = new Marker;
            $marker->lat = $request->lat;
            $marker->lng = $request->lng;
            $marker->label = $request->address;
            $marker->save();

            $comment->location_id = $marker->id;
        }
        else $marker = null;
        
        $comment->plan_id = $request->planId;
        $comment->user_id = $request->userId;
        $comment->content = $request->content;
        $comment->parent_comment_id = $request->parentCommentId;
        $comment->date_created = date('Y-m-d H:i:s');
        $comment->save();
        $dateCreated = date_format(date_create($comment->date_created), 'M d, Y h:i A');
        $userName = $comment->user->full_name;
        $avatar = $comment->user->avatar;

        $path= array();
        if($request->image != null)
        {
            foreach ($request->image as $key => $value) {
                $nameImage = $key . '-' . $request->userId . '-' . $value->getClientOriginalName();
                $value->move('image/comment', $nameImage);
                $url = '/image/comment/' . $nameImage;
                array_push($path, $url);
                $image = new Image;
                $image->path = $url;
                $image->comment_id = $comment->id;
                $image->save();
            }
        }

        if($marker == null)
        {
            event(
                $e = new CommentRedisEvent($comment, User::find($comment->user_id), $path, null)
            );
        }
        else
        {
            event(
                $e = new CommentRedisEvent($comment, User::find($comment->user_id), $path, $marker->label)
            );
        }
        

        return response()->json(['owner' => $owner, 'content' => $comment->content,'commentId' => $comment->id, 'userId' => $comment->user_id, 'parentCommentId' => $comment->parent_comment_id, 'dateCreated' => $dateCreated, 'marker' => $marker, 'userName' => $userName, 'avatar' => $avatar, 'path' => $path],200);
    }

    public function deleteComment(Request $request)
    {
        $commentId = $request->commentId;
        $comment = Comment::find($commentId);
        $replyComments = $comment->replycomments;

        if($replyComments->isEmpty())
        {
            $deleteImages = Image::where('comment_id', $commentId)->delete();
        }
        else
        {
            foreach ($replyComments as $key => $replyComment)
            {
                $deleteImages = Image::where('comment_id', $replyComment->id)->delete();
                $replyComment->delete();
            }
        }

        /*event(
            $e = new CommentRedisEvent($comment, User::find(Auth::user()->id), ['id' => $commentId, 'mess' => 'Delete'])
        );*/

        $comment->delete();

        return response()->json(['commentId' => $commentId], 200);        
    }

    public function joinPlan(Request $request)
    {
        if($request->join == "Tham gia")
        {
            $userRequest = new UserRequest;
            $userRequest->user_id = Auth::user()->id;
            $userRequest->plan_id = $request->planId;
            $userRequest->state = 0;
            $userRequest->save();

            if($request->follow == "Theo dõi")
            {
                $follow = new Follow;
                $follow->user_id = Auth::user()->id;
                $follow->plan_id = $request->planId;
                $follow->save();
                $amountFollow = Plan::find($request->planId)->follows->count();
                return response()->json(['join' => 'Đã gửi yêu cầu tham gia', 'follow' => 'Đã theo dõi', 'amountFollow' => $amountFollow],200);
            }
            else
            {
                return response()->json(['join' => 'Đã gửi yêu cầu tham gia', 'follow' => ''],200);   
            }
        }
        elseif ($request->join == "Đã gửi yêu cầu tham gia")
        {
            $userRequest = UserRequest::where('user_id', Auth::user()->id)->where('plan_id', $request->planId)->first();
            $userRequest->delete();
            return response()->json(['join' => 'Tham gia'],200);
        }
        elseif ($request->join == "Đã tham gia")
        {
            $participant = Participant::where('user_id', Auth::user()->id)->where('plan_id', $request->planId)->first();
            $participant->delete();
            $userRequest = UserRequest::where('user_id', Auth::user()->id)->where('plan_id', $request->planId)->first();
            $userRequest->state = -1;
            $userRequest->save();
            return response()->json(['join' => 'Đã bỏ tham gia'],200);
        }

        return response()->json([], 400);
    }

    public function followPlan(Request $request)
    {
        if(($request->join == "Tham gia") || ($request->join == ""))
        {
            if($request->follow == "Theo dõi")
            {
                $follow = new Follow;
                $follow->user_id = Auth::user()->id;
                $follow->plan_id = $request->planId;
                $follow->save();
                $amountFollow = Plan::find($request->planId)->follows->count();
                return response()->json(['follow' => 'Đã theo dõi', 'amountFollow' => $amountFollow],200);
            }
            else
            {
                $follow = Follow::where('user_id', Auth::user()->id)->where('plan_id', $request->planId)->first();
                $follow->delete();
                $amountFollow = Plan::find($request->planId)->follows->count();
                return response()->json(['follow' => 'Theo dõi', 'amountFollow' => $amountFollow],200);
            }
        }
        return response()->json([], 400);
    }

    public function loadList(Request $request)
    {
        $userRequests = Plan::find($request->planId)->requests;

        if($userRequests->isEmpty())
        {
            return response()->json(['userRequests' => $userRequests, 'users' => null], 200);
        }

        foreach($userRequests as $key => $userRequest)
        {
            $users[$key] = $userRequest->user;
        }

        return response()->json(['userRequests' => $userRequests, 'users' => $users], 200); 
    }

    public function processRequest(Request $request)
    {
        $userRequest = UserRequest::find($request->id);

        if($request->action == "accept")
        {
            $userRequest->state = 1;
            $participant = new Participant;
            $participant->user_id = $userRequest->user_id;
            $participant->plan_id = $userRequest->plan_id;
            $participant->save();
            $extra = Plan::find($userRequest->plan_id)->participants->count();
        }
        elseif($request->action == "deny")
        {
            $userRequest->state = -1;
            $extra = null;
        }
        elseif($request->action == "remove")
        {
            $userRequest->state = -1;
            $participant = Participant::where('user_id', $userRequest->user_id)->where('plan_id', $userRequest->plan_id)->first();
            $participant->delete();
            $extra = Plan::find($userRequest->plan_id)->participants->count();
        }

        $userRequest->save();
        $userRequests = Plan::find($userRequest->plan_id)->requests;

        foreach($userRequests as $key => $userRequest)
        {
            $users[$key] = $userRequest->user;
        }

        return response()->json(['userRequests' => $userRequests, 'users' => $users, 'extra' => $extra], 200);
    }
}
