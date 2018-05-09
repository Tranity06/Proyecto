<template>
    <div>
        <span class="subtitle">Método de pago</span>
        <div class="field is-grouped">
            <p class="control">
                <button class="button is-large" @click.prevent="isVisa()">
                    <img src="icons/Visa.svg" alt="Visa">
                </button>
            </p>
            <p class="control">
                <button class="button is-large" @click.prevent="prev()">
                    <img src="icons/PayPal.svg" alt="Paypal">
                </button>
            </p>
        </div>
        <div v-if="visa">
            <label for="name">Nombre: </label>
            <input class="input" type="text" placeholder="Emanuel Suca" id="name" size="5">
            <label for="numero">Número: </label>
            <input class="input" type="text" id="numero" pattern="[0-9]{16,19}" maxlength="19" placeholder="8888-8888-8888-8888" size="5">
            <div class="details">
                    <div class="select">
                        <select>
                            <option>MM</option>
                            <option value="1">01</option>
                            <option value="2">02</option>
                            <option value="3">03</option>
                            <option value="4">04</option>
                            <option value="5">05</option>
                            <option value="6">06</option>
                            <option value="7">07</option>
                            <option value="8">08</option>
                            <option value="9">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                    <span style="font-size: x-large">/</span>
                    <div class="select">
                        <select>
                            <option>YYYY</option>
                            <option value="2016">2016</option>
                            <option value="2017">2017</option>
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                            <option value="2027">2027</option>
                            <option value="2028">2028</option>
                            <option value="2029">2029</option>
                            <option value="2030">2030</option>
                        </select>
                    </div>
            </div>
            <label for="secreto">CVC/CVV: </label>
            <input class="input" type="text" id="secreto" placeholder="123" maxlength="4" width="48">
        </div>
    </div>
</template>

<script>
    export default {
        name: "payment-component",
        data() {
            return {
                visa: false
            }
        },
        methods: {
            isVisa() {
               this.visa = this.visa === false;
            }
        }
    }
</script>

<style scoped>
    .details{
        margin: .5rem 0;
    }
</style>