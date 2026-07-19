<x-app-layout>
    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="bg-gradient-to-br from-indigo-600 to-violet-700 rounded-3xl p-8 text-white shadow-lg relative overflow-hidden flex items-center gap-6">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/3"></div>
                <div class="z-10">
                    <h2 class="text-3xl font-extrabold">{{ __('Pengaturan Profil') }}</h2>
                    <p class="text-indigo-100 mt-1">Kelola informasi akun dan keamanan data dirimu di sini.</p>
                </div>
            </div>

            <div class="p-6 sm:p-10 bg-white shadow-xl sm:rounded-3xl border border-slate-100 transition duration-300 hover:shadow-indigo-100">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-6 sm:p-10 bg-white shadow-xl sm:rounded-3xl border border-slate-100 transition duration-300 hover:shadow-indigo-100">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- <div class="p-6 sm:p-10 bg-red-50/30 shadow-xl sm:rounded-3xl border border-red-100">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div> --}}

        </div>
    </div>
</x-app-layout>