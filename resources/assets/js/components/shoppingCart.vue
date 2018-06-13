<template>
    <div class="navbar-item has-dropdown" :class="{'is-active': active}">
        <a class="navbar-link sinDown has-text-white" @click="cartDropdown">
            <i class="fas fa-shopping-cart"></i>
            <ul class="count">
                <li>1</li>
                <li>2</li>
            </ul>
        </a>
        <div class="navbar-dropdown is-boxed is-right">
            <cart-item v-for="(item,index) in allCartItems"  :key="index" :item="item"></cart-item>
            <hr class="navbar-divider">
            <a class="navbar-item espacioBetween">
                <span>SUB-TOTAL:  </span>
                <span>45€</span>
            </a>
        </div>
    </div>
</template>

<script>

    import store from '../store';

    import CartItem from "./CartItem";
    export default {
        components: {CartItem},
        props: ['active'],
        name: "shoppingCart",
        computed: {
          allCartItems(){
              return store.getters.cartItems;
          }
        },
        methods: {
            cartDropdown(){
                this.$parent.cartDropdown();
            }
        }
    }
</script>

<style scoped>
    .sinDown::after {
        border: 0;
    }

    .count {
        background: #e94b35;
        color: #fff;
        font-size: .6rem;
        font-weight: 700;
        border-radius: 50%;
        text-indent: 0;
        transition: transform .2s .5s,-webkit-transform .2s .5s;
        position: relative;
        top: -5px;
        right: 6px;
        height: 15px;
        width: 15px;
    }

    .count li {
        position: absolute;
        -webkit-transform: translateZ(0);
        transform: translateZ(0);
        left: 45%;
        top: 50%;
        bottom: auto;
        right: auto;
        -webkit-transform: translateX(-50%) translateY(-50%);
        -ms-transform: translateX(-50%) translateY(-50%);
        transform: translateX(-50%) translateY(-50%);
    }

    .count li:last-of-type {
        visibility: hidden;
    }


    .espacioBetween{
        justify-content: space-between;
    }
</style>