<form @submit.prevent="createMessage()" x-ref="messageForm" class="relative h-12">
    <label for="file" class="absolute left-0 top-2 z-10 cursor-pointer">
        <input type="file" id="file" style="display: none;" x-ref="sendFile" x-model="sendFile">
        <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-7 text-teal-400 hover:text-teal-500" viewBox="0 0 24 24">
            <path x-cloak x-show="!sendFile" d="M19.937 8.68c-.011-.032-.02-.063-.033-.094a.997.997 0 0 0-.196-.293l-6-6a.997.997 0 0 0-.293-.196c-.03-.014-.062-.022-.094-.033a.991.991 0 0 0-.259-.051C13.04 2.011 13.021 2 13 2H6c-1.103 0-2 .897-2 2v16c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2V9c0-.021-.011-.04-.013-.062a.99.99 0 0 0-.05-.258zM16.586 8H14V5.414L16.586 8zM6 20V4h6v5a1 1 0 0 0 1 1h5l.002 10H6z"></path>
            <path x-cloak x-show="sendFile" d="M6 2a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6H6zm8 7h-1V4l5 5h-4z"></path>
        </svg>
    </label>
    <input x-ref="sendMessage" class="w-full h-full absolute inset-0 px-10 outline-none" placeholder="Type Something...">
    <button :disabled="loading" :class="loading ? 'opacity-75 cursor-wait bg-slate-200' : 'bg-teal-400 hover:bg-teal-500 text-white'" class="absolute top-1 right-0 text-sm p-2 rounded-full" type="submit">
        <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-6 h-6 text-white" viewBox="0 0 24 24">
            <path d="m21.426 11.095-17-8A.999.999 0 0 0 3.03 4.242L4.969 12 3.03 19.758a.998.998 0 0 0 1.396 1.147l17-8a1 1 0 0 0 0-1.81zM5.481 18.197l.839-3.357L12 12 6.32 9.16l-.839-3.357L18.651 12l-13.17 6.197z"></path>
        </svg>
    </button>
</form>