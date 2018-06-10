<template>
    <transition name="modal_main-fade">
        <div class="modal_main-backdrop">
            <div class="modal_main">
                <header class="modal_main-header">
                    <slot name="header">
                        <span>This is the default tile!</span>
                    </slot>
                    <a class="delete" @click="close"></a>
                </header>
                <section class="modal_main-body">
                    <slot name="body">
                        I'm the default body!
                    </slot>
                </section>
                <footer class="modal_main-footer">
                    <slot name="footer">

                        <button class="button is-warning is-rounded is-small"
                                @click="close"
                        >
                            Entendido!
                        </button>
                    </slot>
                </footer>
            </div>
        </div>
    </transition>
</template>
<script>
    export default {
        name: 'modal',

        methods: {
            close() {
                this.$emit('close');
            },
        },
    }
</script>

<style scoped>

    .modal_main-fade-enter,
    .modal_main-fade-leave-active {
        opacity: 0;
    }

    .modal_main-fade-enter-active,
    .modal_main-fade-leave-active {
        transition: opacity .5s ease
    }

    .modal_main-backdrop {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: rgba(0, 0, 0, 0.3);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 30;
    }

    .modal_main {
        background: #FFFFFF;
        box-shadow: 2px 2px 20px 1px;
        overflow-x: auto;
        display: flex;
        flex-direction: column;
        border-radius: 5px;
        z-index: 10;
    }

    .modal_main-header,
    .modal_main-footer {
        padding: 15px;
        display: flex;
    }

    .modal_main-header {
        border-bottom: 1px solid #eeeeee;
        color: hsl(348, 100%, 61%);
        justify-content: space-between;
        align-items: center;
    }

    .modal_main-header > span{
        margin-right: 1rem;
    }

    .modal_main-footer {
        border-top: 1px solid #eeeeee;
        justify-content: flex-end;
    }

    .modal_main-body {
        position: relative;
        padding: 20px 10px;
    }

    .btn-close {
        border: none;
        font-size: 20px;
        padding: 20px;
        cursor: pointer;
        font-weight: bold;
        color: #4AAE9B;
        background: transparent;
    }

    .btn-green {
        color: white;
        background: #4AAE9B;
        border: 1px solid #4AAE9B;
        border-radius: 2px;
    }
</style>