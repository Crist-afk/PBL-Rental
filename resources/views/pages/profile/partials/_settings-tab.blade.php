<div class="hidden rounded-3xl border-2 border-dark-chocolate/10 bg-white p-6 shadow-sm" id="pengaturan" role="tabpanel" aria-labelledby="pengaturan-tab">
    <h3 class="mb-6 text-xl font-bold text-dark-chocolate">Account Settings</h3>

    <div class="space-y-4">
        <div class="rounded-xl border border-dark-chocolate/10 bg-misty-rose/20 p-4">
            <div class="mb-4">
                <p class="font-bold text-dark-chocolate">Change Password</p>
                <p class="mt-1 text-xs text-dark-chocolate/60">Use a strong password with at least 8 characters.</p>
            </div>

            <form action="{{ route('profile.password.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="current_password" class="mb-2 block text-sm font-semibold text-dark-chocolate">Current Password</label>
                    <input type="password" id="current_password" name="current_password" required
                        class="w-full rounded-xl border border-dark-chocolate/10 bg-white px-4 py-3 text-sm text-dark-chocolate outline-none transition focus:border-dark-chocolate/40 focus:ring-2 focus:ring-dark-chocolate/10">
                    @error('current_password', 'updatePassword')
                        <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label for="password" class="mb-2 block text-sm font-semibold text-dark-chocolate">New Password</label>
                        <input type="password" id="password" name="password" required minlength="8"
                            class="w-full rounded-xl border border-dark-chocolate/10 bg-white px-4 py-3 text-sm text-dark-chocolate outline-none transition focus:border-dark-chocolate/40 focus:ring-2 focus:ring-dark-chocolate/10">
                        @error('password', 'updatePassword')
                            <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-dark-chocolate">Confirm New Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required minlength="8"
                            class="w-full rounded-xl border border-dark-chocolate/10 bg-white px-4 py-3 text-sm text-dark-chocolate outline-none transition focus:border-dark-chocolate/40 focus:ring-2 focus:ring-dark-chocolate/10">
                    </div>
                </div>

                <button type="submit"
                    class="rounded-xl bg-dark-chocolate px-5 py-3 text-sm font-bold text-white transition hover:bg-dark-chocolate/90 focus:outline-none focus:ring-2 focus:ring-dark-chocolate/30">
                    Update Password
                </button>
            </form>
        </div>

        <div class="mt-8 rounded-xl border border-red-100 bg-red-50 p-4">
            <div class="mb-4">
                <p class="font-bold text-red-700">Deactivate Account</p>
                <p class="mt-1 text-xs text-red-500/80">Your profile will be anonymized and you will no longer be able to log in. Rental history may be retained for business records, and forum content may remain visible as Deleted User.</p>
            </div>

            <form action="{{ route('profile.account.destroy') }}" method="POST" class="space-y-4">
                @csrf
                @method('DELETE')

                <div>
                    <label for="delete_account_password" class="mb-2 block text-sm font-semibold text-red-700">Confirm Password</label>
                    <input type="password" id="delete_account_password" name="password" required
                        class="w-full rounded-xl border border-red-100 bg-white px-4 py-3 text-sm text-red-700 outline-none transition focus:border-red-300 focus:ring-2 focus:ring-red-100">
                    @error('password', 'deleteAccount')
                        <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="rounded-xl bg-red-600 px-5 py-3 text-sm font-bold text-white transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-200"
                    onclick="return confirm('Are you sure you want to deactivate your account?')">
                    Deactivate My Account
                </button>
            </form>
        </div>
    </div>
</div>
