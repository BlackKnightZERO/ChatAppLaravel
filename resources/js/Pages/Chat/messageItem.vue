<template>
    <div>
        <!-- {{ messageItem.user.name }}: {{ messageItem.message }} -->
        <div v-if="authID!=messageItem.user.id" class="float-left bg-purple-300 rounded m-2 p-2 hover:bg-purple-500">
            {{ messageItem.user.name }}: {{ messageItem.message }} &#10004;
        </div>
        <div v-else class="float-right bg-purple-300 rounded m-2 p-2 hover:bg-purple-500">
            {{ messageItem.message }} : {{ messageItem.user.name }} &#10004;
        </div>

    </div>
</template>

<script>
export default {
    props:['messageItem', 'authID'],
}
</script>