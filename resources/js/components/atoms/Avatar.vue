<template>
    <div class="flex-none overflow-hidden w-10 h-10 rounded-full">
        <img class="block w-10 h-10" :src="src" style="object-fit: cover;" />
        <div class="absolute pin opacity-25"></div>
    </div>
</template>

<script>
export default {
    props: ['src'],
};
</script>
