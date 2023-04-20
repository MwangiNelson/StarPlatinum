<template>
    <div class="container d-flex justify-content-center">
        <!-- Loading the Landing vue template -->
        <Landing></Landing>
    </div>
</template>

<script>

// self-explanatory lol
// Importing and bundling the Landing view/vue
import Landing from "../screens/Landing.vue";
export default {
    components: {
        Landing,
    },
};
</script>

<style></style>
