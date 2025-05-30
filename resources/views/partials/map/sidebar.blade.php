<div id="sidebar" class="w-full md:w-1/4 bg-white border-r border-gray-200 p-2 overflow-hidden flex flex-col relative" style="max-height: 300px;">
    <!-- Controls -->
    <div class="controls flex flex-col space-y-1 pb-2 border-b border-gray-100">
        <div class="flex justify-between">
            <div class="flex items-center">
                <input type="checkbox" id="show-hospitals" checked class="mr-1">
                <label for="show-hospitals" class="text-gray-700 text-xs">Эмнэлэгүүд</label>
            </div>
            <div class="flex items-center">
                <input type="checkbox" id="show-pharmacies" checked class="mr-1">
                <label for="show-pharmacies" class="text-gray-700 text-xs">Эмийн сан</label>
            </div>
        </div>
        <div class="flex space-x-1">
            <input type="text" id="search-address" placeholder="Хаяг хайх" class="w-full text-xs p-1 border border-gray-300 rounded-sm" style="height: 24px;">
            <button id="search-button" class="bg-cyan-600 hover:bg-cyan-700 text-white p-1 rounded-sm text-xs flex-shrink-0" style="height: 24px;">Хайх</button>
        </div>
        <button id="use-my-location" class="bg-gray-100 hover:bg-gray-200 text-gray-800 py-1 px-2 rounded-sm text-xs w-full text-center">Миний байршил</button>
    </div>

    <!-- Places list -->
    @include('partials.map.places-list')
</div>
