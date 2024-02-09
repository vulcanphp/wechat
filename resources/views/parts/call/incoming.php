<template x-if="incomingData.popup">
    <div class="absolute inset-0 z-50 flex items-center justify-center backdrop-blur-md rounded">
        <div class="flex items-center flex-col md:flex-row justify-center md:justify-between shadow-md p-4 md:min-w-96 bg-gray-50 border border-gray-100 rounded-lg">
            <div class="flex items-center flex-col md:flex-row justify-center md:justify-start">
                <template x-if="incomingData.user.avatar">
                    <img :src="'<?= storage_url() ?>' + incomingData.user.avatar" class="w-20 h-20 mx-auto rounded-full" :alt="incomingData.user.name + ' - Avatar'">
                </template>
                <template x-if="!incomingData.user.avatar">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 mx-auto fill-current text-teal-400" viewBox="0 0 24 24">
                        <path d="M12 2C6.579 2 2 6.579 2 12s4.579 10 10 10 10-4.579 10-10S17.421 2 12 2zm0 5c1.727 0 3 1.272 3 3s-1.273 3-3 3c-1.726 0-3-1.272-3-3s1.274-3 3-3zm-5.106 9.772c.897-1.32 2.393-2.2 4.106-2.2h2c1.714 0 3.209.88 4.106 2.2C15.828 18.14 14.015 19 12 19s-3.828-.86-5.106-2.228z"></path>
                    </svg>
                </template>
                <div class="md:ml-4 mt-4 md:mt-0">
                    <p class="font-semibold text-xl" x-text="incomingData.user.name"></p>
                    <p class="flex items-center mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="fill-current text-teal-400 w-6" viewBox="0 0 24 24">
                            <path x-cloak x-show="incomingData.type == 'video'" d="M18 7c0-1.103-.897-2-2-2H4c-1.103 0-2 .897-2 2v10c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-3.333L22 17V7l-4 3.333V7zm-1.998 10H4V7h12l.001 4.999L16 12l.001.001.001 4.999z"></path>
                            <path x-cloak x-show="incomingData.type == 'audio'" d="M17.707 12.293a.999.999 0 0 0-1.414 0l-1.594 1.594c-.739-.22-2.118-.72-2.992-1.594s-1.374-2.253-1.594-2.992l1.594-1.594a.999.999 0 0 0 0-1.414l-4-4a.999.999 0 0 0-1.414 0L3.581 5.005c-.38.38-.594.902-.586 1.435.023 1.424.4 6.37 4.298 10.268s8.844 4.274 10.269 4.298h.028c.528 0 1.027-.208 1.405-.586l2.712-2.712a.999.999 0 0 0 0-1.414l-4-4.001zm-.127 6.712c-1.248-.021-5.518-.356-8.873-3.712-3.366-3.366-3.692-7.651-3.712-8.874L7 4.414 9.586 7 8.293 8.293a1 1 0 0 0-.272.912c.024.115.611 2.842 2.271 4.502s4.387 2.247 4.502 2.271a.991.991 0 0 0 .912-.271L17 14.414 19.586 17l-2.006 2.005z"></path>
                        </svg>
                        <span class="inline-block ml-2 capitalize" x-text="incomingData.type + ' Calling...'"></span>
                    </p>
                </div>
            </div>
            <div class="flex items-center mt-4 md:mt-0">
                <button class="p-1 hover:bg-rose-100 rounded-full" @click="rejectCall()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 fill-current text-rose-500" viewBox="0 0 24 24">
                        <path d="m16.192 6.344-4.243 4.242-4.242-4.242-1.414 1.414L10.535 12l-4.242 4.242 1.414 1.414 4.242-4.242 4.243 4.242 1.414-1.414L13.364 12l4.242-4.242z"></path>
                    </svg>
                </button>
                <button class="p-1 ml-1 hover:bg-teal-100 rounded-full" @click="acceptCall()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 fill-current text-teal-500" viewBox="0 0 24 24">
                        <path d="m20.487 17.14-4.065-3.696a1.001 1.001 0 0 0-1.391.043l-2.393 2.461c-.576-.11-1.734-.471-2.926-1.66-1.192-1.193-1.553-2.354-1.66-2.926l2.459-2.394a1 1 0 0 0 .043-1.391L6.859 3.513a1 1 0 0 0-1.391-.087l-2.17 1.861a1 1 0 0 0-.29.649c-.015.25-.301 6.172 4.291 10.766C11.305 20.707 16.323 21 17.705 21c.202 0 .326-.006.359-.008a.992.992 0 0 0 .648-.291l1.86-2.171a.997.997 0 0 0-.085-1.39z"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>