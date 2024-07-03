<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Resources\UserResource;

// class ProfileController extends Controller
// {
//     public function show(Request $request)
//     {
//         $user = Auth::user();


//         // التحقق من وجود المستخدم
//         if (!$user) {
//             return response()->json([
//                 'message' => 'User not found or you do not have permission to access it.'
//             ], 404);
//         }

//         // إعادة بيانات المستخدم في صيغة JSON
//         return new UserResource($user);
//     }

// };

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = Auth::user();


        // التحقق من وجود المستخدم
        if (!$user) {
            return response()->json([
                'message' => 'User not found or you do not have permission to access it.'
            ], 404);
        }

        // إعادة بيانات المستخدم في صيغة JSON
        return new UserResource($user);
    }


    public function getSuggestedFriends()
    {
        // استعلام Eloquent لجلب خمسة مستخدمين عشوائيين
        $suggestedFriends = User::select('name')->inRandomOrder()->take(5)->get();
        return response()->json([
            'data' => $suggestedFriends,
        ]);
    }

    
    public function updateP(Request $request)
    {
        // التحقق من صحة البيانات الواردة
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'phone_number' => 'sometimes|string|max:13', // يمكنك تعديل الطول وفقًا لمتطلباتك
        ]);

        // الحصول على المستخدم المعتمد
        $user = Auth::user();

        // تحديث بيانات المستخدم إذا كانت موجودة في الطلب
        if ($request->has('name')) {
            $user->name = $request->input('name');
        }

        if ($request->has('phone_number')) {
            $user->phone_number = $request->input('phone_number');
        }

        $user->save();

        return response()->json([
            'message' => 'Profile updated successfully.',
            'data' => $user,
        ]);
    }

};

