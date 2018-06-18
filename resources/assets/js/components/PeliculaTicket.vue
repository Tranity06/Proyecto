<template>
    <div class="flex-container">
        <div class="box-form" style="display: flex; flex-direction: column">
            <div class="ticket-block">
                <div class="codigo"></div>
                <div class="entrada">
                    <p class="has-text-weight-bold is-size-4">{{ticket.nombre_pelicula}}</p>
                    <span><i class="far fa-clock"></i> {{ticket.hora}} </span>
                    <span>Sala: {{ticket.sala_id}}</span>
                    <div class="tags">
                        <span class="tag is-rounded" v-for="butaca in ticket.butacas">{{butaca.id}}</span>
                    </div>
                </div>
            </div>
            <div class="restaurante-block">
                <div class="item" v-for="item in ticket.items_restaurante">
                    <span class="has-text-weight-bold">{{item.nombre_item}}</span>
                    <span>cantidad: {{item.cantidad}}</span>
                </div>
            </div>
            <div class="precio-total">
                <span class="has-text-weight-bold">TOTAL:</span>
                <span>40€</span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['ticket'],
        name: "pelicula-ticket",
    }
</script>

<style scoped>

    .box-form{
        box-shadow: 0 0 25px rgba(0,0,0,0.08);
        background-color: #fff;
    }

    .box-form:hover{
        box-shadow: 0 0 25px rgba(0,0,0,0.20);
        background-color: #fff;
    }

    .flex-container {
        display: flex;
        align-items: center;
        justify-content: center;
        /* You can set flex-wrap and
           flex-direction individually */
        flex-direction: row;
        flex-wrap: wrap;
        /* Or do it all in one line
          with flex flow */
        flex-flow: row wrap;
        /* tweak where items line
           up on the row
           valid values are: flex-start,
           flex-end, space-between,
           space-around, stretch */
        align-content: flex-end;
    }

    .ticket-block {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .ticket-block > .codigo{
        width: 100px;
        height: 100px;
        background-color: red;
        margin-right: 15px;
    }

    .ticket-block > .entrada{
        background-color: greenyellow;
    }

    .restaurante-block {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .restaurante-block > .item{
        display: flex;
        flex-direction: column;
    }

    .precio-total{
        display: flex;
        justify-content: space-between;
    }


</style>