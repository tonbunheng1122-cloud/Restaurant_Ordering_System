@vite('resources/css/app.css')
<title>FastBite | Flavor Unleashed</title>
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-orange-50 to-orange-100 p-4">
  <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-sm">
    <div class="text-center mb-6">
      <h1 class="text-2xl font-bold text-orange-600 uppercase">Create Account</h1>
      <p class="text-sm text-gray-500">Join our system today</p>
    </div>

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 border-l-4 border-red-500 text-red-700 text-sm rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="/register">
      @csrf
      <div class="mb-4">
        <label class="block text-sm font-semibold text-gray-700 mb-1">Username</label>
        <input name="username" type="text" required value="{{ old('username') }}" placeholder="Choose a username"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none">
      </div>

      <div class="mb-4">
        <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
        <input name="password" type="password" required placeholder="Create a password"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none">
      </div>

      <div class="mb-6">
        <label class="block text-sm font-semibold text-gray-700 mb-1">Confirm Password</label>
        <input name="password_confirmation" type="password" required placeholder="Repeat your password"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none">
      </div>

      <input type="hidden" name="role" value="User">

      <button type="submit"
        class="w-full bg-orange-600 text-white py-2.5 rounded-lg font-bold hover:bg-orange-700 shadow-md transition transform active:scale-95">
        Register Now
      </button>

      <p class="text-center text-sm mt-6 text-gray-600">
        Already have an account? 
        <a href="/login" class="text-orange-600 font-bold hover:underline">Login</a>
      </p>
    </form>

    <p class="text-center text-[10px] text-gray-400 mt-8 uppercase">
      © 2026 Restaurant Ordering System
    </p>
  </div>
</div>