<template x-if="outgoingData.popup">
    <div class="absolute inset-0 z-30 bg-slate-900 md:rounded px-10 py-16 flex items-center justify-center text-center">
        <div>
            <template x-if="outgoingData.user.avatar">
                <img :src="'<?= storage_url() ?>' + outgoingData.user.avatar" class="w-24 h-24 mx-auto rounded-full" :alt="outgoingData.user.name + ' - Avatar'">
            </template>
            <template x-if="!outgoingData.user.avatar">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 mx-auto fill-current text-teal-400" viewBox="0 0 24 24">
                    <path d="M12 2C6.579 2 2 6.579 2 12s4.579 10 10 10 10-4.579 10-10S17.421 2 12 2zm0 5c1.727 0 3 1.272 3 3s-1.273 3-3 3c-1.726 0-3-1.272-3-3s1.274-3 3-3zm-5.106 9.772c.897-1.32 2.393-2.2 4.106-2.2h2c1.714 0 3.209.88 4.106 2.2C15.828 18.14 14.015 19 12 19s-3.828-.86-5.106-2.228z"></path>
                </svg>
            </template>
            <div class="mt-8">
                <h3 class="font-extralight text-slate-200 text-3xl mb-2" x-text="outgoingData.user.name"></h3>
                <p class="font-light text-slate-400 capitalize" x-text="outgoingData.alreadyInCall ? 'Already In Call' : (outgoingData.isBusy ? 'Busy Now' : (outgoingData.isRinging ? 'Ringing...' : outgoingData.type + ' Calling...'))"></p>
                <div class="mt-6">
                    <div class="flex justify-center">
                        <template x-if="!outgoingData.isBusy && !outgoingData.alreadyInCall">
                            <button class="p-2 rounded-full bg-rose-400 text-white hover:bg-rose-500" @click="cancelCall()">
                                <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-8" viewBox="0 0 24 24">
                                    <path d="M9.17 13.42a5.24 5.24 0 0 1-.93-2.06L10.7 9a1 1 0 0 0 0-1.39l-3.65-4.1a1 1 0 0 0-1.4-.08L3.48 5.29a1 1 0 0 0-.29.65 15.25 15.25 0 0 0 3.54 9.92l-4.44 4.43 1.42 1.42 18-18-1.42-1.42zm7.44.02a1 1 0 0 0-1.39.05L12.82 16a4.07 4.07 0 0 1-.51-.14l-2.66 2.61A15.46 15.46 0 0 0 17.89 21h.36a1 1 0 0 0 .65-.29l1.86-2.17a1 1 0 0 0-.09-1.39z"></path>
                                </svg>
                            </button>
                        </template>
                        <template x-if="outgoingData.isBusy || outgoingData.alreadyInCall">
                            <div>
                                <button class="p-2 rounded-full bg-slate-400 text-white hover:bg-slate-500" @click="startCall(outgoingData.type, outgoingData.user)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-8" viewBox="0 0 24 24">
                                        <path d="M19.89 10.105a8.696 8.696 0 0 0-.789-1.456l-1.658 1.119a6.606 6.606 0 0 1 .987 2.345 6.659 6.659 0 0 1 0 2.648 6.495 6.495 0 0 1-.384 1.231 6.404 6.404 0 0 1-.603 1.112 6.654 6.654 0 0 1-1.776 1.775 6.606 6.606 0 0 1-2.343.987 6.734 6.734 0 0 1-2.646 0 6.55 6.55 0 0 1-3.317-1.788 6.605 6.605 0 0 1-1.408-2.088 6.613 6.613 0 0 1-.382-1.23 6.627 6.627 0 0 1 .382-3.877A6.551 6.551 0 0 1 7.36 8.797 6.628 6.628 0 0 1 9.446 7.39c.395-.167.81-.296 1.23-.382.107-.022.216-.032.324-.049V10l5-4-5-4v2.938a8.805 8.805 0 0 0-.725.111 8.512 8.512 0 0 0-3.063 1.29A8.566 8.566 0 0 0 4.11 16.77a8.535 8.535 0 0 0 1.835 2.724 8.614 8.614 0 0 0 2.721 1.833 8.55 8.55 0 0 0 5.061.499 8.576 8.576 0 0 0 6.162-5.056c.22-.52.389-1.061.5-1.608a8.643 8.643 0 0 0 0-3.45 8.684 8.684 0 0 0-.499-1.607z"></path>
                                    </svg>
                                </button>
                                <button class="ml-4 p-2 rounded-full bg-rose-400 text-white hover:bg-rose-500" @click="outgoingData.popup = false">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-8" viewBox="0 0 24 24">
                                        <path d="m16.192 6.344-4.243 4.242-4.242-4.242-1.414 1.414L10.535 12l-4.242 4.242 1.414 1.414 4.242-4.242 4.243 4.242 1.414-1.414L13.364 12l4.242-4.242z"></path>
                                    </svg>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>