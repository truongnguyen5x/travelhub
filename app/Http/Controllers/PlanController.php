<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Follow;
use App\Marker;
use App\Participant;
use App\Plan;
use App\Rules\AfterNow;
use App\User;
use App\UserRequest;
use Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Validator;

class PlanController extends Controller
{
    public function getAdd()
    {
        return view('plan.add', ['user' => Auth::user()]);
    }
    //get All details about plan
    public function getDetail($id)
    {
        $plan = Plan::find($id);
        if ($plan == null) {
            return redirect('/'); //sửa
        }
        $startTime = $plan->start_time;
        $endTime   = $plan->end_time;

        $request = UserRequest::where('plan_id', $id)->where('user_id', Auth::user()->id)->first();
        $follow  = Follow::where('plan_id', $id)->where('user_id', Auth::user()->id)->first();

        $comments = Comment::where('plan_id', $id)->whereNull('parent_comment_id')->orderBy('date_created', 'desc')->get();

        if ($plan->user->id == Auth::user()->id) {
            return view('user.myPlan', ['plan' => $plan, 'startTime' => $startTime, 'endTime' => $endTime, 'request' => $request, 'follow' => $follow, 'comments' => $comments]);
        }
        return view('user.planDetail', ['plan' => $plan, 'startTime' => $startTime, 'endTime' => $endTime, 'request' => $request, 'follow' => $follow, 'comments' => $comments]);
    }

    //post add plan
    public function postAdd(Request $request)
    {
        //validate
        $validator = Validator::make($request->all(), [
            'planName'  => 'required',
            'endTime'   => 'required',
            'startTime' => ['required', new AfterNow, 'before:endTime'],
            'cover'     => 'required|image|dimensions:min_width=100,min_height=100',
        ], [
            'planName.required'  => 'Hãy nhập tên kế hoạch',
            'startTime.required' => 'Bạn hãy nhập thời gian khởi hành',
            'startTime.before'   => 'Thời gian khởi hành cần trước thời gian kết thúc',
            'endTime.required'   => 'Bạn hãy nhập thời gian kết thúc',
            'cover.required'     => 'Hãy chọn 1 ảnh bìa',
            'cover.image'        => 'Hãy chọn 1 ảnh bìa',
            'cover.dimensions'   => 'Ảnh bìa quá nhỏ',
        ]);
        //validate lỗi
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 400);
        } else {
            //tạo mới 1 plan
            $user              = Auth::user();
            $plan              = new Plan;
            $plan->user_id     = $user->id;
            $plan->name        = $request->planName;
            $plan->start_time  = Carbon::createFromFormat('d-m-Y H:i', $request->startTime);
            $plan->end_time    = Carbon::createFromFormat('d-m-Y H:i', $request->endTime);
            $pathImage         = $request->cover->store('public/plans');
            $plan->cover_image = $pathImage;
            $plan->save();
            try {
                //kiểm tra logic
                $listMarkers = json_decode($request->markers);
                if (empty($listMarkers)) {
                    throw new Exception("Lỗi! ít địa điểm quá bạn ơi");
                }
                if (count($listMarkers) < 2) {
                    throw new Exception("Lỗi! ít địa điểm quá bạn ơi");
                }
                $index = 0;
                $list  = array();
                foreach ($listMarkers as $markerSource) {
                    $marker                = new Marker;
                    $marker->lat           = $markerSource->lat;
                    $marker->lng           = $markerSource->lng;
                    $marker->plan_id       = $plan->id;
                    $marker->index_in_plan = $index++;
                    $marker->place_id      = $markerSource->placeId;
                    $marker->has_link      = $markerSource->hasLink;
                    $marker->place_detail  = $markerSource->placeDetail;
                    $marker->arriver_time  = Carbon::createFromFormat('d-m-Y H:i', $markerSource->arriverTime);
                    $marker->leave_time    = Carbon::createFromFormat('d-m-Y H:i', $markerSource->leaveTime);
                    $marker->activity      = $markerSource->activity;
                    $marker->travel_mode   = $markerSource->travelMode;
                    $marker->vehicle       = $markerSource->vehicle;
                    $marker->has_waypoints = $markerSource->hasWaypoints;
                    $marker->route_index   = $markerSource->routeIndex;
                    if ($markerSource->hasWaypoints) {
                        $marker->waypoints = $markerSource->waypoints;
                    }
                    array_push($list, $marker);
                    $marker->save();
                }
                for ($i = 0; $i < count($list) - 1; $i++) {
                    if ($list[$i]->arriver_time > $list[$i]->leave_time) {
                        throw new Exception("Lỗi! Địa điểm " . ($i + 1) . " sai thời gian");
                    }
                    if ($list[$i]->leave_time > $list[$i + 1]->arriver_time) {
                        throw new Exception("Lỗi! Chặng số " . ($i + 1) . " sai thời gian");
                    }
                }
                if ($plan->end_time < end($list)->arriver_time) {
                    throw new Exception("Lỗi! Chặng cuối sai thời gian");
                }
            } catch (Exception $e) {
                //bắt lỗi
                $plan->delete();
                foreach ($plan->markers as $marker) {
                    $marker->delete();
                }
                return response()->json(['error' => $e->getMessage()], 400);
            }
            $participant          = new Participant;
            $participant->plan_id = $plan->id;
            $participant->user_id = $user->id;
            $participant->save();
            return url('/plan/detail/' . $plan->id);
        }
    }
    //hàm get Edit plan
    public function getEdit($id)
    {
        //kiểm tra quyền sửa kế hoạch và trạng thái của kế hoạch
        $user = Auth::user();
        $plan = Plan::find($id);
        if (empty($plan) || $plan->user_id != $user->id || $plan->state != 'Lên kế hoạch') {
            return "<img width=100% height=100%  src='https://i.stack.imgur.com/WOlr3.png'>";
        }
        $listMarkers = $plan->markers;
        return view('plan.edit', ['user' => Auth::user(), 'plan' => $plan, 'markers' => $listMarkers]);
    }

    //func post edit
    public function postEdit(Request $request, $id)
    {
        //kiểm tra quyền sửa kế hoạch và trạng thái của kế hoạch
        $user = Auth::user();
        $plan = Plan::find($id);
        if (empty($plan) || $plan->user_id != $user->id || $plan->state != 'Lên kế hoạch') {
            return "<img width=100% height=100%  src='https://i.stack.imgur.com/WOlr3.png'>";
        }
        //validates
        $validator = Validator::make($request->all(), [
            'planName'  => 'required',
            'endTime'   => 'required',
            'startTime' => ['required', new AfterNow, 'before:endTime'],
        ], [
            'planName.required'  => 'Hãy nhập tên kế hoạch',
            'startTime.required' => 'Bạn hãy nhập thời gian khởi hành',
            'startTime.before'   => 'Thời gian khởi hành cần trước thời gian kết thúc',
            'endTime.required'   => 'Bạn hãy nhập thời gian kết thúc',
        ]);
        //validate lỗi
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 400);
        } else {
            //sửa kế hoạch
            $plan->name       = $request->planName;
            $plan->start_time = Carbon::createFromFormat('d-m-Y H:i', $request->startTime);
            $plan->end_time   = Carbon::createFromFormat('d-m-Y H:i', $request->endTime);
            if ($request->hasCover) {
                $pathImage = $request->cover->store('public/plans');
                $oldCover  = $plan->cover_imager;
                Storage::delete($oldCover);
                $plan->cover_image = $pathImage;
            }
            if ($request->state == 1) {
                $plan->state = 'Đang chạy';
            } elseif ($request->state == 2) {
                $plan->state = 'Kết thúc';
            } elseif ($request->state == 3) {
                $plan->state = 'Hủy';
            }
            try {
                //kiểm tra logic
                $listMarkers = json_decode($request->markers);
                if (empty($listMarkers)) {
                    throw new Exception("Lỗi!quá ít địa điểm ");
                }
                if (count($listMarkers) < 2) {
                    throw new Exception("Lỗi!quá ít địa điểm ");
                }
                $index = 0;
                $list  = array();
                foreach ($listMarkers as $markerSource) {
                    $marker                = new Marker;
                    $marker->lat           = $markerSource->lat;
                    $marker->lng           = $markerSource->lng;
                    $marker->index_in_plan = $index++;
                    $marker->place_id      = $markerSource->placeId;
                    $marker->has_link      = $markerSource->hasLink;
                    $marker->place_detail  = $markerSource->placeDetail;
                    $marker->arriver_time  = Carbon::createFromFormat('d-m-Y H:i', $markerSource->arriverTime);
                    $marker->leave_time    = Carbon::createFromFormat('d-m-Y H:i', $markerSource->leaveTime);
                    $marker->activity      = $markerSource->activity;
                    $marker->travel_mode   = $markerSource->travelMode;
                    $marker->vehicle       = $markerSource->vehicle;
                    $marker->has_waypoints = $markerSource->hasWaypoints;
                    $marker->route_index   = $markerSource->routeIndex;
                    if ($markerSource->hasWaypoints) {
                        $marker->waypoints = $markerSource->waypoints;
                    }
                    array_push($list, $marker);
                }
                for ($i = 0; $i < count($list) - 1; $i++) {
                    if ($list[$i]->arriver_time > $list[$i]->leave_time) {
                        throw new Exception("Lỗi! Địa điểm " . ($i + 1) . " sai thời gian");
                    }
                    if ($list[$i]->leave_time > $list[$i + 1]->arriver_time) {
                        throw new Exception("Lỗi! Chặng số " . ($i + 1) . " sai thời gian");
                    }
                }
                if ($plan->end_time < end($list)->arriver_time) {
                    throw new Exception("Lỗi! Chặng cuối sai thời gian");
                }
            } catch (Exception $e) {
                //bắt lỗi
                return response()->json(['error' => $e->getMessage()], 400);
            }
            foreach ($plan->markers as $marker) {
                $marker->delete();
            }
            foreach ($list as $marker) {
                $marker->plan_id = $plan->id;
                $marker->save();
            }
            $plan->save();
            return url('/plan/detail/' . $plan->id);
        }

    }

    //delete plan
    public function deletePlan($id)
    {
        $plan = Plan::find($id);

        if ($plan == null) {
            return redirect('/');
        } elseif ($plan->user_id != Auth::user()->id) {
            return redirect('/');
        } elseif ($plan->state == "Lên kế hoạch") {
            $requests    = UserRequest::where('plan_id', $id)->delete();
            $follows     = Follow::where('plan_id', $id)->delete();
            $participant = Participant::where('plan_id', $id)->delete();
            $marker      = Marker::where('plan_id', $id)->delete();
            $comments    = Comment::where('plan_id', $id)->delete();
            $plan->delete();
            return redirect('/trang-chu');
        } else {
            return redirect('/');
        }
    }
}
