<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-4">Welcome, {{ Auth::user()->name }}!</h2>
                    
                    <div class="bg-gray-100 rounded-lg p-4 mb-4">
                        <p><strong>Your Role:</strong> 
                            <span class="px-2 py-1 rounded-full text-sm 
                                @if(Auth::user()->role == 'admin') bg-red-100 text-red-800
                                @elseif(Auth::user()->role == 'carpenter') bg-yellow-100 text-yellow-800
                                @elseif(Auth::user()->role == 'delivery') bg-purple-100 text-purple-800
                                @else bg-blue-100 text-blue-800
                                @endif">
                                {{ ucfirst(Auth::user()->role) }}
                            </span>
                        </p>
                        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                        <p><strong>Phone:</strong> {{ Auth::user()->phone }}</p>
                        <p><strong>Address:</strong> {{ Auth::user()->address ?? 'Not provided' }}</p>
                    </div>

                    @if(Auth::user()->role == 'admin')
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <h3 class="font-bold text-green-800">Admin Access</h3>
                            <p class="text-green-700">You have full access to manage orders, carpenters, deliveries, and view reports.</p>
                        </div>
                    @elseif(Auth::user()->role == 'carpenter')
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <h3 class="font-bold text-yellow-800">Carpenter Access</h3>
                            <p class="text-yellow-700">View your assigned tasks and update production status.</p>
                        </div>
                    @elseif(Auth::user()->role == 'delivery')
                        <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                            <h3 class="font-bold text-purple-800">Delivery Access</h3>
                            <p class="text-purple-700">View assigned deliveries and update delivery status.</p>
                        </div>
                    @else
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h3 class="font-bold text-blue-800">Customer Access</h3>
                            <p class="text-blue-700">Track your orders, make payments, and request deliveries.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>