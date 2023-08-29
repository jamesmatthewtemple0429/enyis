<?php namespace App\Http\Controllers\Auth;
    use App\Http\Controllers\Controller;
    use App\Models\Member;
    use Illuminate\Http\Request;
    use App\Models\User;

    class MicrosoftAuthController extends Controller
    {
        public function redirect() {
            return \Socialite::with('azure')
                ->scopes(['offline_access'])
                ->redirect();
        }

        public function handle() {
            $socialiteUser = \Socialite::with('azure')
                ->stateless()
                ->user();

            $isUser = User::firstOrCreate(['microsoft_id'   => $socialiteUser->id]);

            $nameParts = explode(",",$socialiteUser->name);

            $email = hash('sha256',$socialiteUser->email);

            $foundMember = Member::where('email_key', $email)->orWhere('second_email_key', $email)->first();

            $isUser->update([
                'email'             => $socialiteUser->email,
                'email_key'         => $email,
                'access_token'      => $socialiteUser->token,
                'refresh_token'     => $socialiteUser->refreshToken,
                'account_id'        => $foundMember->account_id
            ]);

            auth()->login($isUser);

            return redirect()->route('dashboard')
                ->with([
                    'flash.banner'  => 'You are now signed in!'
                ]);
        }
    }
