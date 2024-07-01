<?php
namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\ImageManager;

class UpdateProfileController extends Controller
{
    public function update(Request $request)
    {

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.Auth::user()->id.',id',
        ];

        if(!empty($request->image)){
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.Auth::user()->id.',id',
        ]);
        if($validator->fails()){
            return redirect()->route('account.profile')->withErrors($validator);
        }

        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        if(!empty($request->image)){

            File::delete(public_path('uploads/profile/'.$user->image));
            File::delete(public_path('uploads/thumb/'.$user->image));

            $image = $request->file('image');
            $ext = $image->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $image->move(public_path('uploads/profile'), $filename);
            
            $user->image=$filename;
            $user->save();

            $manage_image = new ImageManager(GdDriver::class );
            $img = $manage_image->read(public_path('uploads/profile/'.$filename));

            $img->cover(150, 150);
            $img->save(public_path('uploads/thumb/'.$filename));

        }

        return redirect()->route('account.profile')->with('success', 'Profile updated successfully.');
    }


}