<?php 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\followersDetail;
use App\Models\followingDetail;
use App\Models\User;

class UserController extends Controller
{
    public function following($id)
    {
        $userToFollow = User::findOrFail($id);

        auth()->user()->following()->attach($userToFollow);

        return response()->json([
            'status' => true,
            'message' => 'Successfully followed user.'
        ], 200);
    }

    public function unfollow($id)
    {
        $userToUnfollow = User::findOrFail($id);

        auth()->user()->unfollow()->detach($userToUnfollow);

        return response()->json([
            'status' => true,
            'message' => 'Successfully unfollowed user.'
        ], 200);
    }
}
