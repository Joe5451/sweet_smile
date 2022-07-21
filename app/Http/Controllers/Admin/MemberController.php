<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Member;

class MemberController extends Controller
{
    public function add(Request $request) {
        $data = $request->input();

        $existMember = Member::where('email', $data['email'])->take(1)->get();

        if (count($existMember) > 0) {
            return response()->json([
                'status' => 'fail',
                'message' => '帳號已存在，請重新設置'
            ]);
        }

        $validator = Validator::make($data,
        [
            'name' => 'required|string',
            'mobile' => 'nullable|string',
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!$validator->fails()) {
            $data['password'] = md5($data['password']);
            Member::create($data);

            return response()->json([
                'status' => 'success',
                'message' => ''
            ]);
        } else {
            $error = $validator->messages();

            return response()->json([
                'status' => 'fail',
                'message' => '資料缺少或格式錯誤，請重新嘗試',
                'error' => $error
            ]);
        }
    }

    public function getMemberList(Request $request) {
        $page = (int) $request->query('page', 1);
        $limit = (int) $request->query('limit', 15);
        $offset = ($page - 1) * $limit;

        $members = Member::orderBy('datetime', 'desc')
        ->orderBy('member_id', 'desc')
        ->select(['member_id', 'name', 'email', 'datetime'])
        ->offset($offset)
        ->limit($limit)
        ->get();

        $total = Member::count();

        // $members = Member::orderBy('datetime', 'desc')
        // ->select(['member_id', 'name', 'email', 'datetime'])
        // ->paginate($limit)
        // ->withQueryString(); // widthQueryString() 必需接在 paginate，表示其他的查詢參數也會保留在連結中

        // return response()->json($members);
        
        return response()->json([
            'members' => $members,
            'total' => $total,
        ]);
    }

    public function getMember($id, Request $request) {
        $member = Member::select(['member_id', 'name', 'email', 'mobile', 'datetime'])
        ->find($id);

        return response()->json([
            'member' => $member
        ]);
    }

    public function updateMember($id, Request $request) {
        $data = $request->input();

        $existMember = Member::where('email', $data['email'])
        ->where('member_id', '!=', $id)
        ->take(1)->get();

        if (count($existMember) > 0) {
            return response()->json([
                'status' => 'fail',
                'message' => '帳號已存在，請重新設置'
            ]);
        }

        $validator = Validator::make($data,
        [
            'name' => 'required|string',
            'mobile' => 'nullable|string',
            'email' => 'required|email',
            'password' => 'nullable|string',
        ]);

        if (!$validator->fails()) {
            // 密碼非空白更改
            if (!is_null($data['password']))
                $data['password'] = md5($data['password']);
            else
                unset($data['password']);
                
            Member::where('member_id', $id)->update($data);

            return response()->json([
                'status' => 'success',
                'message' => ''
            ]);
        } else {
            return response()->json([
                'status' => 'fail',
                'message' => '資料缺少或格式錯誤，請重新嘗試'
            ]);
        }
    }

    public function deleteMember($id, Request $request) {
        Member::where('member_id', $id)->delete();

        return response()->json([
            'status' => 'success',
            'message' => ''
        ]);
    }
}