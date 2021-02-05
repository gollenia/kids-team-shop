<template>
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="fixed z-10 inset-0 overflow-y-auto" @click="$emit('close')">
        <div class="flex items-end justify-center min-h-screen text-center sm:block sm:p-0">
            <!--
            Background overlay, show/hide based on modal state.

            Entering: "ease-out duration-300"
                From: "opacity-0"
                To: "opacity-100"
            Leaving: "ease-in duration-200"
                From: "opacity-100"
                To: "opacity-0"
            -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <!--
            Modal panel, show/hide based on modal state.

            Entering: "ease-out duration-300"
                From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                To: "opacity-100 translate-y-0 sm:scale-100"
            Leaving: "ease-in duration-200"
                From: "opacity-100 translate-y-0 sm:scale-100"
                To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            -->
            <div class="inline-block align-bottom bg-white rounded-tl-md rounded-br-md text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full" :class="boxClass" role="dialog" aria-modal="true" aria-labelledby="modal-headline" style="margin-top: 6rem" onclick="event.stopPropagation()">
                <div class="bg-white">
                    <div class="sm:flex sm:items-start">
                        <div class="w-full text-center sm:mt-0 sm:text-left">
                            <div class="bg-primary p-4">
                            <h4 class="text-primary-contrast leading-6" id="modal-headline">
                                {{ title }}
                            </h4>
                            </div>
                            <div class="p-4 w-full">
                                <slot></slot>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Modal',
    props: {
        title: String,
        boxClass: {
            type: String,
            default: 'sm:max-w-xl'
        }
    }
}
</script>
