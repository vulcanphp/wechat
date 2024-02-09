<div class="relative z-10 mt-4">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 fill-current text-slate-400 absolute top-2 md:top-3 left-3" viewBox="0 0 24 24">
        <path d="M10 18a7.952 7.952 0 0 0 4.897-1.688l4.396 4.396 1.414-1.414-4.396-4.396A7.952 7.952 0 0 0 18 10c0-4.411-3.589-8-8-8s-8 3.589-8 8 3.589 8 8 8zm0-14c3.309 0 6 2.691 6 6s-2.691 6-6 6-6-2.691-6-6 2.691-6 6-6z"></path>
    </svg>
    <input type="text" @input.debounce.200ms="filterChatlist" x-ref="search" class="bg-slate-100 px-4 md:py-3 py-2 rounded-md w-full pl-11 outline-none placeholder:text-slate-400" placeholder="Search People">
</div>