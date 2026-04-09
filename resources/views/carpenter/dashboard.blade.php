<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-800">Carpenter Dashboard</h2>
                    <p class="text-gray-600 mt-1">Welcome, {{ Auth::user()->name }}!</p>
                    <p class="text-gray-600">View and manage your assigned furniture tasks.</p>

                    <div class="mt-6">
                        <a href="#" class="bg-yellow-600 text-white text-center px-4 py-3 rounded-lg hover:bg-yellow-700 transition inline-block">
                            View My Tasks
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>