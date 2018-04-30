<template>
    <div>
        <div class="select" v-model="sessionid">
            <select>
                <option value="1">1</option>
                <option value="2">2</option>
            </select>
        </div>
        <seat-component :sessionID="sessionid"></seat-component>
    </div>
</template>

<script>

    export default {
        data() {
            return {
                sessionid: 0
            }
        }
    }
</script>

<style scoped>

</style>