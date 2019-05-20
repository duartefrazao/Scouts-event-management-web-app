<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;

class ParentController extends Controller
{

    public function changeAccount()
    {

        $new_user_id = request()->all()['new_user'];
        $current_user_id = Auth::id();

        abort_if($current_user_id==$new_user_id,401);


        if(!session()->has('parent'))
            session(['parent' => $current_user_id]);

        //Parent is changing to parent again
        if(session('parent') == $new_user_id){

            //Parent changing to himself
            abort_if($current_user_id==$new_user_id, 401);

            Auth::logout();

            Auth::login(User::find($new_user_id));
        }
        //Parent is changing between sons
        else{
            
            $new_user_parent_id = User::find($new_user_id)->guardian;

            //The new user has no parent defined
            abort_if(!isset($new_user_parent_id),401);

            //Parent changing to same son
            abort_if($current_user_id==$new_user_id, 401);

            //Changing to user that is not son
            abort_if($new_user_parent_id != session('parent'),401);

            Auth::logout();

            Auth::login(User::find($new_user_id));
        }

        session()->save();
        
        return redirect('/');
    }

}
