<template>
    <div>
        {{ messageItem.user.name }}: {{ messageItem.message }}
    </div>
</template>

<script>
export default {
    props:['messageItem'],
}
</script>