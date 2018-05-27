<template>
    <div class="section">
        <div class="container">
            <div class="columns is-mobile is-multiline">
                <div class="column is-half-mobile is-one-quarter-desktop">
                    <div class="tarjeta">
                        <div class="titulo is-size-5">
                            Nombre
                        </div>
                        <div class="imagen">
                        </div>
                        <div class="botones-debajo">
                            <div class="alergenos">
                                iconos al..
                            </div>
                            <div class="comprar">
                               comprar
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-half-mobile is-one-quarter-desktop">
                    <div class="tarjeta">
                        <div class="titulo is-size-5">
                            Hola
                        </div>
                        <div class="imagen">
                        </div>
                        <div class="botones-debajo">
                            <div class="alergenos">
                                A B C
                            </div>
                            <div class="comprar">
                                A
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-half-mobile is-one-quarter-desktop">
                    <div class="tarjeta">
                        <div class="titulo is-size-5">
                            Hola
                        </div>
                        <div class="imagen">
                        </div>
                        <div class="botones-debajo">
                            <div class="alergenos">
                                A B C
                            </div>
                            <div class="comprar">
                                A
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "restaurante"
    }
</script>

<style scoped>
    .tarjeta{
        display: flex;
        flex-direction: column;
        align-items: center;

        width: 250px;
        height: auto;

        box-shadow: 0 0 25px rgba(0,0,0,0.08);
        background-color: #fff;
        border-radius: 8px;
        transition: box-shadow 0.5s;
    }

    .tarjeta > .titulo{
        color: grey;
        padding: .2rem;
    }

    .tarjeta > .imagen{
        background: url("https://galicine.es/images/iconos-premios/Premio02.png");
        width: 200px;
        height: 200px;
    }

    .tarjeta > .botones-debajo{
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        padding: 1rem;
    }

    .botones-debajo > .comprar {

    }

</style>