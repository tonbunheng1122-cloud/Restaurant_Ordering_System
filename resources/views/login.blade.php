@vite('resources/css/app.css')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-orange-50 to-orange-100 p-4">
  <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-sm">
    <div class="text-center mb-6">
      <h1 class="text-2xl font-bold text-orange-600 uppercase tracking-wide">Restaurant System</h1>
      <p class="text-sm text-gray-500">Welcome back! Please login</p>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 border-l-4 border-green-500 text-green-700 text-sm rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->has('login_error'))
        <div class="mb-4 p-3 bg-red-100 border-l-4 border-red-500 text-red-700 text-sm rounded">
            {{ $errors->first('login_error') }}
        </div>
    @endif
    <form method="POST" action="/login">
      @csrf
      <div class="mb-4">
        <label class="block text-sm font-semibold text-gray-700 mb-1">Username</label>
        <input name="username" type="text" required value="{{ old('username') }}" placeholder="Enter your username"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none transition">
      </div>

      <div class="mb-6">
        <div class="flex justify-between items-center mb-1">
          <label class="text-sm font-semibold text-gray-700">Password</label>
          <a href="#" class="text-xs text-orange-600 hover:underline">Forgot?</a>
        </div>
        <input name="password" type="password" required placeholder="Enter your password"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none transition">
      </div>

      <button type="submit"
        class="w-full bg-orange-500 text-white py-2.5 rounded-lg font-bold hover:bg-orange-600 shadow-md transition transform active:scale-95">
        Login
      </button>

      <p class="text-center text-sm mt-6 text-gray-600">
        Don't have an account? 
        <a href="/register" class="text-orange-600 font-bold hover:underline">Register now</a>
      </p>
    </form>
    
    <p class="text-center text-[10px] text-gray-400 mt-8 uppercase">
      © 2026 Restaurant Ordering System
    </p>
  </div>
</div>