<template>
    <div class="navbar-item has-dropdown carrito" :class="{'is-active': active}">
        <a class="navbar-link sinDown has-text-white" @click="cartDropdown">
            <i class="fas fa-shopping-cart"></i>
            <ul class="count" v-show="countItems > 0">
                <li>{{countItems}}</li>
                <li>2</li>
            </ul>
        </a>
        <div class="navbar-dropdown is-boxed is-right">
            <div v-if="allCartItems.length > 0">
                <cart-item v-for="(item,index) in allCartItems"  :key="index" :item="item"></cart-item>
                <hr class="navbar-divider">
                <div class="navbar-item espacioBetween" v-if="precioTotal > 0">
                    <span>SUB-TOTAL:  </span>
                    <span>{{precioTotal}}€</span>
                </div>
            </div>
            <div v-else>
                <div class="navbar-item">
                    Tu carrito está vacío.
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import store from '../store';

    import CartItem from "./CartItem";
    export default {
        components: { CartItem },
        props: ['active'],
        name: "shoppingCart",
        computed: {
          allCartItems(){
              return store.getters.cartItems;
          },
          precioTotal(){
              return store.getters.cartItems.reduce((prev,next) => prev + parseFloat(next.producto.precio)*next.cantidad,0);
          },
          countItems(){
              return store.getters.countItems;
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