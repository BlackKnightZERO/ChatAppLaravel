<template>
    <div>
        <!-- {{ messageItem.user.name }}: {{ messageItem.message }} -->
        <div v-if="authID!=messageItem.user.id" class="float-left bg-purple-300 rounded-3xl m-2 p-2 hover:bg-purple-500">
            <span class="font-semibold">{{ messageItem.user.name }}</span>: {{ messageItem.message }} &#10004;
        </div>
        <div v-else class="float-right bg-purple-300 rounded-3xl m-2 p-2 hover:bg-purple-500">
            {{ messageItem.message }} : <span class="font-semibold">{{ messageItem.user.name }}</span> &#10004;
        </div>

    </div>
</template>

<script>
export default {
    props:['messageItem', 'authID'],
}
</script>