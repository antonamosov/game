<?php

namespace App\Http\Controllers;

use App\Models\SocialFacebookAccount;
use App\Models\User;
use App\Models\UserFriend;
use Facebook\Exceptions\FacebookSDKException;
use Illuminate\Http\Request;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;
use Socialite;
use App\Services\SocialFacebookAccountService;

class SocialAuthFacebookController extends Controller
{
    /*public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }*/

    /*public function callback(SocialFacebookAccountService $service)
    {
        $user = $service->createOrGetUser(Socialite::driver('facebook')->user());
        auth()->login($user);

        return redirect()->to('/');
    }*/

    public function redirect(LaravelFacebookSdk $fb)
    {
        return redirect()->to($fb->getLoginUrl(['email', 'user_friends']));
    }

    public function callback(LaravelFacebookSdk $fb)
    {
        // Obtain an access token.
        $token = $fb->getAccessTokenFromRedirect();

        // Access token will be null if the user denied the request
        // or if someone just hit this URL outside of the OAuth flow.
        if (! $token) {
            // Get the redirect helper
            $helper = $fb->getRedirectLoginHelper();

            if (! $helper->getError()) {
                abort(403, 'Unauthorized action.');
            }

            // User denied the request
            dd(
                $helper->getError(),
                $helper->getErrorCode(),
                $helper->getErrorReason(),
                $helper->getErrorDescription()
            );
        }

        if (! $token->isLongLived()) {
            // OAuth 2.0 client handler
            $oauth_client = $fb->getOAuth2Client();

            // Extend the access token.
            try {
                $token = $oauth_client->getLongLivedAccessToken($token);
            } catch (FacebookSDKException $e) {
                dd($e->getMessage());
            }
        }

        $fb->setDefaultAccessToken($token);

        // Save for later
        \Session::put('fb_user_access_token', (string) $token);

        // Get basic info on the user from Facebook.
        try {
            $response = $fb->get('/me?fields=id,name,email');
        } catch (FacebookSDKException $e) {
            dd($e->getMessage());
        }
        // Convert the response to a `Facebook/GraphNodes/GraphUser` collection
        $providerUser = $response->getGraphUser();

        // Get Avatar
        try {
            $response = $fb->get($providerUser->getId() . '/picture?redirect=false');
        } catch (FacebookSDKException $e) {
            dd($e->getMessage());
        }
        $pictureNode = $response->getGraphNode();

        // Create the user if it does not exist or update the existing entry.
        // This will only work if you've added the SyncableGraphNodeTrait to your User model.
        $account = SocialFacebookAccount::whereProvider('facebook')
            ->whereProviderUserId($providerUser->getId())
            ->first();
        if ($account) {
            $user = $account->user;
        }
        else {
            $account = new SocialFacebookAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => 'facebook'
            ]);
            $user = User::whereEmail($providerUser->getEmail())->first();
            if ( ! $user ) {
                $password = rand(1,10000);
                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'name' => $providerUser->getName(),
                    'password' => \Hash::make($password),
                    'encrypt_password' => encrypt($password),
                    'image_path' => $pictureNode['url'],
                ]);
            }
            $account->user()->associate($user);
            $account->save();
        }

        // Get friends
        try {
            $response = $fb->get($providerUser->getId() . '/friends');
        }
        catch (FacebookSDKException $e) {
            dd($e->getMessage());
        }
        $friendsNode = $response->getGraphEdge();
        $providerFriendIds = [];
        foreach($friendsNode as $friendNode) {
            $providerFriendIds = $friendNode['id'];
        }

        $friendIds = SocialFacebookAccount::where('provider_user_id', $providerFriendIds)->pluck('user_id');

        foreach ($friendIds as $key => $id) {
            $friendExists = UserFriend::where('user_id', $user->id)->where('friend_id', $id)->first();
            if (! $friendExists) {
                UserFriend::create([
                    'user_id' => $user->id,
                    'friend_id' => $id,
                ]);
                UserFriend::create([
                    'user_id' => $id,
                    'friend_id' => $user->id,
                ]);
            }
        }

        // Log the user into Laravel
        auth()->login($user);

        return redirect('/');
    }
}
