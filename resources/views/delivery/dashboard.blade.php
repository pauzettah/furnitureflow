<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-800">Delivery Dashboard</h2>
                    <p class="text-gray-600 mt-1">Welcome, {{ Auth::user()->name }}!</p>
                    <p class="text-gray-600">View and manage your assigned deliveries.</p>

                    <div class="mt-6">
                        <a href="#" class="bg-purple-600 text-white text-center px-4 py-3 rounded-lg hover:bg-purple-700 transition inline-block">
                            View My Deliveries
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>