<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Option;
use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


class UserProfileController extends Controller
{
    protected $title;
    protected $subtitle;

    public function __construct(Request $request)
    {
        $this->title = 'Profile';
        $action = $request->route()->getActionMethod();

        switch ($action) {
            case 'create':
                $this->subtitle = $this->title . ' / Tambah';
                break;
            case 'show':
                $this->subtitle = $this->title . ' / Show';
                break;
            case 'edit':
                $this->subtitle = $this->title . ' / Edit';
                break;
            case 'list':
                $this->subtitle = $this->title . ' / List';
                break;
            default:
                $this->subtitle = $this->title . '';
                break;
        }

        insert_log('Mengakses halaman Profile');

        view()->share([
            'title' => $this->title,
            'subtitle' => $this->subtitle,
        ]);
    }

    public function index()
    {
        $user = Auth::user();
        $user->last_login_at = Carbon::parse($user->last_login_at)->format('d M Y, g:i a');

        if ($user->email_verified_at) {
            $user->formatted_email_verified_at = $user->email_verified_at->format('d M Y, g:i a');
            $user->status_email = '<div class="badge badge-light-success">Terverifikasi</div>';
        } else {
            $user->status_email = '<div class="badge badge-light-danger">Belum Terverifikasi</div>';
        }
        return view('admin.userprofile.index', compact('user'));
    }

    public function updateProfile(Request $request) {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'name' => 'required',
                'username' => 'required',
            ],
            [
                'avatar.image' => 'File harus berupa gambar.',
                'avatar.mimes' => 'File harus berupa jpeg,png,jpg,gif,svg.',
                'avatar.max' => 'File maksimal 2048KB.',
                'name.required' => 'Nama harus diisi.',
                'username.required' => 'Username harus diisi.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first()
                ]);
            }

            $user = Auth::user();
            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
                $avatar->move('images/avatar', $avatarName);

                if (file_exists($user->avatar)) {
                    unlink($user->avatar);
                }

                $file_path = 'images/avatar/' . $avatarName;
            } else {
                $file_path = $user->avatar;
            }

            $user->update([
                'name' => $request->name,
                'username' => $request->username,
                'avatar' => $file_path
            ]);

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Profile updated successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function updatePassword(Request $request, $id) {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'old_password' => 'required',
                'new_password' => 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
                'confirm_password' => 'required|same:new_password',
            ],
            [
                'old_password.required' => 'Password lama harus diisi.',
                'new_password.required' => 'Password baru harus diisi.',
                'new_password.min' => 'Password baru minimal 8 karakter.',
                'new_password.regex' => 'Password baru harus mengandung kombinasi huruf besar, huruf kecil, angka dan karakter spesial.',
                'confirm_password.required' => 'Konfirmasi password harus diisi.',
                'confirm_password.same' => 'Konfirmasi password tidak sesuai.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first()
                ]);
            }

            $user = User::find($id);
            if (!Hash::check($request->old_password, $user->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Password lama tidak sesuai.'
                ]);
            }

            $user->update([
                'password' => Hash::make($request->new_password)
            ]);

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Password updated successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function updatetwofa(Request $request, $id) {
        DB::beginTransaction();
        try {
            $user = User::find($id);
            // check the email_verified_at
            if ($user->email_verified_at == null) {
                return response()->json([
                    'status' => false,
                    'message' => 'Mohon verifikasi email terlebih dahulu.'
                ]);
            }

            $state = $request->is_twofa_enabled;
            if ($state == 'false') {
                $user->update([
                    'is_twofa_enabled' => 0
                ]);
            } else {
                $user->update([
                    'is_twofa_enabled' => 1
                ]);
            }
            $user->update([
                'twofa_code' => null,
                'twofa_expires_at' => null
            ]);
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => '2FA updated successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function updateemail(Request $request, $id) {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:users,email,' . $id
            ],
            [
                'email.required' => 'Email harus diisi.',
                'email.email' => 'Email harus valid.',
                'email.unique' => 'Email sudah terdaftar.'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first()
                ]);
            }

            // check the password first
            $user = User::find($id);
            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Password konfirmasi tidak sesuai.'
                ]);
            }

            $user = User::find($id);
            $user->update([
                'email' => $request->email,
                'email_verified_at' => null
            ]);

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Email updated successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function verifyemail($id) {
        DB::beginTransaction();
        try {
            $user = User::find($id);
            $company_data = Option::first();
            $social_media = SocialMedia::where('status', 1)->get();
            // send email verification
            $verificationUrl = route('user-profile.email.verify-link', ['id' => $user->id]);

            Mail::send('emails.verify', ['user' => $user, 'verificationUrl' => $verificationUrl, 'social_media' => $social_media, 'company_data' => $company_data], function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Your Email Verification');
            });
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Email verified successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function verifyEmailLink(Request $request) {

        $user = User::find($request->id);
        if ($user) {
            $user->email_verified_at = Carbon::now();
            $user->save();
            return redirect()->route('user-profile.index');
        }
        return response()->json([
            'status' => false,
            'message' => 'The provided link is invalid or expired.'
        ]);
    }
}
