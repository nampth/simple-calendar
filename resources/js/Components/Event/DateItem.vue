<template>
    <div>
        <button class="date" @click="$emit('clickDate', day)">
            {{ day }}
        </button>
    </div>
</template>

<script>
    export default {
        name: "DateItem",
        props: ["day"],
    }
</script>

<style scoped>
    .date {
        border: 1px solid #dcdcdc;
    }
</style>
