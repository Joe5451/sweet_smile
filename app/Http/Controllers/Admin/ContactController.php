<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Contact;

class ContactController extends Controller
{
    public function getItems(Request $request) {
        $page = (int) $request->query('page', 1);
        $limit = (int) $request->query('limit', 15);
        $offset = ($page - 1) * $limit;

        $contacts = Contact::orderBy('created_at', 'desc')
        ->orderBy('id', 'desc')
        ->offset($offset)
        ->limit($limit)
        ->get();

        $contacts->each(function ($contact) {
            $contact->state = Contact::process_states[$contact->state];
            $contact->datetime = date('Y-m-d H:i:s', strtotime($contact->created_at));
        });

        $total = Contact::count();
        
        return response()->json([
            'contacts' => $contacts,
            'total' => $total,
        ]);
    }

    public function getItem($id, Request $request) {
        $contact = Contact::find($id);

        if (is_null($contact)) {
            return response()->json([
                'status' => 'fail',
                'message' => '查無資料'
            ]);
        }

        $contact->datetime = date('Y-m-d H:i:s', strtotime($contact->created_at));

        return response()->json([
            'status' => 'success',
            'contact' => $contact
        ]);
    }

    public function updateItem($id, Request $request) {
        $data = $request->input();

        $validator = Validator::make($data,
        [
            'state' => 'required|numeric',
            'remark' => 'nullable|string',
        ]);

        if (!$validator->fails()) {
            Contact::find($id)->update($data);

            return response()->json([
                'status' => 'success',
                'message' => ''
            ]);
        } else {
            return response()->json([
                'status' => 'fail',
                'message' => '資料缺少或格式錯誤，請重新嘗試',
                'error' => $validator->messages()
            ]);
        }
    }

    public function deleteItem($id, Request $request) {
        Contact::find($id)->delete();

        return response()->json([
            'status' => 'success',
            'message' => ''
        ]);
    }
}