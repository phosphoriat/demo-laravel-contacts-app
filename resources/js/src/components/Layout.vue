<template>
    <Header />

    <main class="my-8 mx-2 md:m-8">
        <slot />
    </main>

    <Footer />
</template>

<script setup>
import Header from '@/components/Header.vue';
import Footer from '@/components/Footer.vue';
</script>