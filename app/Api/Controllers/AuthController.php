<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-12-15
 * Time: 22:26
 */

namespace App\Api\Controllers;

use App\Api\Transformers\NotifyTransformer;
use App\Api\Transformers\UserTransformer;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Notifications\UserFollow;
use App\Repositories\UserRepository;
use App\Services\Mailer\UserMailer;
use Carbon\Carbon;
use Dingo\Api\Http\Response;
use Illuminate\Support\Facades\Session;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Socialite;



class AuthController extends ApiController
{


    protected $user;


    public function __construct(UserRepository $user)
    {

        $this->user = $user;
    }

    public function login(UserLoginRequest $request)
    {
        try {
            $token = JWTAuth::attempt($request->only('email', 'password'), [
                'exp' => Carbon::now()->addWeek()->timestamp,
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Could not authenticate',
            ], 500);
        }

        if (!$token) {
            return response()->json([
                'error' => ["用户名或密码不正确"],
            ], 401);
        } else {

            $user= $request->user();
        if($user->is_active==0)
        {
            return response()->json([
                'error' => ["邮箱未验证"],
            ], 401);

        }
            $meta= $token;

             return $this->item($user,new UserTransformer())->addMeta('token', $meta);;
        }
    }
    public function getuserinfo()
    {

        $user=JWTAuth::parseToken()->authenticate();
        return $this->item($user,new UserTransformer());

    }




    public function register(UserRegisterRequest $request)
    {

            $data=[
                'email'=>$request->get('email'),
                'name'=>$request->get('name'),
                'password'=>bcrypt($request->get('password')),
                'avatar' =>'/images/avatars/default.jpg',
                'confirmation_token'=>str_random(48),
            ];

        $user= $this->user->store($data);
        (new UserMailer())->sendVerifyEmail($user);
        return response()->json([
            'message' => ["请到邮箱验证"],
        ]);

        //return $this->item($user,new UserTransformer());

    }

    public function getAuthenticatedUser()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        // the token is valid and we have found the user via the sub claim
        return response()->json(compact('user'));

    }




    public function follower($id)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $usered=$this->user->getbyIds($id);

        if($user->followings->contains($id)) {
            $user ->decrement('followers_count');
            $usered->decrement('followings_count');
        }
        else {
            $user->increment('followers_count');
            $usered->increment('followings_count');
            $usered->notify(new UserFollow());
        }

        $user->followings()->toggle($id);

        return $usered->followings_count;



    }

    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }


    public function handleProviderCallback()
    {

        $githubUser  = Socialite::driver('github')->user();
        $user = $this->user->getByGithubId($githubUser->id);
        if ($user) {
            $token=JWTAuth::fromUser($user);
            Session::put('github_token', $token);
            Session::put('github_user', $user);
            return redirect()->to('/login')->with('message','登录成功');
        } else {

            $data=[
                'github_id'=>$githubUser ->id,
                'github_name'=>$githubUser ->nickname,
                'email'=>$githubUser ->email,
                'name'=>$githubUser ->nickname,
                'password'=>bcrypt(str_random(48)),
                'avatar' =>$githubUser ->avatar,
                'confirmation_token'=>str_random(48),
            ];
            $user= $this->user->store($data);
            $token=JWTAuth::fromUser($user);
            Session::put('github_token', $token);
            Session::put('github_user', $user);

            return redirect()->to('/login')->with('message','验证成功');
        }

    }


    public function getgithubuser()
    {
        $token=Session::get('github_token');
        $user=Session::get('github_user');
        if($token) {
            Session::forget('github_token');
            Session::forget('user');
            return $this->item($user,new UserTransformer())->addMeta('token', $token);

        }
    }


    public function getMessage()
    {
        if(JWTAuth::getToken()) {
                $user = JWTAuth::parseToken()->toUser();

            return $this->Item($user,new NotifyTransformer());

        }
    }

    public function markasread($id)
    {
        $user = JWTAuth::parseToken()->toUser();

        return $user->unreadNotifications->where('id',$id)->markAsRead();

    }

    public function markallread()
    {
        $user = JWTAuth::parseToken()->toUser();

        return $user->unreadNotifications->markAsRead();

    }

    public function userinfo($id)
    {

         $user=$this->user->getbyIds($id);
        return $this->item($user,new UserTransformer());


    }




}
