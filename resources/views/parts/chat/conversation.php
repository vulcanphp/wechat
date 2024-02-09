<div>
    <template x-if="chat.self">
        <div class="flex max-w-56 md:max-w-80 md:px-4 md:py-2 text-sm md:text-base px-2 py-1 bg-teal-500 text-white w-max m-2 sm:m-3 md:m-4 rounded-xl ml-[auto!important]" :class="!hasNext(day, index) && 'rounded-br-none'">
            <p>
                <template x-if="chat.type == 'textfile'">
                    <span x-data="{content: JSON.parse(chat.content)}">
                        <a :href="'/storage' + content.file" target="_blank" class="mb-2 block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-28 text-slate-100" viewBox="0 0 24 24">
                                <path d="M19.903 8.586a.997.997 0 0 0-.196-.293l-6-6a.997.997 0 0 0-.293-.196c-.03-.014-.062-.022-.094-.033a.991.991 0 0 0-.259-.051C13.04 2.011 13.021 2 13 2H6c-1.103 0-2 .897-2 2v16c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2V9c0-.021-.011-.04-.013-.062a.952.952 0 0 0-.051-.259c-.01-.032-.019-.063-.033-.093zM16.586 8H14V5.414L16.586 8zM6 20V4h6v5a1 1 0 0 0 1 1h5l.002 10H6z"></path>
                                <path d="M8 12h8v2H8zm0 4h8v2H8zm0-8h2v2H8z"></path>
                            </svg>
                        </a>
                        <span x-text="content.message"></span>
                    </span>
                </template>
                <template x-if="chat.type == 'voicecall'">
                    <span class="inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 fill-current text-amber-300" viewBox="0 0 24 24">
                            <path d="M16.712 13.288a.999.999 0 0 0-1.414 0l-1.594 1.594c-.739-.22-2.118-.72-2.992-1.594s-1.374-2.253-1.594-2.992l1.594-1.594a.999.999 0 0 0 0-1.414l-4-4a.999.999 0 0 0-1.414 0L2.586 6c-.38.38-.594.902-.586 1.435.023 1.424.4 6.37 4.298 10.268S15.142 21.977 16.566 22h.028c.528 0 1.027-.208 1.405-.586l2.712-2.712a.999.999 0 0 0 0-1.414l-3.999-4zM16.585 20c-1.248-.021-5.518-.356-8.873-3.712C4.346 12.922 4.02 8.637 4 7.414l2.005-2.005 2.586 2.586-1.293 1.293a1 1 0 0 0-.272.912c.024.115.611 2.842 2.271 4.502s4.387 2.247 4.502 2.271a.993.993 0 0 0 .912-.271l1.293-1.293 2.586 2.586L16.585 20z"></path>
                            <path d="m16.795 5.791-4.497 4.497 1.414 1.414 4.497-4.497L21.005 10V2.995H14z"></path>
                        </svg>
                        <span class="font-semibold text-slate-100 text-sm ml-1">Voice Call</span>
                    </span>
                </template>
                <template x-if="chat.type == 'videocall'">
                    <span class="inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 fill-current text-amber-300" viewBox="0 0 24 24">
                            <path d="M18 7c0-1.103-.897-2-2-2H6.414L3.707 2.293 2.293 3.707l18 18 1.414-1.414L18 16.586v-2.919L22 17V7l-4 3.333V7zm-2 7.586L8.414 7H16v7.586zM4 19h10.879l-2-2H4V8.121L2.145 6.265A1.977 1.977 0 0 0 2 7v10c0 1.103.897 2 2 2z"></path>
                        </svg>
                        <span class="font-semibold text-slate-100 text-sm ml-1">Video Call</span>
                    </span>
                </template>
                <template x-if="chat.type == 'text'">
                    <span x-text="chat.content"></span>
                </template>
                <span class="text-slate-100 text-xs ml-1" x-text="chat.time"></span>
            </p>
        </div>
    </template>
    <template x-if="!chat.self">
        <div class="flex max-w-56 md:max-w-80 md:px-4 md:py-2 text-sm md:text-base px-2 py-1 bg-slate-200 text-slate-800 w-max m-2 sm:m-3 md:m-4 rounded-xl" :class="!hasNext(day, index) && 'rounded-bl-none'">
            <p>
                <template x-if="chat.type == 'textfile'">
                    <span x-data="{content: JSON.parse(chat.content)}">
                        <a :href="'/storage' + content.file" target="_blank" class="mb-2 block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-28 text-slate-400" viewBox="0 0 24 24">
                                <path d="M19.903 8.586a.997.997 0 0 0-.196-.293l-6-6a.997.997 0 0 0-.293-.196c-.03-.014-.062-.022-.094-.033a.991.991 0 0 0-.259-.051C13.04 2.011 13.021 2 13 2H6c-1.103 0-2 .897-2 2v16c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2V9c0-.021-.011-.04-.013-.062a.952.952 0 0 0-.051-.259c-.01-.032-.019-.063-.033-.093zM16.586 8H14V5.414L16.586 8zM6 20V4h6v5a1 1 0 0 0 1 1h5l.002 10H6z"></path>
                                <path d="M8 12h8v2H8zm0 4h8v2H8zm0-8h2v2H8z"></path>
                            </svg>
                        </a>
                        <span x-text="content.message"></span>
                    </span>
                </template>
                <template x-if="chat.type == 'voicecall'">
                    <span class="inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 fill-current text-rose-600" viewBox="0 0 24 24">
                            <path d="M16.712 13.288a.999.999 0 0 0-1.414 0l-1.597 1.596c-.824-.245-2.166-.771-2.99-1.596-.874-.874-1.374-2.253-1.594-2.992l1.594-1.594a.999.999 0 0 0 0-1.414l-4-4a1.03 1.03 0 0 0-1.414 0l-2.709 2.71c-.382.38-.597.904-.588 1.437.022 1.423.396 6.367 4.297 10.268C10.195 21.6 15.142 21.977 16.566 22h.028c.528 0 1.027-.208 1.405-.586l2.712-2.712a.999.999 0 0 0 0-1.414l-3.999-4zM16.585 20c-1.248-.021-5.518-.356-8.874-3.712C4.343 12.92 4.019 8.636 4 7.414l2.004-2.005L8.59 7.995 7.297 9.288c-.238.238-.34.582-.271.912.024.115.611 2.842 2.271 4.502s4.387 2.247 4.502 2.271a.994.994 0 0 0 .912-.271l1.293-1.293 2.586 2.586L16.585 20z"></path>
                            <path d="M15.795 6.791 13.005 4v6.995H20l-2.791-2.79 4.503-4.503-1.414-1.414z"></path>
                        </svg>
                        <span class="font-semibold text-sm ml-1">Missed Voice Call</span>
                    </span>
                </template>
                <template x-if="chat.type == 'videocall'">
                    <span class="inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 fill-current text-rose-600" viewBox="0 0 24 24">
                            <path d="M18 7c0-1.103-.897-2-2-2H6.414L3.707 2.293 2.293 3.707l18 18 1.414-1.414L18 16.586v-2.919L22 17V7l-4 3.333V7zm-2 7.586L8.414 7H16v7.586zM4 19h10.879l-2-2H4V8.121L2.145 6.265A1.977 1.977 0 0 0 2 7v10c0 1.103.897 2 2 2z"></path>
                        </svg>
                        <span class="font-semibold text-sm ml-1">Missed Video Call</span>
                    </span>
                </template>
                <template x-if="chat.type == 'text'">
                    <span x-text="chat.content"></span>
                </template>
                <span class="text-slate-500 text-xs ml-1" x-text="chat.time"></span>
            </p>
        </div>
    </template>
</div>